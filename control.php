<?php
session_start();

require 'connect.php'; /* Connexion à la base données*/
require "logged.php"; /* Verification de la connection*/

include "dogSelector.php"; /* Page consacré à un chien en particulier, selection automatique via URL */

?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset="utf-8">

		<!-- VIEWPORT -->
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<!-- STYLE -->
		<link rel="stylesheet" href="css/dogsBar.css">
		<link rel="stylesheet" href="css/nav.css">
		<link rel="stylesheet" href="css/fillable.css">
		<link rel="stylesheet" href="css/control.css">

		<script type="text/javascript" src="js/jquery-3.3.1.js"></script>

		<title>test</title>
	</head>
	<body>
		<?php include 'navBar.php'; ?>
		<?php include 'dogsBar.php'; ?>
		<div id="control-content" class="container">
		<?php
			if($profilFound) {
		?>
			<div id="dog-header-container">
					<div class="photo" style="background-image: <?php echo $profilImg  ?>"></div>
					<h2><?php echo $name ?></h2>
					<a class="editButton" href="edit.php?dog= <?php echo $dogID ?>">
						<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 21.589 21.589" style="enable-background:new 0 0 21.589 21.589;" xml:space="preserve"> <g> <path d="M18.622,8.371l-0.545-1.295c0,0,1.268-2.861,1.156-2.971l-1.679-1.639c-0.116-0.113-2.978,1.193-2.978,1.193l-1.32-0.533 c0,0-1.166-2.9-1.326-2.9H9.561c-0.165,0-1.244,2.906-1.244,2.906L6.999,3.667c0,0-2.922-1.242-3.034-1.131L2.289,4.177 C2.173,4.29,3.507,7.093,3.507,7.093L2.962,8.386c0,0-2.962,1.141-2.962,1.295v2.322c0,0.162,2.969,1.219,2.969,1.219l0.545,1.291 c0,0-1.268,2.859-1.157,2.969l1.678,1.643c0.114,0.111,2.977-1.195,2.977-1.195l1.321,0.535c0,0,1.166,2.898,1.327,2.898h2.369 c0.164,0,1.244-2.906,1.244-2.906l1.322-0.535c0,0,2.916,1.242,3.029,1.133l1.678-1.641c0.117-0.115-1.22-2.916-1.22-2.916 l0.544-1.293c0,0,2.963-1.143,2.963-1.299v-2.32C21.59,9.425,18.622,8.371,18.622,8.371z M14.256,10.794 c0,1.867-1.553,3.387-3.461,3.387c-1.906,0-3.461-1.52-3.461-3.387s1.555-3.385,3.461-3.385 C12.704,7.41,14.256,8.927,14.256,10.794z"/> <g>	</svg>
						<p>Configuration</p>
					</a>
			</div>
			<div class="row">
				<div class="col-lg-6">
					<div id="meal-info-container" data-meals="<?php echo $mealConfig ?>" >
						<!-- PARTIE HAUTE - AFFICHE LE CONTENU -->
						<div class="meal-container">
							<div class="meal-displayer-container">
								<!-- CONTIENT TOUS LES ELEMENTS DE REPAS - N AFFICHE QU UN ELEMENT A LA FOIS -->
								<!--<div class="meal-displayer">
									<div class="meal">
										<h4 class="food-amount">100g<h4>
										<p class="food-hour">7h30</p>
									</div>
									<div class="meal">
										<h4 class="food-amount">150g<h4>
										<p class="food-hour">13h30</p>
									</div>
									<div class="meal">
										<h4 class="food-amount">80g<h4>
										<p class="food-hour">21h30</p>
									</div>
								</div>-->
							</div>
						</div>
						<!-- PARTIE BASSE - SELECTEUR DE DATE -->
						<div class="selector-container">
							<div id="before-meal-button"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 405.456 405.456" style="enable-background:new 0 0 405.456 405.456;" xml:space="preserve"><g><path d="M341.31,74.135c-0.078-4.985-2.163-9.911-5.688-13.438l-55-55C277.023,2.096,271.963,0,266.872,0s-10.151,2.096-13.75,5.697L69.841,188.978c-3.601,3.599-5.697,8.659-5.697,13.75s2.096,10.151,5.697,13.75l183.281,183.281c3.599,3.601,8.659,5.697,13.75,5.697s10.151-2.096,13.75-5.697l55-55c3.591-3.598,5.681-8.651,5.681-13.734s-2.09-10.136-5.681-13.734L221.06,202.728L335.622,88.166C339.287,84.499,341.387,79.318,341.31,74.135L341.31,74.135z"/></g></svg></div>
							<!-- CONTIENT TOUS LES ELEMENTS DE DATE - N AFFICHE QU UN ELEMENT A LA FOIS -->
							<div class="day-displayer-container">
								<!-- EXEMPLE D ELEMENT DATE
								<p class="day-displayer">Vendredi 8 Mars</p>
								<p class="day-displayer today">Samedi 9 Mars</p>
								<p class="day-displayer">Dimanche 10 Mars</p>-->
							</div>
							<div id="after-meal-button"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 405.457 405.457" style="enable-background:new 0 0 405.457 405.457;" xml:space="preserve"><g><path d="M64.147,331.322c0.078,4.985,2.163,9.911,5.688,13.438l55,55c3.599,3.601,8.659,5.697,13.75,5.697c5.091,0,10.151-2.096,13.75-5.697l183.281-183.282c3.601-3.599,5.697-8.659,5.697-13.75s-2.096-10.151-5.697-13.75L152.335,5.697C148.736,2.096,143.676,0,138.585,0c-5.091,0-10.151,2.096-13.75,5.697l-55,55c-3.591,3.598-5.681,8.651-5.681,13.734s2.09,10.136,5.681,13.734l114.562,114.563L69.835,317.291C66.171,320.958,64.07,326.139,64.147,331.322L64.147,331.322z"/></g></svg></div>
						</div>
					</div>
					<div id="history">
						<p id="graphMax">?</p>
						<div class="marginHistory">
							<div id="graph" data-history="<?php echo $history ?>">
								<canvas class="graphCanvas">

								</canvas>
							</div>
						</div>
						<div class="bottomHistory">
							<div class="marginHistory">
								<div class="bottomGraph">
									<p class="day" id="j7"></p>
									<p class="day" id="j6"></p>
									<p class="day" id="j5"></p>
									<p class="day" id="j4"></p>
									<p class="day" id="j3"></p>
									<p class="day" id="j2"></p>
									<p class="day" id="j1"></p>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-6">
					<p class="notifHeader">Notifications</p>
					<div id="notifContainer">

						<div id="notifFlex">
							<?php

							$notifRequest = $bdd->prepare("SELECT * FROM notification WHERE ownerID = ? AND dogID = ? ORDER BY id DESC");
							$notifRequest->execute(array($ownerID, $dogID));

							while($notif =  $notifRequest->fetch()){
							?>
								<div class="notifBox">
									<h3 class="notifTitle"><?php echo utf8_encode($notif["title"]); ?></h3>
									<p class="notifContent"><?php echo utf8_encode($notif["content"]); ?></p>
									<p class="notifDate"><?php echo $notif["date"]; ?></p>
								</div>
							<?php
								$notifViewRequest = $bdd->prepare("UPDATE notification SET notify = '0' WHERE id = ?");
								$notifViewRequest->execute(array($notif["id"]));
							}
							?>
						</div>
					</div>
				</div>
			</div>
		<?php
			}
		?>
		</div>

	</body>

	<script type="text/javascript" src="js/svg.js"></script>
	<script type="text/javascript" src="js/history.js"></script>
	<script type="text/javascript" src="js/dogsBar.js"></script>
	<script type="text/javascript" src="js/meal-info.js"></script>
	<script type="text/javascript" src="js/notifPage.js"></script>
</html>
