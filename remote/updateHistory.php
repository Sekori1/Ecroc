<?php 
include "../connect.php";
include "valideCode.php";

if($VALIDE_CODE){
    if(isset($_REQUEST["date"])){
        $date = $_REQUEST["date"];
        if(preg_match("#^([0-3][0-9])(\/)([0-9]{2})(\/)([0-9]{4})$#", $date )){
            $parameters = array();
            for ($i=0; $i < 7; $i++) {
                $day = "j" . (7 - $i); 
                if(isset($_REQUEST[$day]) ){
                    $parameters[$i] = $_REQUEST[$day];
                }else{
                    $parameters[$i] = 0;
                }
            }
            $parameters[7] = $date;
            $parameters[8] = $DOG_ID;

            $request = $bdd->prepare("SELECT * FROM `history` WHERE dogID = ?");
            $request->execute(array($DOG_ID));
            $hCount = $request->rowCount();

            if($hCount > 0){
                $request = $bdd->prepare("UPDATE `history` SET `j7`=?,`j6`=?,`j5`=?,`j4`=?,`j3`=?,`j2`=?,`j1`=?,`date`=? WHERE dogID = ?");
                $request->execute($parameters);
            }else{
                $request = $bdd->prepare("INSERT INTO `history`(`j7`, `j6`, `j5`, `j4`, `j3`, `j2`, `j1`, `date`, `dogID`) VALUES (?,?,?,?,?,?,?,?,?)");
                $request->execute($parameters);
            }
        }
    } 
}
?>