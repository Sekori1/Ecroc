<?php
    session_start();

    require 'connect.php'; /* Connexion à la base données*/
    require "logged.php"; /* Verification de la connection*/

    $daysName = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");

    if(isset($_REQUEST["dog"]) && isset($_REQUEST["data"])){
        $dogID = $_REQUEST["dog"];

        /* Verification du propriétaire du chien */
        $sqlDogInfoRequest = $bdd->prepare("SELECT * FROM dogs WHERE id = ?");
        $sqlDogInfoRequest->execute(array($dogID));
        $sqlDogInfoAmount = $sqlDogInfoRequest->rowCount();
    
        if($sqlDogInfoAmount > 0){
            $sqlDogInfo = $sqlDogInfoRequest->fetch();
            if($sqlDogInfo["ownerID"] == $ownerID){

                /* On transforme les données en ligne en tableau*/
                $STR_DELETE_DATA_REQUEST = $_REQUEST["data"];
                $DELETE_DATA_REQUEST = explode('/',$STR_DELETE_DATA_REQUEST);
                for($i = 0; $i < count($DELETE_DATA_REQUEST); $i++){
                    $DELETE_DATA_REQUEST[$i] = explode(":",$DELETE_DATA_REQUEST[$i]);
                }
        
                /* Requete pour recuperer la configuration des repas existants */
                $sqlMealInfoRequest = $bdd->prepare("SELECT * FROM meal_config WHERE dogID = ?");
                $sqlMealInfoRequest->execute(array($dogID));
                $sqlMealInfoAmount = $sqlMealInfoRequest->rowCount();

                if($sqlMealInfoAmount > 0){
                    $sqlMealInfo = $sqlMealInfoRequest->fetch();

                    $NEW_MEAL_DATA = array();

                    for($i = 0; $i < 7; $i++){
                        $NEW_MEAL_DATA[$i] = "";
                        $splitedCurrentMealData = explode("|",$sqlMealInfo[$daysName[$i]]);
                        for($j = 0; $j < count($splitedCurrentMealData); $j++){
                            $value = $splitedCurrentMealData[$j];

                            $mealOfDay = $DELETE_DATA_REQUEST[$i];

                            $testC = true;

                            for($k = 0; $k < count($mealOfDay); $k++){
                                if( $mealOfDay[$k] != "" && strpos( $value, $mealOfDay[$k] ) !== false) {
                                    $testC = false;
                                }
                            }

                            if($testC && $value != ""){
                                $NEW_MEAL_DATA[$i] .= $value . "|";
                            }
                        }
                
                    }

                    $NEW_MEAL_DATA[7] = $dogID;

                    $SQLrequest = $bdd->prepare("UPDATE `meal_config` SET `monday`=?,`tuesday`=?,`wednesday`=?,`thursday`=?,`friday`=?,`saturday`=?,`sunday`=? WHERE dogID = ?");
                    $SQLrequest->execute($NEW_MEAL_DATA);

                }

                header("Location: ./edit.php?dog=" . $dogID);               
            }else{
                header("Location: ./edit.php");
            }
        }else{
            header("Location: ./edit.php");
        }
    }else{
        header("Location: ./edit.php");
    }
?>
