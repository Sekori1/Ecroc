<?php
    session_start();

    require 'connect.php'; /* Connexion à la base données*/
    require "logged.php"; /* Verification de la connection*/

    $newDogRequest = isset($_REQUEST["Code"]);

    if($newDogRequest){
        $code = $_REQUEST["Code"];

        $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE ownerID = ?");
        $SQLrequest->execute(array($ownerID));
        $newDogName = $SQLrequest->rowCount() + 1;

        /*
        $SQLrequest = $bdd->prepare("INSERT INTO dogs(`ownerID`, `name`) VALUES($ownerID, 'Chien $newDogName')");
        $SQLrequest->execute(array($dogID));
        $rowAmount = $SQLrequest->rowCount();
        $newDogID = $bdd->lastInsertId();
        */

        $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE code = ?");
        $SQLrequest->execute(array($code));
        $find = $SQLrequest->rowCount() == 1;

        echo $find;

        if($find){
            $row = $SQLrequest->fetch();
            $SQLrequest = $bdd->prepare("UPDATE `dogs` SET `ownerID`=?,`name`=? WHERE code = ?");
            $SQLrequest->execute(array($ownerID,("Chien " . $newDogName), $code));
        }

        header("Location: ./edit.php?dog=" . $newDogID);
    }else{
        header("Location: ./edit.php");
    }
?>
