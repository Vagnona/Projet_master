<?php

// codes de retour sur l'etat de l'authentification
define('OK', 0);
define('TMP_PWD', 1);
define('CONN_FAILED', 2);

// Vérifie que toutes les infos sont présentes
if (!(isset($_POST["courriel"]) && isset($_POST["mdp"]))) {
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

// Défini le filtre
$filtre = [
	"mail" => $_POST["courriel"]
];

// Créé la requête
$requete = new MongoDB\Driver\Query($filtre);
//$curdate = new DateTime("UTC");

$cursor = $mongoClient->executeQuery("$database.$collection", $requete);

if ($cursor->isDead()) { // mail non existant
    echo json_encode([CONN_FAILED, "Identifiants erronés"]);
    exit();
}

foreach ($cursor as $infosUser) {
    $idUser     = $infosUser->idUser;
    $idAgri     = $infosUser->idAgri;
    $role       = $infosUser->role;
    $nom        = $infosUser->nom;
    $prenom     = $infosUser->prenom;
    $mail       = $infosUser->mail;
    $mdp        = $infosUser->mdp;
    $mdp_temp   = $infosUser->mdp_temp;
}

if (password_verify($_POST["mdp"], $mdp)) {   // mdp valide
    // demarre une session avec les infos du user
    session_start();
    $_SESSION["idUser"] = $idUser;
    $_SESSION["idAgri"] = $idAgri;
    $_SESSION["role"]   = $role;
    $_SESSION["nom"]    = $nom;
    $_SESSION["prenom"] = $prenom;
    $_SESSION["mail"]   = $mail;

    if ($mdp_temp == true) {    // nouveau compte
        echo json_encode([TMP_PWD, $idUser]); // preciser str a renvoyer
        exit();
    }
    else {
        echo json_encode([OK, ""]);
        exit();
    }
    

} else {    // mauvais mdp
    echo json_encode([CONN_FAILED, "Identifiants erronés"]);
    exit();
}
