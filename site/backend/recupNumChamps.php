<?php

use MongoDB\Driver\Manager;

// Vérifie que le champ est présent
if (!(isset($_POST["idUtilisateur"]))) {
	$erreur = array("Erreur", "Champ manquant dans la requête");
	echo json_encode($erreur);
	exit();
}

// Vérifie que le champ est numérique
if (!(is_numeric($_POST["idUtilisateur"]))) {
	$erreur = array("Erreur", "Type du numéro d'utilisateur non reconnu");
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
$options = ["projection" => ["champs.ilots" => 1]];

// Créé la requête
$requete = new MongoDB\Driver\Query($filtre, $options);

// Exécute la requête et récupère le résultat
$resultat = $client->executeQuery("data.agriculteur", $requete);

// Traite les données
$ilots = array();
foreach ($resultat as $element) {
	// Accède à la propriété "ilots" dans le champ "champs"
	$ilots = $element->champs->ilots;
}

// Renvoi le nombre de champs pour l'utilisateur
echo json_encode(count($ilots));
