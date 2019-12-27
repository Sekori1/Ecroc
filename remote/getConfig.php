<?php 
include "../connect.php";
include "valideCode.php";//Permet d'extraire le chien concerné en fonction du code renseigné

if($VALIDE_CODE){//Le code est valide?
    $daysName = array("monday","tuesday","wednesday","thursday","friday","saturday","sunday");
    //On cherche la configuration du chien demandé
    $SQLrequest = $bdd->prepare("SELECT * FROM meal_config WHERE dogID = ?");
    $SQLrequest->execute(array($DOG_ID));
    //Au moins une ligne a été trouvé?
    if($SQLrequest->rowCount() > 0){
        $SQLinfo = $SQLrequest->fetch();//On recupere la premiere ligne
        $MEAL_VAR = array(7);//Liste qui permet d'encoder correctement les données
        for ($i = 0; $i < 7; $i++) {//Boucle sur 7 jours
            $day = $daysName[$i];
            $MEAL_VAR[$i] = array();//On ajoute une liste dans la liste (2 eme dimensions)
            //On sépare découpe la ligne à chaque '|', ce séparateur permet de séparer chaque repas
            $splitedCurrentMealData = explode("|",$SQLinfo[$day]);
            for($j = 0; $j < count($splitedCurrentMealData); $j++){//Boucle sur les repas
                $meal = explode(":",$splitedCurrentMealData[$j]);
                if(count($meal) == 2){//Verification de la taille HEURE|JOUR (2)
                    $MEAL_VAR[$i][$j] = array($meal[0], $meal[1]);//On ajoute le repas à la liste
                }
            }
        }
        echo json_encode($MEAL_VAR);//On encode les repas en json
    }    
}

?>
