<?php
$profilFound = false;

if(isset($_GET["dog"])){
	$dogID = $_GET["dog"];

	$SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE id = ?");
    $SQLrequest->execute(array($dogID));
	$rowAmount = $SQLrequest->rowCount();

	if($rowAmount > 0){
		$SQLinfo = $SQLrequest->fetch();
		if($SQLinfo["ownerID"] == $ownerID){ /* Verification du propriétaire du chien */
			selectProfil($SQLinfo);
		}
	}
}
if(!$profilFound){
	$SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE ownerID = ?");
	$SQLrequest->execute(array($ownerID));
	$rowAmount = $SQLrequest->rowCount();

	if($rowAmount > 0) {
		$SQLinfo = $SQLrequest->fetch();
		selectProfil($SQLinfo);
	}
}

function selectProfil($SQLinfo){
	global $bdd, $name,$profilFound, $profilImg, $history, $dogID, $mealConfig;
 	$name = $SQLinfo["name"];
	$dogID = $SQLinfo["id"];
	$profilImg = "url(privateProfileImage.php?id=" . urlencode($dogID);
	$profilFound = true;

	$history = "0,0,0,0,0,0,0";
	$mealConfig = "";

	$SQLrequest = $bdd->prepare("SELECT * FROM history WHERE dogID = ?");
	$SQLrequest->execute(array($dogID));
	$rowAmount = $SQLrequest->rowCount();

	if($rowAmount > 0){
		$data = $SQLrequest->fetch();
		$history = 	$data["j7"] . "," .
					$data["j6"] . "," .
					$data["j5"] . "," .
					$data["j4"] . "," .
					$data["j3"] . "," .
					$data["j2"] . "," .
					$data["j1"] . "," .
					$data["date"];
	}

	$SQLrequest = $bdd->prepare("SELECT * FROM meal_config WHERE dogID = ?");
	$SQLrequest->execute(array($dogID));
	$rowAmount = $SQLrequest->rowCount();

	if($rowAmount > 0){
		$data = $SQLrequest->fetch();
		$mealConfig = $data["monday"] . "," .
					$data["tuesday"] . "," .
					$data["wednesday"] . "," .
					$data["thursday"] . "," .
					$data["friday"] . "," .
					$data["saturday"] . "," .
					$data["sunday"];
	}
}

?>
