<?php
/* Dependance:
    - connect.php
 */
static $logs = array();
$isLogged = isset($_SESSION["id"]);
$ownerID = $_SESSION["id"];

debug("test 0");

if($isLogged){
    debug("test log OK");
    $id = $_SESSION["id"];
    $SQLrequest = $bdd->prepare("SELECT * FROM dogs WHERE ownerID = ? ORDER BY id ASC");
    $SQLrequest->execute(array($id));

    $rowAmount = $SQLrequest->rowCount();
?>
<!-- La peronnes est connecté -->

    <!-- On créer la barre -->
    <div id="dogsBar">
            <div class="dogListContainer">
                <div class="dogList">

                    <!-- Boucle de tous les chiens de l'utilisateur -->
                    <?php
                        while($SQLinfo = $SQLrequest->fetch()){

                            $loopDogID = $SQLinfo["id"];

                            $notifRequest = $bdd->prepare("SELECT * FROM notification WHERE ownerID = ? AND dogID = ? AND notify = ?");
                                        $notifRequest->execute(array($ownerID, $loopDogID, 1));
                                        $notifAmount = $notifRequest->rowCount();
                    ?>
                        <!-- Ajoute une bulle avec les informations du chien -->
                        <a class="dog-block" href="control.php?dog=<?php echo $loopDogID ?>">
                            <div class="dog-picture" style="background-image: url(privateProfileImage.php?id=<?php echo urlencode($loopDogID) ?>);"></div>
                            <p class="dog-name"><?php echo $SQLinfo['name'] ?></p>
                            <?php
                                if($notifAmount){
                                    echo "<div class=\"notif\">" . $notifAmount . "</div>";
                                }
                            ?>
                        </a>
                        <!------------------------------>
                    <?php
                        }
                    ?>

                    <!-- Button pour ajouter un chien -->
                    <div class="dog-block">
                        <div id="profileAddButton" class="dog-add">
                            <svg fill="#b19b44" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="46.361px" height="46.361px" viewBox="0 0 46.361 46.361" style="enable-background:new 0 0 46.361 46.361;" xml:space="preserve"> <g> <path d="M40.225,17.042H29.352V6.148c0-3.39-2.769-6.138-6.159-6.138c-3.389,0-6.157,2.748-6.157,6.138v10.895H6.139 C2.75,17.042,0,19.79,0,23.18c0,3.391,2.75,6.139,6.139,6.139h10.897v10.896c0,3.39,2.768,6.138,6.157,6.138 c3.39,0,6.159-2.748,6.159-6.138V29.318l10.873,0.002c3.389,0,6.137-2.75,6.137-6.141C46.361,19.79,43.613,17.042,40.225,17.042z" /> </g> </svg>
                        </div>
                    </div>
                </div>
            </div>
    </div>

    <!-- Formulaire pour ajouter un chien -->
    <div id="profileAddContainer">
        <div id="profileAdd" class="fillable-box">
            <div class="fillable-title-content">
                <p class="fillable-title"> Ajoutez un profil </p>
            </div>
            <div class="fillable-content">
                <form method="POST" action="addDog.php">
                    <p class="help">
                        Afin d’ajouter un profil, vous devez renseigner le code du distributeur. <br>
                        Pour trouver le code, allez dans le menu «Code de connexion» accessible depuis l’écran tactile du distributeur.
                    </p>
                    <div class="fillable-text-icon">
                        <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 508.52 508.52" style="enable-background:new 0 0 508.52 508.52;" xml:space="preserve"> <g> <path d="M425.059,339.818c-18.911,0-36.232,6.325-50.216,16.908L166.667,256.103l0.191-3.782 l207.953-100.496c13.953,10.584,31.274,16.908,50.216,16.908c46.148,0,83.493-37.376,83.493-83.493S471.175,1.748,425.059,1.748 s-83.493,37.376-83.493,83.493v0.064l-206.109,99.638c-14.27-11.378-32.323-18.243-51.964-18.243 C37.376,166.699,0,204.107,0,250.192c0,46.116,37.376,83.461,83.493,83.461c16.654,0,32.164-4.926,45.195-13.349l212.879,102.88 v0.095c0,46.085,37.376,83.493,83.493,83.493s83.461-37.376,83.461-83.493S471.175,339.818,425.059,339.818z"/> </g></svg>
                        <span> </span>
                        <input type="text" name="Code" placeholder="Code">
                    </div>
                    <button class="fillable-btn"> Ajouter </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Masque lorsque le formulaire pour ajouter un chien apparait -->
    <div id="mask"></div>

<?php
}

