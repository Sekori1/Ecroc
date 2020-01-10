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
  		<link rel="stylesheet" href="css/respBox.css">
		<link rel="stylesheet" href="css/nav.css">
		<link rel="stylesheet" href="css/fillable.css">
		<link rel="stylesheet" href="css/edit.css">

		<link rel="stylesheet" type="text/css" media="only screen and (max-width: 999px)" href="css/calendar-mobile.css" />
		<link rel="stylesheet" type="text/css" media="only screen and (min-width: 1000px)" href="css/calendar-desktop.css" />

		<!-- SCRIPT -->

		<script type="text/javascript" src="js/jquery-3.3.1.js"></script>

		<title>test</title>
	</head>
	<body>
	
		<?php include 'navBar.php'; ?>
		<?php include 'dogsBar.php'; ?>

		<?php if($profilFound) { ?></h1>

		<form enctype="multipart/form-data" action="changeInfo.php" method="post">
			<div id="dogInfos" class="container">

				<div id="profilImg" style="background-image: <?php echo $profilImg  ?>">
					<div class="imgInput">
									<input type="hidden" name="dog" value="<?php echo $dogID ?>">
									<input class="inputfile" name="file" type="file" id="file" accept=".png,.jpg,.jpeg"/>
									<label for="file">
										<div>
											<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
												viewBox="0 0 476.737 476.737" style="enable-background:new 0 0 476.737 476.737;" xml:space="preserve">
											<g>
												<g>
													<g>
														<g>
															<polygon points="174.804,349.607 301.934,349.607 301.266,158.912 397.281,158.912 238.369,0 
																79.456,158.912 174.804,158.912 				"/>
															<polygon points="365.499,349.607 365.499,413.172 111.239,413.172 111.239,349.607 47.674,349.607 
																47.674,476.737 429.063,476.737 429.063,349.607 				"/>
														</g>
													</g>
												</g>
											</g>
											</svg>
										</div>
									</label>	
					</div>
				</div>

				<div id="dogInfosContent">
					
						<input class="fillable-text name" type="text" name="name" placeholder="Nom" value="<?php echo $name ?>">
						<input type="hidden" name="dog" value="<?php echo $dogID ?>">
						<button class="fillable-btn"> Enregistrer </button>
			
				</div>

			</div>
		</form>
		<div id="mealCalendar" data-meals="<?php echo $mealConfig ?>" >
			<div class="calendarAlign">
				<div class="calendarGrid">
					<div class="topRow">
						<div class="day">LUNDI</div>
						<div class="day">MARDI</div>
						<div class="day">MERCREDI</div>
						<div class="day">JEUDI</div>
						<div class="day">VENDREDI</div>
						<div class="day">SAMEDI</div>
						<div class="day">DIMANCHE</div>
					</div>
				</div>
				<div id="calendarHeader">
					<a href="#" id="mealAddButton"><svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="46.361px" height="46.361px" viewBox="0 0 46.361 46.361" style="enable-background:new 0 0 46.361 46.361;"xml:space="preserve"><g><path d="M40.225,17.042H29.352V6.148c0-3.39-2.769-6.138-6.159-6.138c-3.389,0-6.157,2.748-6.157,6.138v10.895H6.139C2.75,17.042,0,19.79,0,23.18c0,3.391,2.75,6.139,6.139,6.139h10.897v10.896c0,3.39,2.768,6.138,6.157,6.138c3.39,0,6.159-2.748,6.159-6.138V29.318l10.873,0.002c3.389,0,6.137-2.75,6.137-6.141C46.361,19.79,43.613,17.042,40.225,17.042z"/></g></svg></a>
					<form action="removeMeal.php" method="post">
						<input type="submit" id="deleteSubmit">
						<input type="hidden" name="data" value="test" id="deleteDataImput">
						<input type="hidden" name="dog" value="<?php echo $dogID ?>" >
						<label for="deleteSubmit">
							<a id="deleteButton"><svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 26 26" version="1.1" width="52px" height="52px"><g id="surface1"><path style=" " d="M 11 -0.03125 C 10.164063 -0.03125 9.34375 0.132813 8.75 0.71875 C 8.15625 1.304688 7.96875 2.136719 7.96875 3 L 4 3 C 3.449219 3 3 3.449219 3 4 L 2 4 L 2 6 L 24 6 L 24 4 L 23 4 C 23 3.449219 22.550781 3 22 3 L 18.03125 3 C 18.03125 2.136719 17.84375 1.304688 17.25 0.71875 C 16.65625 0.132813 15.835938 -0.03125 15 -0.03125 Z M 11 2.03125 L 15 2.03125 C 15.546875 2.03125 15.71875 2.160156 15.78125 2.21875 C 15.84375 2.277344 15.96875 2.441406 15.96875 3 L 10.03125 3 C 10.03125 2.441406 10.15625 2.277344 10.21875 2.21875 C 10.28125 2.160156 10.453125 2.03125 11 2.03125 Z M 4 7 L 4 23 C 4 24.652344 5.347656 26 7 26 L 19 26 C 20.652344 26 22 24.652344 22 23 L 22 7 Z M 8 10 L 10 10 L 10 22 L 8 22 Z M 12 10 L 14 10 L 14 22 L 12 22 Z M 16 10 L 18 10 L 18 22 L 16 22 Z "/></g></svg></a>
						</label>
					</form>
					<div id="deleteCounter" class="hide">
						<p>0</p>
					</div>
					<a id="cancelButton" class="hide active">
						<svg enable-background="new 0 0 128 128" height="128px" id="Layer_1" version="1.1" viewBox="0 0 128 128" width="128px" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M81.646,64l22.248-22.249c3.48-3.48,3.474-9.131-0.019-12.623l-5.006-5.005  c-3.489-3.49-9.142-3.499-12.622-0.019L64,46.354L41.753,24.106c-3.484-3.483-9.133-3.472-12.624,0.018l-5.005,5.005  c-3.491,3.492-3.501,9.14-0.018,12.623L46.354,64L24.108,86.246c-3.483,3.484-3.472,9.133,0.018,12.623l5.005,5.006  c3.492,3.492,9.14,3.502,12.623,0.018L64,81.647l22.247,22.246c3.48,3.481,9.131,3.475,12.622-0.019l5.006-5.006  c3.489-3.489,3.498-9.142,0.019-12.622L81.646,64z"/></svg>
					</a>
					<div class="info">
						<p>Selectionnez les elements à supprimer</p>
					</div>
				</div>
			</div>
    	</div>
		<div id="mealAddContainer">
			<div id="mealAdd" class="fillable-box">
					<div class="fillable-title-content">
							<p class="fillable-title"> Ajoutez un repas </p>
					</div>
					<div class="fillable-content">
						<form id="addMealForm" class="" action="addMeal.php" method="get">
							<p>Quantité donnée</p>
							<input min="10" max="500" step="10" class="fillable-text" type="number" name="quantity" value="">
							<p>Heure de distibution</p>
							<input class="fillable-text" type="time" name="hour" value="">
							<p>Jours de distibution</p>
							<div class="mealDaySelectorContainer">
								<div class="mealDaySelector">
										<p class="mealDayItem active lun"><input type="hidden" name="monday" value="true">Lun</p>
										<p class="mealDayItem active mar"><input type="hidden" name="tuesday" value="true">Mar</p>
										<p class="mealDayItem active mer"><input type="hidden" name="wednesday" value="true">Mer</p>
										<p class="mealDayItem active jeu"><input type="hidden" name="thursday" value="true">Jeu</p>
										<p class="mealDayItem active ven"><input type="hidden" name="friday" value="true">Ven</p>
										<p class="mealDayItem active sam"><input type="hidden" name="saturday" value="true">Sam</p>
										<p class="mealDayItem active dim"><input type="hidden" name="sunday" value="true">Dim</p>
								</div>
							</div>
							<input type="hidden" name="dog" value="<?php echo $dogID ?>">
							<div class="allDayContainer">
								<input type="checkbox" checked="true" id="allDays" name="scales">
								<label for="allDays">Tous les jours</label>
							</div>
							<input class="fillable-btn" type="submit" name="mealRequest" value="Ajouter">
						</form>
					</div>
			</div>
		</div>
		<!-- Masque lorsque le formulaire pour ajouter un chien apparait -->
		<div id="mask"></div>
	<?php } ?>
	</body>
	<script type="text/javascript" src="js/dogsBar.js"></script>
	<script type="text/javascript" src="js/calendar.js"></script>
	<script type="text/javascript" src="js/edit.js"></script>

</html>
