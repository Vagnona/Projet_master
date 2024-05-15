<?php
// Script de chargement de la page principale du frontend 
// Effectue la vérification des paramètres et l'initialisation 
// de la connexion vers la base de données MongoDB
use MongoDB\Driver\Manager;

// Chemin de connexion vers la base de données
$uri = getenv('MONGODB_URL');

// Vérification des paramètres d'appel
if (!(isset($_POST["idUtilisateur"])) || !(isset($_POST["numChamp"]))) {
	$erreur = array("Erreur", "Champ(s) manquant(s) dans la requête");
	echo json_encode($erreur);
	exit();
}

if (!(is_numeric($_POST["idUtilisateur"]))) {
    $erreur = array("Erreur", "Identifiant de type incompatible");
    echo json_encde($erreur);
    exit();
}

if (!(is_numeric($_POST["numChamp"]))) {
    $erreur = array("Erreur", "Numéro de champ de type incompatible");
    echo json_encde($erreur);
    exit();
}

// Connexion à MongoDB
$manager = new MongoDB\Driver\Manager($uri);

// Récupération des données
$data = array();

// Ajout du nom utilisateur, infos champs, moyennes, mesures et graphique ilot
ob_start();
include "recupNomUtilisateur.php";
$data[] = ob_get_contents();
ob_end_clean();

ob_start();
include "recupInfosChamp.php";
$data[] = json_decode(ob_get_contents(), true);
ob_end_clean();

ob_start();
include "recupMoyennes.php";
$data[] = json_decode(ob_get_contents(), true);
ob_end_clean();

ob_start();
include "recupMesuresChamp.php";
$data[] = json_decode(ob_get_contents(), true);
ob_end_clean();

ob_start();
include "recupNumIlots.php";
$data[] = ob_get_contents();
ob_end_clean();

/*
ob_start();
include "recupMesuresIlot.php";
$data[] = ob_get_contents();
ob_end_clean();
*/
// Retour des données pour affichage de la page principale
echo json_encode($data);
?>
