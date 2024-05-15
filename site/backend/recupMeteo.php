<?php

use MongoDB\Driver\Manager;

// Vérifie que les champs sont présents
if (!(
	isset($_POST["idUtilisateur"]) &&
	isset($_POST["numChamp"]) &&
	isset($_POST["duree"])
)) {
	$erreur = array("Erreur", "Champ(s) manquant(s) dans la requête");
	echo json_encode($erreur);
	exit();
}

// Vérifie que les champs sont numériques
if (!is_numeric($_POST["idUtilisateur"])) {
	$erreur = array("Erreur", "Type du numéro d'utilisateur non reconnu");
	echo json_encode($erreur);
	exit();
}
if (!(is_numeric($_POST["numChamp"]))) {
	$erreur = array("Erreur", "Type du numéro de champ non reconnu");
	echo json_encode($erreur);
	exit();
}

// Récupère les champs envoyés dans la requête
if ($_POST["duree"] === "jour") {
	$duree = "today";
	$granularite = "hours";
}
else if ($_POST["duree"] === "semaine") {
	$duree = "next7days";
	$granularite = "days";
}
else {
	$erreur = array("Erreur", "Durée non reconnue");
	echo json_encode($erreur);
	exit();
}

// Si le fichier n'existe pas, renvoi une erreur
$fichierCleAPI = "./cleAPI.txt";
$cleAPI = "";
if (file_exists($fichierCleAPI)) {
	$cleAPI = @file_get_contents($fichierCleAPI);
}
else {
	$erreur = array("Erreur", "Fichier non trouvé");
	echo json_encode($erreur);
	exit();
}

// Connexion à MongoDB
$uri = getenv('MONGODB_URL');

// Créé le client
$client = new MongoDB\Driver\Manager($uri);

// Défini le filtre
$filtre = ["idAgri" => intval($_POST["idUtilisateur"])];

// Défini la projection
$options = ["projection" => ["champs.coordonnees" => 1]];

// Créé la requête
$requete = new MongoDB\Driver\Query($filtre, $options);

// Exécute la requête et récupère le résultat
$resultat = $client->executeQuery("data.agriculteur", $requete);

// Traite les données
$coordonnees = array();
foreach ($resultat as $element) {
	// Accède à la propriété "coordonnees" dans le champ "champs"
	$coordonnees = $element->champs->coordonnees;
}

// Récupère les coordonnées du champ
$numChamp = $_POST["numChamp"];
$latitude = 0;
$longitude = 0;
if (isset($coordonnees[$numChamp])) {
	$latitude = $coordonnees[$numChamp][0];
	$longitude = $coordonnees[$numChamp][1];
}
else {
	$erreur = array("Erreur", "Index invalide");
	echo json_encode($erreur);
	exit();
}

// Récupère la météo
$reponse = @file_get_contents("https://weather.visualcrossing.com/" .
	"VisualCrossingWebServices/rest/services/timeline/". $latitude . "," .
	$longitude . '/' . $duree .
	"?unitGroup=metric&elements=datetime%2Ctempmax" .
	"%2Ctempmin%2Ctemp%2Chumidity%2Cprecip%2Cpreciptype%2Cwindspeedmean%2C" .
	"winddir%2Ccloudcover%2Cuvindex&include=" . $granularite .
	"&key=" . $cleAPI .	"&contentType=json");

// Renvoi l'erreur HTTP, si la requête a échoué
if ($reponse === false) {
	$erreur = array("Erreur", explode(' ', $http_response_header[0])[1]);
	echo json_encode($erreur);
	exit();
}

echo $reponse;
