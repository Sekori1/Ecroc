<?php
$isLogged = isset($_SESSION["id"]);
$ownerID = $_SESSION["id"];

if(!$isLogged){
	header('Location: index.php');
	exit();
}
?>
