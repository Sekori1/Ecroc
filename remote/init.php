<?php 
    require '../connect.php';//Connexion à la base de données

    $char = array("A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z","1","2","3","4","5","6","7","8","9");
    $code = "";//Variable contenant le code aléatoire
    $find = false;

    while(!$find){//Generation du code aléatoire à 6 caracteres
        for ($i=0; $i < 6; $i++) {
            $r = $char[rand(0,(count($char)-1))];
            $code .= $r;
        }
        /* Verification de la non existance du code generé */
        $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE code = ?");
        $SQLrequest->execute(array($code));
        $find = $SQLrequest->rowCount() < 1;
    }
    $SQLrequest = $bdd->prepare("INSERT INTO `dogs`(`code`) VALUES (?)");
    $SQLrequest->execute(array($code));//Le code est enregistrer dans la base de données

    echo $code;
?>


