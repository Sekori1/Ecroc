<?php 
    session_start();

    require 'connect.php'; /* Connexion à la base données*/
    require "logged.php"; /* Verification de la connection*/

    $dogID = $_REQUEST["dog"];
    $name = $_REQUEST["name"];

    $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE id = ?");
    $SQLrequest->execute(array($dogID));
    $rowAmount = $SQLrequest->rowCount();

    if($rowAmount > 0 &&  $SQLrequest->fetch()["ownerID"] == $ownerID){ /* Verification du propriétaire du chien */
    
        $request = $bdd->prepare("UPDATE `dogs` SET `name`=? WHERE id = ?");
        $request->execute(array($name, $dogID));
        header("Location: ./edit.php?dog=" . $dogID);
    }else{
        header("Location: ./edit.php");
    }
?>