<?php

$fichierDonneeExport = "json/export.json";
if (file_exists($fichierDonneeExport)) {
	echo file_get_contents($fichierDonneeExport);
}
else {
	$erreur = array("Erreur", "Le fichier n'existe pas");
	echo json_encode($erreur);
	exit();
}