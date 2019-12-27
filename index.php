<?php
session_start();

/* CONNECTION À LA BASE DE DONNÉE */
require 'connect.php';

$isLogged = isset($_SESSION["id"]);

/* SI L'UTILISATEUR N'EST PAS CONNECTÉ */
if(!$isLogged){
	/* L'UTILISATEUR DEMANDE À SE CONNECTER */
	if( isset($_POST["loginRequest"]) ) {

		$mail = getSafeInfo("mail");
		$password = getSafeInfo("password");

		if($mail AND $password){
			$SQLrequest = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
			$SQLrequest->execute(array($mail));

			$rowAmount = $SQLrequest->rowCount();
			if($rowAmount == 1) {
				$SQLinfo = $SQLrequest->fetch();
				$cryptPassword = $SQLinfo['password'];
				if(password_verify($password, $cryptPassword)){
					login($SQLinfo['id'],$SQLinfo['firstname'], $SQLinfo['lastname'], $mail);
					$isLogged = true;
				}
			}
		}

	}
	 /* L'UTILISATEUR DEMANDE À CRÉER UN COMPTE */
	else if ( isset($_POST["registerRequest"]) ) {
		$firstName = getSafeInfo("firstname");
		$lastName = getSafeInfo("lastname");
		$mail = getSafeInfo("mail");
		$password = getSafeInfo("password");
		$passwordConfirm = getSafeInfo("passwordconfirm");
		/* Verification element non null*/
		if($firstName && $lastName && $mail && $password && $passwordConfirm) {
			/* Nom et Prénom ne font pas plus de 30 caracteres*/
			if(strlen($firstName) <= 30 AND strlen($lastName) <= 30) {
				/* Les 2 mots de passe correspondes*/
				if($password == $passwordConfirm){
					/* L'adresse email est valide*/
					if(filter_var($mail, FILTER_VALIDATE_EMAIL)) {
						$SQLrequest = $bdd->prepare("SELECT * FROM users WHERE mail = ?");
						$SQLrequest->execute(array($mail));
						/* L'adresse email n'est pas déjà utilisé */
						if(($SQLrequest->rowCount()) == 0){
							$hashPassword = password_hash($password, PASSWORD_DEFAULT); /* Hash du mot de passe (sécurité) */
							$SQLrequest = $bdd->prepare("INSERT INTO users(firstname, lastname, mail, password) VALUES(?, ?, ?, ?)");
							$SQLrequest->execute(array($firstName, $lastName, $mail, $hashPassword));
							$id = $bdd->lastInsertId(); /* On récupere l'id de la ligne ajouté à la BDD*/
							login($id, $firstName, $lastName, $mail);
							$isLogged = true;
						}
					}
				}
			}
		}
	}
}

