<?php
	include "backend/checkConnexion.php";

	// Vérifie que l'utilisateur est bien un administrateur
	if ($_SESSION["role"] !== "admin") {
		header("Location: .");
	}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<?php include "assets/head.php"?>
	<title>Création de compte</title>
	<meta name="description" content="Création de compte"/>
	<link rel="stylesheet" type="text/css" href="style/index.css"/>
	<link rel="stylesheet" type="text/css" href="style/accesCmpt.css"/>
	<link rel="stylesheet" type="text/css" href="style/gestionCmpt.css"/>
</head>
<body>
<header>
	<?php include "assets/logo.php"?>
	<section title="Retourner en haut de la page">
		<p title=''>-</p>
		<div id="ddCmpt" class="dropdown" title=''>
			<button class="dropbtn">⇩</button>
			<div id="selectCmpt" class="dropdownContent ddHeader">
				<a href='.'>Accueil</a>
				<a href="gestionCmpt.php">Gestion du compte</a>
				<a href="backend/deconnexion.php">Déconnexion</a>
			</div>
		</div>
	</section>
</header>
<div id="corps">
	<section id="infosCmpt" class="containerSecVerti">
		<h1>Création de compte</h1>
		<form id="formCmpt">
			<label class="colonne" for="prenom">Prénom</label>
			<input class="colonne" id="prenom" name="prenom"
				placeholder="Prénom"></input>
			<label class="colonne" for="nom">Nom</label>
			<input class="colonne" id="nom" name="nom" placeholder="Nom">
			</input>
			<label class="role" for="role">Rôle</label>
			<select name="role" id="role" required>
				<option value="standard">Standard</option>
				<option value="admin">Administrateur</option>
			</select>
			<label class="colonne" for="courriel">Courriel</label>
			<input class="colonne" id="courriel" name="courriel"
				placeholder="adresse@courriel.com"></input>
			<button type="button" id="enreg">Créer</button>
		</form>
	</section>
	<dialog id="confirmation">
		<h1>Confirmation de création de compte</h1>
		<p>Le compte a bien été créé !</p>
		<form method="dialog">
			<a class="btnDlg" href="creationCmpt.php">Créer un autre compte</a>
			<a class="btnDlg" href='.'>Retour à l'accueil</a>
		</form>
	</dialog>
</div>
<?php include "assets/footer.php"?>
<script type="text/javascript" src="scripts/afficherDonnees.js"></script>
<script type="text/javascript" src="scripts/recupDonnees.js"></script>
<script type="text/javascript" src="scripts/verificationsInput.js"></script>
<script type="text/javascript" src="scripts/gestionCmpt.js"></script>
<script src="scripts/entete.js"></script>
<script>
	/*** Gestion des données ***/
		// Récupérer l'ID utilisateur
	const idUtilisateur = <?php
		echo json_encode($_SESSION["idAgri"]); //idUser ?
	?>;

		// Récupère le nom et prénom de l'utilisateur
	afficherNomUtilisateur(idUtilisateur);

		// Gère les champs du formulaire et l'envoi des données
	document.getElementById("enreg").addEventListener("click", e => {
		e.preventDefault();
		creationCmpt();
	});
	document.querySelector("form").addEventListener("submit", e => {
		e.preventDefault();
		creationCmpt();
	});


	/*** Changements du DOM ***/
		// Gère le défilement vers le haut de la page
	activerDefilementHautPage();

		// Gère la taille du header en fonction du défilement
	activerHeaderReduit();
</script>
</body>
</html>