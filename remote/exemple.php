<?php
session_start();//On demarre la session de l'utilisateur
if(isset($_GET["name"])){//Si le nom de l'utilisateur est en paramtere dans l'URL ( site.fr?name=NAME )
    $_SESSION["name"] = $_GET["name"];//On enregistre le nom de l'utilisateur dans la varaible de session
}
if(isset($_SESSION["name"])){//Si la session de l'utilisateur contient son nom, ECRIRE:
?>
    <h1>Votre nom est enregister dans votre variable de session:</h1>
<?php 
    echo $_SESSION["name"];
}else{//Sinon, ECRIRE:
?>
    <h1>Nous ne connaissons pas votre nom, placé votre nom en paramtere 
        de l'URL comme ceci pour l'enregister:</h1>
    <a href="ecroc.fr?name=VOTRE_NOM">ecroc.fr?name=VOTRE_NOM</a>
<?php           
}
?>
