<?php 

session_start();

require 'connect.php'; /* Connexion à la base données*/
require "logged.php"; /* Verification de la connection*/
 
// Constantes
define('TARGET', 'images/private/dogs/');    // Repertoire cible
define('MAX_SIZE', 100000000);    // Taille max en octets du fichier
define('WIDTH_MAX', 4000);    // Largeur max de l'image en pixels
define('HEIGHT_MAX', 4000);    // Hauteur max de l'image en pixels
 
$tabExt = array('jpg','png','jpeg');    // Extensions autorisees
$infosImg = array();
 
$extension = '';
$message = '';
$nomImage = '';

if(!empty($_POST))
{
    $dogID = $_REQUEST["dog"];

    $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE id = ?");
    $SQLrequest->execute(array($dogID));
    $rowAmount = $SQLrequest->rowCount();

    /******************/
            //Verification du propriétaire du chien
    /******************/
    if($rowAmount > 0 &&  $SQLrequest->fetch()["ownerID"] == $ownerID){ /* Verification du propriétaire du chien */
        
        /******************/
            //Changement du nom du chien
        /******************/

        // On verifie si le champ est rempli
        if( !empty($_REQUEST["name"]) ){
            $name = strip_tags(trim($_REQUEST['name']));
            if($name != ""){
                $request = $bdd->prepare("UPDATE `dogs` SET `name`=? WHERE id = ?");
                $request->execute(array($name, $dogID));
            }
        }

        /******************/
            //Changement de l'image du chien
        /******************/

        // On verifie si le champ est rempli
        if( !empty($_FILES['file']['name']) ) {
            // Recuperation de l'extension du fichier
            $extension  = pathinfo($_FILES['file']['name'], PATHINFO_EXTENSION);
            // On verifie l'extension du fichier
            if(in_array(strtolower($extension),$tabExt)){
                // On recupere les dimensions du fichier
                $infosImg = getimagesize($_FILES['file']['tmp_name']);
                // On verifie le type de l'image
                if($infosImg[2] >= 1 && $infosImg[2] <= 14){
                    // On verifie les dimensions et taille de l'image
                    if(($infosImg[0] <= WIDTH_MAX) && ($infosImg[1] <= HEIGHT_MAX) && (filesize($_FILES['file']['tmp_name']) <= MAX_SIZE)){
                        // Parcours du tableau d'erreurs
                        if(isset($_FILES['file']['error']) && UPLOAD_ERR_OK === $_FILES['file']['error']){
                            // On renomme le fichier
                            $nomImage = 'dog' . $dogID . '.' . $extension;
                            // Si c'est OK, on teste l'upload
                            if(move_uploaded_file($_FILES['file']['tmp_name'], TARGET.$nomImage)){
                                for ($i=0; $i < sizeof($tabExt); $i++) {
                                    $fileName = TARGET."dog" . $dogID . "." . $tabExt[$i];
                                    if(file_exists ($fileName) && $extension != $tabExt[$i] ){
                                        unlink($fileName);//On supprime les images du meme nom, avec une extension differente
                                    }
                                }
                                $message = 'Upload réussi !';
                            }else{
                                $message = 'Problème lors de l\'upload !';
                            }
                        }else{
                            $message = 'Une erreur interne a empêché l\'uplaod de l\'image';
                        }
                    }else{
                        $message = 'Erreur dans les dimensions de l\'image !';
                    }
                }
                else{
                    $message = 'Le fichier à uploader n\'est pas une image !';
                }
            }else{
                $message = 'L\'extension du fichier est incorrecte !';
            }
        }else{
            $message = 'Veuillez remplir le formulaire svp !';
        }
        header("Location: ./edit.php?dog=" . $dogID);
    }else{
        header("Location: ./edit.php");
    }
}
?>