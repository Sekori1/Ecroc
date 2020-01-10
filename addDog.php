<?php
    session_start();

    require 'connect.php'; /* Connexion à la base données*/
    require "logged.php"; /* Verification de la connection*/

    $newDogRequest = isset($_REQUEST["Code"]);
    $codeDemo = "DEMO";

    if($newDogRequest){
        $code = $_REQUEST["Code"];

        if($code == $codeDemo) {
            $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE ownerID = ?");
            $SQLrequest->execute(array($ownerID));
            $newDogName = $SQLrequest->rowCount() + 1;

            $SQLrequest = $bdd->prepare("INSERT INTO `dogs`(`ownerID`, `name`, `code`) VALUES (?,?,?)");
            $SQLrequest->execute(array($ownerID,("DEMO " . $newDogName), $code));//Le code est enregistrer dans la base de données

            header("Location: ./edit.php?dog=" . $bdd->lastInsertId() );
        
        }else {
  
            $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE code = ?");
            $SQLrequest->execute(array($code));
            $find = $SQLrequest->rowCount() == 1;
       
            if($find){
                $SQLinfo = $SQLrequest->fetch();
                if($SQLinfo["ownerID"] == NULL){
                    $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE ownerID = ?");
                    $SQLrequest->execute(array($ownerID));
                    $newDogName = $SQLrequest->rowCount() + 1;
    
                    $row = $SQLrequest->fetch();
                    $SQLrequest = $bdd->prepare("UPDATE `dogs` SET `ownerID`=?,`name`=? WHERE code = ?");
                    $SQLrequest->execute(array($ownerID,("Chien " . $newDogName), $code));
                    
                    header("Location: ./edit.php?dog=" . $bdd->lastInsertId() );
                } else{
                    header("Location: ./edit.php");
                }
            } else{
                header("Location: ./edit.php");
            }
        }
    } else {
        header("Location: ./edit.php");
    }
    


?>
