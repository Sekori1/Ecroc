<?php
include "../connect.php";
include "valideCode.php";

if($VALIDE_CODE){
    if(isset($_REQUEST["quantity"])){
        $quantity = $_REQUEST["quantity"];

        $currentDate = getdate();

        $day = $currentDate["mday"];
        if(strlen($day) == 1){
            $day = "0" . $day; 
        }
        $mon = $currentDate["mon"];
        if(strlen($mon) == 1){
            $mon = "0" . $mon; 
        }
        $dateFormat = $day . "/" . $mon . "/" . $currentDate["year"];

        $request = $bdd->prepare("SELECT * FROM `history` WHERE dogID = ?");
        $request->execute(array($DOG_ID));

        $hCount = $request->rowCount();

        if($hCount > 0){

            $history = $request->fetch();

            $lastDateStr = $history["date"];
            $lastDate = date_create_from_format('d/m/y', $lastUpdate); 

            $interval = $currentDate->diff($lastDate);


            $request = $bdd->prepare("UPDATE `history` SET `j7`=?,`j6`=?,`j5`=?,`j4`=?,`j3`=?,`j2`=?,`j1`=?,`date`=? WHERE dogID = ?");
            $request->execute($parameters);
        }else{
            $parameters = array(0,0,0,0,0,0,$quantity,$DOG_ID);
            $request = $bdd->prepare("INSERT INTO `history`(`j7`, `j6`, `j5`, `j4`, `j3`, `j2`, `j1`, `date`, `dogID`) VALUES (?,?,?,?,?,?,?,?,?)");
            $request->execute($parameters);
        }
    } 
}
?>