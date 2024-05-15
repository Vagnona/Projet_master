<?php
/**
 * Récupère les informations d'un utilisateur en BdD à partir de l'id fourni
 */

// Vérifie que toutes les infos sont présentes
if (!(isset($_POST["idUtilisateur"]) and isset($_POST['requeteAdmin']))) {
	$erreur = array("Erreur", "Infos manquantes dans la requête");
	echo json_encode($erreur);
	exit();
}

// table à accéder
$database       = "data";
$collection     = "compte";

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
$requeteAdmin = boolval(filter_input(INPUT_POST, 'requeteAdmin', FILTER_SANITIZE_STRING));

// Défini le filtre
$filtre = ["idUser" => $idUser];

// Créé la requête
$requete = new MongoDB\Driver\Query($filtre);

$cursor = $mongoClient->executeQuery("$database.$collection", $requete);

$result = [];
foreach ($cursor as $infosUser) {
    // ordre à conserver
    array_push($result, $infosUser->idUser);
    array_push($result, $infosUser->prenom);
    array_push($result, $infosUser->nom);
    array_push($result, $infosUser->mail);
    array_push($result, "#ffffff"); // couleur1
    array_push($result, "#00ffaa"); // couleur2

    if ($requeteAdmin == true)
        array_push($result, $infosUser->role);
}

// envoyer réponse
echo json_encode($result);