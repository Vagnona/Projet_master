<?php
include_once "classe/BaseDeDonnees.php";
$bdd = new BaseDeDonnees("./bdd/donnees.db");

$bdd->initialiserTable();

// Si la langue est présente, on l'utilise, sinon on utilise le français
if (isset($_POST["lang"])) {
	if ($_POST["lang"] === "fr") {
		include_once "../assets/tradFr.php";
	}
	elseif ($_POST["lang"] === "en") {
		include_once "../assets/tradEn.php";
	}
	elseif ($_POST["lang"] === "de") {
		include_once "../assets/tradDe.php";
	}
	else {
		include_once "../assets/tradFr.php";
	}
}

// Si les données sont présentes, les insérer dans la base de données
// En cas d'erreur, renvoie 1, sinon 0
if (
	isset($_POST["nom"]) &&
	isset($_POST["prenom"]) &&
	isset($_POST["courriel"]) &&
	isset($_POST["message"])
) {
	$retour = $bdd->insererMessage(
		htmlspecialchars($_POST["nom"], ENT_QUOTES, "UTF-8"),
		htmlspecialchars($_POST["prenom"], ENT_QUOTES, "UTF-8"),
		htmlspecialchars($_POST["courriel"], ENT_QUOTES, "UTF-8"),
		htmlspecialchars($_POST["message"], ENT_QUOTES, "UTF-8")
	);

	// En cas d'erreur, afficher l'erreur
	if ($retour !== null) {
		echo json_encode($trad["bulle"]["retour"][2]);
		die();
	}

	echo json_encode($trad["bulle"]["retour"][0]);
}
else {
	echo json_encode($trad["bulle"]["retour"][1]);
}