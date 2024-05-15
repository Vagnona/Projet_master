<?php
/**
 * Met à jour les données d'un utilisateur en fonction des champs présents dans 
 * $_POST. Utilisé pour le changement du mot de passe temporaire à la 1ere 
 * connection et dans le formulaire de gestion de compte.
 */

define("OK", 0);
define("ERROR", 1);

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

// préparer la mise à jour
$update = [];

if (isset($_POST["mdp"])) {
    $update['mdp'] = password_hash($_POST["mdp"], PASSWORD_DEFAULT);
}
if (isset($_POST["courriel"])) {
    $update['mail'] = $_POST['courriel'];
}

$fields = ['role', 'nom', 'prenom'];
foreach ($fields as $field) {
    if (isset($_POST[$field])) {
        $update[$field] = $_POST[$field];
    }
}

// Creer le filtre
$filter = ['idUser' => $idUser];

if (!empty($update)) {
    // Opération de maj
    $bulk = new MongoDB\Driver\BulkWrite;
    $bulk->update(
        $filter,
        ['$set' => $update],
        ['multi' => false, 'upsert' => false]
    );

    // Executer l'operation
    try {
        $result = $mongoClient->executeBulkWrite("$database.$collection", $bulk);
        echo json_encode(OK);
    } catch (MongoDB\Driver\Exception\Exception $e) {
        //echo json_encode("Mise à jour échouée: ".$e->getMessage());
        echo json_encode(ERROR);
    }
}
