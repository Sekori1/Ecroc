<?php 

if(isset($_REQUEST["code"])){
    $code = $_REQUEST["code"];

    $request = $bdd->prepare("SELECT * FROM `dogs` WHERE code = ?");
    $request->execute(array($code));

    $VALIDE_CODE = $request->rowCount() > 0;
    $DOG_ID = $request->fetch()["id"];

}
?>