function debug($log){
    global $logs;
    array_push($logs, $log);
}

for($i = 0, $size = count($logs); $i < $size; ++$i) {
    $log = $logs[$i];
    echo "<script>console.log( 'PHP LOG: " . $log . "' );</script>";
}
?>

<!-- FORMAT BAR
<div id="dogsBar">
    <div class="dogsBar-container respBox">

        <div class="dogList">
            <div class="dog-block">
                <div class="dog-picture"></div>
                <p class="dog-name">Name</p>
            </div>
            <div class="dog-block">
                <div class="dog-picture"></div>
                <p class="dog-name">Name</p>
            </div>
            <div class="dog-block">
                <div class="dog-picture"></div>
                <p class="dog-name">Name</p>
            </div>
            <div class="dog-block">
                <div id="profileAddButton" class="dog-add">
                    <svg fill="#b19b44" version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" width="46.361px" height="46.361px" viewBox="0 0 46.361 46.361" style="enable-background:new 0 0 46.361 46.361;" xml:space="preserve"> <g> <path d="M40.225,17.042H29.352V6.148c0-3.39-2.769-6.138-6.159-6.138c-3.389,0-6.157,2.748-6.157,6.138v10.895H6.139 C2.75,17.042,0,19.79,0,23.18c0,3.391,2.75,6.139,6.139,6.139h10.897v10.896c0,3.39,2.768,6.138,6.157,6.138 c3.39,0,6.159-2.748,6.159-6.138V29.318l10.873,0.002c3.389,0,6.137-2.75,6.137-6.141C46.361,19.79,43.613,17.042,40.225,17.042z" /> </g> </svg>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="profileAddContainer">
    <div id="profileAdd" class="fillable-box">
		<div class="fillable-title-content">
			<p class="fillable-title"> Ajoutez un profil </p>
		</div>
		<div class="fillable-content">
			<form>
				<p class="help">Afin d’ajoutez un profil, vous devez renseignez le code du distributeur. <br>
Pour trouver le code, allez dans le menu «Code de connexion» accessible depuis l’écran tactile du distributeur.</p>
				<div class="fillable-text-icon">
			    	<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px" viewBox="0 0 508.52 508.52" style="enable-background:new 0 0 508.52 508.52;" xml:space="preserve"> <g> <path d="M425.059,339.818c-18.911,0-36.232,6.325-50.216,16.908L166.667,256.103l0.191-3.782 l207.953-100.496c13.953,10.584,31.274,16.908,50.216,16.908c46.148,0,83.493-37.376,83.493-83.493S471.175,1.748,425.059,1.748 s-83.493,37.376-83.493,83.493v0.064l-206.109,99.638c-14.27-11.378-32.323-18.243-51.964-18.243 C37.376,166.699,0,204.107,0,250.192c0,46.116,37.376,83.461,83.493,83.461c16.654,0,32.164-4.926,45.195-13.349l212.879,102.88 v0.095c0,46.085,37.376,83.493,83.493,83.493s83.461-37.376,83.461-83.493S471.175,339.818,425.059,339.818z"/> </g></svg>
			    	<span> </span>
				    <input type="text" name="Code" placeholder="Code">
			    </div>
		        <button class="fillable-btn"> Ajouter </button>
		    </form>
		</div>
    </div>
</div>

-->

<div id="mask"></div>
