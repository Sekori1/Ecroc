<?php
    session_start();

    require 'connect.php'; /* Connexion à la base données*/
    require "logged.php"; /* Verification de la connection*/

    $newDogRequest = isset($_REQUEST["mealRequest"]);

    if($newDogRequest && isset($_REQUEST["dog"]) && isset($_REQUEST["quantity"]) && isset($_REQUEST["hour"])){
        $dogID = $_REQUEST["dog"];
        $quantity = $_REQUEST["quantity"];
        $hour = $_REQUEST["hour"];

        $daysName = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");

        $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE id = ?");
        $SQLrequest->execute(array($dogID));
        $rowAmount = $SQLrequest->rowCount();

        if($rowAmount > 0 && strlen($hour) == 5 && preg_match("#^[0-9]+$#", $quantity)){
            $SQLinfo = $SQLrequest->fetch();
        	if($SQLinfo["ownerID"] == $ownerID){ /* Verification du propriétaire du chien */

                $SQLrequest = $bdd->prepare("SELECT * FROM meal_config WHERE dogID = ?");
                $SQLrequest->execute(array($dogID));

                $configExist = $SQLrequest->rowCount() > 0;
                $newValue = array();

                if($configExist){
                    $SQLinfo = $SQLrequest->fetch();
    
                    for ($i = 0; $i < 7; $i++) {
                        $day = $daysName[$i];
                        $initialValue = $SQLinfo[$day];

                        $total = array(0,0,0,0,0,0,0);
                        $mealAmount = array(0,0,0,0,0,0,0);
                        $splitedCurrentMealData = explode("|",$SQLinfo[$day]);
                        $meal = array(7);
                        for($j = 0; $j < count($splitedCurrentMealData); $j++){
                            $meal[$i] = explode(":",$splitedCurrentMealData[$j]);
                            if(count($meal[$i]) == 2){
                                $total[$i] += $meal[$i][1];
                                $mealAmount[$i]++;
                            }
                        }

                        if($_REQUEST[$day] == "true" && ($total[$i] + $quantity) <= 500 && $mealAmount[$i] <= 3){
                            $formatHour = str_replace(":", "", $hour);
                            if( !(strpos( $initialValue, $formatHour) !== false) ) {
                                $initialValue .= $formatHour;
                                $initialValue .= ":" . $quantity . "|";   
                            }
                        }
                        $newValue[$i] = $initialValue;
                    }
                    $newValue[7] = $dogID;
                    $SQLrequest = $bdd->prepare("UPDATE `meal_config` SET `monday`=?,`tuesday`=?,`wednesday`=?,`thursday`=?,`friday`=?,`saturday`=?,`sunday`=? WHERE dogID = ?");
                    $SQLrequest->execute($newValue);
                }else{
                    $newValue[0] = $dogID;
                    for ($i = 0; $i < 7; $i++) {
                        $day = $daysName[$i];
                        $value = "";
                        if($_REQUEST[$day] == "true" && $quantity <= 500){
                            $value .= str_replace(":", "", $hour);
                            $value .= ":" . $quantity . "|";
                        }
                        $newValue[($i+1)] = $value;
                    }                    

                    $SQLrequest = $bdd->prepare("INSERT INTO `meal_config`(`dogID`, `monday`, `tuesday`, `wednesday`, `thursday`, `friday`, `saturday`, `sunday`) VALUES (?,?,?,?,?,?,?,?)");
                    $SQLrequest->execute($newValue);
                }

            /* TODO Ajouter les données dans la BDD */

        	}
        }
        header("Location: ./edit.php?dog=" . $dogID);
    }else{
        header("Location: ./edit.php");
    }
?>
