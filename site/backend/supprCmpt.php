<?php
/**
 * Supprime l'utilisateur correspondant à l'ID
 */

define('OK', 0);
define('ERROR', 1);

// Vérifie que toutes les infos sont présentes
if (!(isset($_POST["idUtilisateur"]))) {
	$erreur = array("Erreur", "Infos manquantes dans la requête");
	echo json_encode($erreur);
	exit();
}

// Infos de connexion à la BDD
$hosts = [
    "mongo1:30001",
    "mongo2:30002",
    "mongo3:30003"
];
$connectionString = implode(",", $hosts);

$database       = "data";
$collection     = "compte";
$replicaSetName = "rs0";

// uri de connnexion
use MongoDB\Driver\Manager;
//$uri = "mongodb://$connectionString/?replicaSet=$replicaSetName";
$uri = getenv('MONGODB_URL');

// Créer le client
try {
    $mongoClient = new MongoDB\Driver\Manager($uri);
} catch (MongoDB\Driver\Exception\ConnectionTimeoutException $e) {
    die("Failed to connect to MongoDB: " . $e->getMessage());
}

$idUser = intval(filter_input(INPUT_POST, 'idUtilisateur', FILTER_SANITIZE_STRING));

// Défini le filtre
$filter = ["idUser" => $idUser];

$bulk = new MongoDB\Driver\BulkWrite;
$bulk->delete($filter);
$result = $mongoClient->executeBulkWrite("$database.$collection", $bulk);

if ($result->getDeletedCount() == 0) {
    //echo json_encode("Suppression échouée. L'utilisateur n'existe peut-être pas.");
    echo json_encode(ERROR);
    exit();
}
else {
    //echo json_encode("Utilisateur supprimé.");
    echo json_encode(OK);
    exit();
}
