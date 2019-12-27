<?php 
session_start();//Debut de la session
if( isset($_REQUEST["logoutRequest"]) ){//L'utilisateur demande à se déconnecter
    $_SESSION["connect"] = null;//On supprime la valeur "TRUE dans la variable de session
    session_destroy();
}
if( isset($_SESSION["connect"]) || isset($_REQUEST["loginRequest"]) ){/*L'utilisateur est connecté (Verification variable session) 
                                                                    ou demande à ce connecter (Verification varaible de requete)*/
    $_SESSION["connect"] = TRUE;//On enregistre "TRUE" dans la variable de session de l'utilisateur
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <div>
        <h1>Vous êtes connecté (Texte ecrit dans les balises HTML)</h1>
        <form action="" method="POST" >
            <input type="submit" name="logoutRequest" value="Déconnectez vous">
        </form>
    </div>
</body>
</html>
<?php
}else{
    echo "Vous n'etes pas connecté (Texte ecrit avec PHP)";
?>
<form action="" method="POST" >
    <input type="submit" name="loginRequest" value="Connectez vous">
</form>
<?php
}
?>
