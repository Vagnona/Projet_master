<?php

define('OK', 0);
define('ERROR', 1);

/**
 * Genere une chaine de caractere aleatoire
 * @param length la longueur de la chaine
 * @param keyspace l'alphabet pour construire la chaine
 */
function random_str ($length, $keyspace) {
    $str = '';
    $max = strlen($keyspace) - 1;

    if ($max < 1) {
        throw new Exception('$keyspace doit contenir au moins 2 caracteres');
    }

    for ($i = 0; $i < $length; ++$i) {
        $str .= $keyspace[random_int(0, $max)];
    }

    return $str;
}


/**
 * Genere un mot de passe temporaire aleatoire qui repond au criteres suivants:
 * longueur 20; au moins 1 majuscule, minuscule, chiffre et caractere special
 */
function generate_password() {
    $lowercase      = 'abcdefghijklmnopqrstuvwxyz';
    $uppercase      = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $numbers        = '0123456789';
    $specialChars   = '!@#$%^&*()_-+=<>?';
    $combinedChars = $lowercase . $uppercase . $numbers . $specialChars;

    // genere le gros du mdp sans garantie de type de caractere
    $password = random_str(16, $combinedChars);

    // ajout d'un caractere de chaque type
    $charsArray = [$lowercase, $uppercase, $numbers, $specialChars];
    foreach($charsArray as $type) {
        $password .= random_str(1, $type);
    }

    // melange les caracteres
    return str_shuffle($password);
}


// envoie un email pour informer l'utilisateur de la création d'un compte à son nom
// et lui fournir son mot de passe initial
// /!\ utilise le paquet sendmail
function notify($nom, $prenom, $mail, $mdp) {
    $to      = $mail;
    $subject = 'Compte ajouté';
    $message = "Bonjour $prenom $nom,\nVoici votre mot de passe temporaire: $mdp\n";
    $headers = array(
        'From' => 'account-notify@agri-net.com'
    );

    mail($to, $subject, $message, $headers);
}


// Requete pour récupérer le plus grand idUser pour trouver le 1er libre
function firstFreeIdUser($mongoClient, $database, $collection) {
    $filter = [];
    $sort = ['idUser' => -1];   // tri par ordre décroissant
    $options = ['sort' => $sort, 'limit' => 1];  // on veut 1 seul elt (le plus grand)

    $query = new MongoDB\Driver\Query($filter, $options);
    $cursor = $mongoClient->executeQuery("$database.$collection", $query);
    $highestUser = current($cursor->toArray());
    $nextIdUser = $highestUser ? $highestUser->idUser + 1 : 0;

    return $nextIdUser;
}


// Vérifie que toutes les infos sont présentes
if (!(isset($_POST["nom"]) && isset($_POST["prenom"]) && isset($_POST["role"]) && isset($_POST["courriel"]))) {
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


// Récupérer IdAgri de l'utilisateur actuel pour ajouter nouveau user au même agri
session_start();

$mail = $_POST["courriel"];
$mdp = generate_password();
$newCompte = [
    "idUser"    => firstFreeIdUser($mongoClient, $database, $collection),
    "idAgri"    => $_SESSION["idAgri"],
    "role"      => $_POST['role'],
    "nom"       => $_POST['nom'],
    "prenom"    => $_POST['prenom'],
    "mail"      => $mail,
    "mdp"       => password_hash($mdp, PASSWORD_DEFAULT),
    "mdp_temp"  => true,
];

// vérifier qu'il n'y a pas déjà un compte pour cette @ mail
// Défini le filtre
$filtre = [
	"mail" => $mail
];

// Créé la requête
$requete = new MongoDB\Driver\Query($filtre);

$cursor = $mongoClient->executeQuery("$database.$collection", $requete);

if (!$cursor->isDead()) { // mail deja existant
    echo json_encode([ERROR, "Il existe déjà un utilisateur avec cette adresse courriel \"$mail\""]);
    exit();
}

// Ajouter le nouvel utilisateur
$writeConcern = new MongoDB\Driver\WriteConcern(MongoDB\Driver\WriteConcern::MAJORITY, 1000);

$insert = new MongoDB\Driver\BulkWrite();
$insert->insert($newCompte);

try {
    $result = $mongoClient->executeBulkWrite("$database.$collection", $insert, $writeConcern);
    $mail = "florent.seel@etu.unistra.fr";
    //notify($_POST['nom'], $_POST['prenom'], $mail, $mdp);
    echo json_encode([OK, "$mdp"]);
} catch (MongoDB\Driver\Exception\BulkWriteException $e) {
    die("Error inserting document: " . $e->getMessage());
}