/* Methode pour connecter l'utilisateur */
function login($id, $firstName, $lastName, $mail){
	$_SESSION['id'] = $id;
	$_SESSION['firstname'] = $firstName;
	$_SESSION['lastname'] = $lastName;
	$_SESSION['mail'] = $mail;
	static $isLogged = true;
}
/* Methode pour recuperer les infos POST sans erreur */
function getSafeInfo($name){
	if( isset($_POST[$name]) ) {
		return htmlspecialchars($_POST[$name]);
	}else {
		return null;
	}
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
	<head>
		<meta charset="utf-8">
		<!-- VIEWPORT -->
		<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, shrink-to-fit=no">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

		<!-- STYLE -->
		<link rel="stylesheet" href="css/fillable.css">
		<link rel="stylesheet" href="css/nav.css">
		<link rel="stylesheet" href="css/index.css">

		<title>Dosecorc</title>
	</head>
	<body>
		<?php include 'navBar.php'; ?>
		<div id="home">
			<?php
				if(!$isLogged){
			?>
				<div class="row justify-content-end">
					<div class="fillalbe-align col-md-7">
						<div id="fillable-position">
							<!-- INSCRIPTION -->
							<div id="register" class="fillable-box mask">
								<div class="fillable-title-content">
									<p class="fillable-title"> Inscrivez-vous </p>
								</div>
								<div class="fillable-content">
									<form method="POST" action="">
										<div class="names">
											<input class="fillable-text firstname" type="text" name="firstname" placeholder="Prénom">
											<input class="fillable-text lastname" type="text" name="lastname" placeholder="Nom">
										</div>
										<div class="fillable-text-icon">
											<svg fill="#444" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 490.2 490.2" style="enable-background:new 0 0 490.2 490.2;" xml:space="preserve"> <g> <path d="M420.95,61.8C376.25,20.6,320.65,0,254.25,0c-69.8,0-129.3,23.4-178.4,70.3s-73.7,105.2-73.7,175 c0,66.9,23.4,124.4,70.1,172.6c46.9,48.2,109.9,72.3,189.2,72.3c47.8,0,94.7-9.8,140.7-29.5c15-6.4,22.3-23.6,16.2-38.7l0,0 c-6.3-15.6-24.1-22.8-39.6-16.2c-40,17.2-79.2,25.8-117.4,25.8c-60.8,0-107.9-18.5-141.3-55.6c-33.3-37-50-80.5-50-130.4 c0-54.2,17.9-99.4,53.6-135.7c35.6-36.2,79.5-54.4,131.5-54.4c47.9,0,88.4,14.9,121.4,44.7s49.5,67.3,49.5,112.5 c0,30.9-7.6,56.7-22.7,77.2c-15.1,20.6-30.8,30.8-47.1,30.8c-8.8,0-13.2-4.7-13.2-14.2c0-7.7,0.6-16.7,1.7-27.1l18.6-152.1h-64 l-4.1,14.9c-16.3-13.3-34.2-20-53.6-20c-30.8,0-57.2,12.3-79.1,36.8c-22,24.5-32.9,56.1-32.9,94.7c0,37.7,9.7,68.2,29.2,91.3 c19.5,23.2,42.9,34.7,70.3,34.7c24.5,0,45.4-10.3,62.8-30.8c13.1,19.7,32.4,29.5,57.9,29.5c37.5,0,69.9-16.3,97.2-49 c27.3-32.6,41-72,41-118.1C488.05,152.9,465.75,103,420.95,61.8z M273.55,291.9c-11.3,15.2-24.8,22.9-40.5,22.9 c-10.7,0-19.3-5.6-25.8-16.8c-6.6-11.2-9.9-25.1-9.9-41.8c0-20.6,4.6-37.2,13.8-49.8s20.6-19,34.2-19c11.8,0,22.3,4.7,31.5,14.2 s13.8,22.1,13.8,37.9C290.55,259.2,284.85,276.6,273.55,291.9z"/> </g> </svg>
											<span> </span>
											<input type="text" name="mail" placeholder="Adresse mail">
										</div>
										<div class="fillable-text-icon">
											<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g><path d="M437.333,192h-32v-42.667C405.333,66.99,338.344,0,256,0S106.667,66.99,106.667,149.333V192h-32C68.771,192,64,196.771,64,202.667v266.667C64,492.865,83.135,512,106.667,512h298.667C428.865,512,448,492.865,448,469.333V202.667C448,196.771,443.229,192,437.333,192z M287.938,414.823c0.333,3.01-0.635,6.031-2.656,8.292c-2.021,2.26-4.917,3.552-7.948,3.552h-42.667c-3.031,0-5.927-1.292-7.948-3.552c-2.021-2.26-2.99-5.281-2.656-8.292l6.729-60.51c-10.927-7.948-17.458-20.521-17.458-34.313c0-23.531,19.135-42.667,42.667-42.667s42.667,19.135,42.667,42.667c0,13.792-6.531,26.365-17.458,34.313L287.938,414.823z M341.333,192H170.667v-42.667C170.667,102.281,208.948,64,256,64s85.333,38.281,85.333,85.333V192z"/></g></g></svg>
											<span> </span>
											<input type="password" name="password" placeholder="Mot de passe">
										</div>
										<div class="fillable-text-icon">
											<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g><path d="M437.333,192h-32v-42.667C405.333,66.99,338.344,0,256,0S106.667,66.99,106.667,149.333V192h-32C68.771,192,64,196.771,64,202.667v266.667C64,492.865,83.135,512,106.667,512h298.667C428.865,512,448,492.865,448,469.333V202.667C448,196.771,443.229,192,437.333,192z M287.938,414.823c0.333,3.01-0.635,6.031-2.656,8.292c-2.021,2.26-4.917,3.552-7.948,3.552h-42.667c-3.031,0-5.927-1.292-7.948-3.552c-2.021-2.26-2.99-5.281-2.656-8.292l6.729-60.51c-10.927-7.948-17.458-20.521-17.458-34.313c0-23.531,19.135-42.667,42.667-42.667s42.667,19.135,42.667,42.667c0,13.792-6.531,26.365-17.458,34.313L287.938,414.823z M341.333,192H170.667v-42.667C170.667,102.281,208.948,64,256,64s85.333,38.281,85.333,85.333V192z"/></g></g></svg>
											<span> </span>
											<input type="password" name="passwordconfirm" placeholder="Confirmation">
										</div>
										<input class="fillable-btn" type="submit" name="registerRequest" value="Inscription">
										<p class="event-link" id="login-link">Déjà inscrit? Connectez-vous</p>
									</form>
								</div>
							</div>
							<!-- CONNEXION -->
							<div id="login" class="fillable-box">
								<div class="fillable-title-content">
									<p class="fillable-title"> Connectez-vous </p>
								</div>
								<div class="fillable-content">
									<form method="POST" action="">
										<div class="fillable-text-icon">
											<svg id="Layer_1_1_" style="enable-background:new 0 0 16 16;" version="1.1" viewBox="0 0 16 16" xml:space="preserve" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"><path d="M12,9H8H4c-2.209,0-4,1.791-4,4v3h16v-3C16,10.791,14.209,9,12,9z"/><path d="M12,5V4c0-2.209-1.791-4-4-4S4,1.791,4,4v1c0,2.209,1.791,4,4,4S12,7.209,12,5z"/></svg>
											<span> </span>
											<input type="text" name="mail" placeholder="Identifiant">
										</div>
										<div class="fillable-text-icon">
											<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <g><path d="M437.333,192h-32v-42.667C405.333,66.99,338.344,0,256,0S106.667,66.99,106.667,149.333V192h-32C68.771,192,64,196.771,64,202.667v266.667C64,492.865,83.135,512,106.667,512h298.667C428.865,512,448,492.865,448,469.333V202.667C448,196.771,443.229,192,437.333,192z M287.938,414.823c0.333,3.01-0.635,6.031-2.656,8.292c-2.021,2.26-4.917,3.552-7.948,3.552h-42.667c-3.031,0-5.927-1.292-7.948-3.552c-2.021-2.26-2.99-5.281-2.656-8.292l6.729-60.51c-10.927-7.948-17.458-20.521-17.458-34.313c0-23.531,19.135-42.667,42.667-42.667s42.667,19.135,42.667,42.667c0,13.792-6.531,26.365-17.458,34.313L287.938,414.823z M341.333,192H170.667v-42.667C170.667,102.281,208.948,64,256,64s85.333,38.281,85.333,85.333V192z"/></g></g></svg>
											<span> </span>
											<input type="password" name="password" placeholder="Mot de passe">
										</div>
										<input class="fillable-btn" type="submit" name="loginRequest" value="Connexion">
										<p class="event-link" id="register-link">Pas encore inscrit? Inscrivez-vous</p>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			<?php
				}
			?>

		</div>
		<div id="page-content">
		</div>

	</body>
	<script type="text/javascript" src="js/jquery-3.3.1.js"></script>
	<script type="text/javascript" src="js/svg.js"></script>
	<script type="text/javascript" src="js/index.js"></script>

	<?php
		function debug($log){
			global $logs;
			array_push($logs, $log);
		}

		for($i = 0, $size = count($logs); $i < $size; ++$i) {
			$log = $logs[$i];
			echo "<script>console.log( 'PHP LOG: " . $log . "' );</script>";
		}
	?>
</html>
