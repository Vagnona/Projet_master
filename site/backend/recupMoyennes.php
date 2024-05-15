<?php
// Récupère les moyennes des mesures du champ envoyés dans la requête
// Doit être appelé par un script ayant une connexion existante à la bdd

// Check si la connexion à la bdd existe 
if (!(isset($manager))) {
	$erreur = array("Erreur", "Connexion bdd inexistante");
	echo json_encode($erreur);
	exit();
}

// Définition de la pipeline de la requete
// On recupere la valeur la plus recente des capteurs pour chaque ilot
$pipelinetemp = [
	['$match' => [
		'idAgri' => intval($_POST["idUtilisateur"]),
		'idChamps' => intval($_POST["numChamp"])
	]],
	['$sort' => ['date' => -1]],
    ['$group' => [
        '_id' => '$idIlot',
        'temp' => ['$first' => '$temp']
    ]],
];

$pipelinehumi = [
	['$match' => [
		'idAgri' => intval($_POST["idUtilisateur"]),
		'idChamps' => intval($_POST["numChamp"]),
	]],
	['$sort' => ['date' => -1]],
    ['$group' => [
        '_id' => '$idIlot',
        'humi' => ['$first' => '$humi'], 
    ]],
];

$pipelinelumi = [
	['$match' => [
		'idAgri' => intval($_POST["idUtilisateur"]),
		'idChamps' => intval($_POST["numChamp"]),
	]],
	['$sort' => ['date' => -1]],
    ['$group' => [
        '_id' => '$idIlot',
        'lumi' => ['$first' => '$lumi'], 
    ]],
];

// Création de la commande pour chaque collection
$commandtemp = new MongoDB\Driver\Command([
    "aggregate" => "temp",
    "pipeline" => $pipelinetemp,
    "cursor" => new stdClass(),
]);
$commandhumi = new MongoDB\Driver\Command([
    "aggregate" => "humi",
    "pipeline" => $pipelinehumi,
    "cursor" => new stdClass(),
]);
$commandlumi= new MongoDB\Driver\Command([
    "aggregate" => "lumi",
    "pipeline" => $pipelinelumi,
    "cursor" => new stdClass(),
]);

// Exécution de la commande d'agrégation
$cursortemp = $manager->executeCommand('data', $commandtemp);
$cursorhumi = $manager->executeCommand('data', $commandhumi);
$cursorlumi = $manager->executeCommand('data', $commandlumi);

// Traitement des données
$temps = 0.0;
$humis = 0.0;
$lumis = 0;
$count = 0;

// Calcul moyenne températures
foreach ($cursortemp as $element) {
	//S'il y a des valeurs on les additionne pour la moyenne
	if (isset($element)) {
		$temps = $temps + floatval($element->temp);
		$count += 1;
	}
	// Si pas de retour de la bdd, erreur
	else {
		$erreur = array("Erreur", "Retour vide de la bdd");
		echo json_encode($erreur);
		exit();
	}
}
$moytemp = $temps / $count;

$count = 0;
// Calcul moyenne humidite
foreach ($cursorhumi as $element) {
	//S'il y a des valeurs on les additionne pour la moyenne
	if (isset($element)) {
		$humis = $humis + floatval($element->humi);
		$count += 1;
	}
	// Si pas de retour de la bdd, erreur
	else {
		$erreur = array("Erreur", "Retour vide de la bdd");
		echo json_encode($erreur);
		exit();
	}
}
$moyhumi = $humis / $count;

$count = 0;
// Calcul moyenne luminosite
foreach ($cursorlumi as $element) {
	//S'il y a des valeurs on les additionne pour la moyenne
	if (isset($element)) {
		$lumis = $lumis + floatval($element->lumi);
		$count += 1;
	}
	// Si pas de retour de la bdd, erreur
	else {
		$erreur = array("Erreur", "Retour vide de la bdd");
		echo json_encode($erreur);
		exit();
	}
}
$moylumi = $lumis / $count;

// Renvoi les moyennes de temperature, humidite et luminosite
$moytemp = round($moytemp, 1);
$moyhumi = round($moyhumi, 1);
$moylumi = round($moylumi, 1);

echo json_encode([$moytemp, $moyhumi, $moylumi]);