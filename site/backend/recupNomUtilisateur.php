<?php
// Script permettant de récupérer le nom d'utilisateur
// Doit être appelé par un script ayant une connexion existante à la bdd

// Check si la connexion à la bdd existe 
if (!(isset($manager)) && !(isset($_POST["idUtilisateur"]))) {
    $erreur = array("Erreur", "Paramètres manquants");
    echo json_encode($erreur);
    exit();
}

// Création connexion bdd si inexistante
if (!isset($manager)) {
	// Chemin de connexion vers la base de données
	$uri = getenv('MONGODB_URL');
	$manager = new MongoDB\Driver\Manager($uri);
}

// Création de la pipeline pour récupérer le nom d'agriculteur
$pipelineagri = [
	['$match' => [
		'idUser' => intval($_POST["idUtilisateur"]),
	]],
];

// Création de la commande pour chaque collection
$commandagri = new MongoDB\Driver\Command([
    "aggregate" => "compte",
    "pipeline" => $pipelineagri,
    "cursor" => new stdClass(),
]);

// Exécution de la commande
$cursor = $manager->executeCommand('data', $commandagri);

// Traite les données
foreach ($cursor as $element) {
	$resultat = strtoupper($element->nom) . " " . $element->prenom;
}
// Renvoi le nom d'utilisateur
echo json_encode($resultat);