<?php
    session_start();

    include_once "connect.php";

    /*
        Recuperation des images sécurisé:
        L'utilisateur n'a pas acces au dossier "images"
        On verifie que celui ci à le droit de consulter l'image qu'il demande avant de lui renvoyer l'image.
    */

    $img = "images/private/dogs/default.png";
    if(!isset($_GET["id"])){
        readfile($img);
        exit();
    }
    $dogID = $_GET["id"];

    $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE id = ?");
    $SQLrequest->execute(array($dogID));
	$rowAmount = $SQLrequest->rowCount();

	if($rowAmount > 0){
		$SQLinfo = $SQLrequest->fetch();
		if($SQLinfo["ownerID"] == $_SESSION["id"]){
            $ext = array("png", "jpg");
            for ($i=0; $i < sizeof($ext); $i++) {
                $fileName = "images/private/dogs/dog" . $dogID . "." . $ext[$i];
                if(file_exists ($fileName) ){
                     $img = $fileName;
                     break;
                }
            }

		}
	}

  readfile($img);
?>
