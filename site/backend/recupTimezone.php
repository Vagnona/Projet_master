<?php
// Récupère la timezone du champ en fonction de sa localisation
// Doit être appelé par un script ayant une connexion existante à la bdd

// Check si la connexion à la bdd existe 
if (!(isset($manager))) {
	$erreur = array("Erreur", "Connexion bdd inexistante");
	echo json_encode($erreur);
	exit();
}

// Récupération du numéro du champ courant via la variable POST
$numchamp = intval($_POST["numChamp"]);

// Création de la commande
$pipeline = [
	['$match' => [
		'idAgri' => intval($_POST["idUtilisateur"]),
	]],
    ['$group' => [
        'champs' => 'champs',
    ]],
];

// Création de la commande pour chaque collection
$commandtz = new MongoDB\Driver\Command([
    "aggregate" => "agriculteur",
    "pipeline" => $pipeline,
    "cursor" => new stdClass(),
]);

$cursor = $manager->executeCommand('data', $commandtz);
$champs = $cursor->toArray();

// Récupération des coordonnées du champ courant
$coords = $champs->coordonnees[$numchamp];
