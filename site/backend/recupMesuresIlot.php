<?php

// Renvoi des données fictives pour le graphique en mode local
const MODE_LOCAL = true;

// Récupère les champs envoyés dans la requête
if (!(
	isset($_POST["numChamp"]) &&
	isset($_POST["numIlot"]) &&
	isset($_POST["typeMesures"])
)) {
	$erreur = array("Erreur", "Champ(s) manquant(s) dans la requête");
	echo json_encode($erreur);
	exit();
}
if (!(is_numeric($_POST["numChamp"]))) {
	$erreur = array("Erreur", "Type du numéro de champ non reconnu");
	echo json_encode($erreur);
	exit();
}
if (!(is_numeric($_POST["numIlot"]))) {
	$erreur = array("Erreur", "Type du numéro d'ilot non reconnu");
	echo json_encode($erreur);
	exit();
}
if (!(
	$_POST["typeMesures"] === "temp" ||
	$_POST["typeMesures"] === "humi" ||
	$_POST["typeMesures"] === "lumi"
)) {
	$erreur = array("Erreur", "Type de mesure non reconnu");
	echo json_encode($erreur);
	exit();
}

if (MODE_LOCAL) {
	if ($_POST["typeMesures"] === "temp") {
		$fichierDonneesGraph = "./json/donneesGraphTemp.json";
	}
	else if ($_POST["typeMesures"] === "humi") {
		$fichierDonneesGraph = "./json/donneesGraphHumi.json";
	}
	else if ($_POST["typeMesures"] === "lumi") {
		$fichierDonneesGraph = "./json/donneesGraphLumi.json";
	}

	// Vérifie que le fichier existe
	if (file_exists($fichierDonneesGraph)) {
		echo file_get_contents($fichierDonneesGraph);
	}
	else {
		$erreur = array("Erreur", "Le fichier n'existe pas");
		echo json_encode($erreur);
		exit();
	}
}
else {
	/* Requête MongoDB */
}