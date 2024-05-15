<?php
	include "backend/checkConnexion.php";
	$role = $_SESSION["role"]; // "admin" ou "standard"
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<?php include "assets/head.php"?>
	<title>Gestion du compte</title>
	<meta name="description" content="Gestion du compte"/>
	<link rel="stylesheet" type="text/css" href="style/index.css"/>
	<link rel="stylesheet" type="text/css" href="style/gestionCmpt.css"/>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"
		integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA=="
		crossorigin="anonymous" referrerpolicy="no-referrer"/>
</head>
<body tabindex='0'>
<header>
	<?php include "assets/logo.php"?>
	<section title="Retourner en haut de la page">
		<p title=''>-</p>
		<div id="ddCmpt" class="dropdown" title=''>
			<button class="dropbtn">⇩</button>
			<div id="selectCmpt" class="dropdownContent ddHeader">
				<a href='.'>Accueil</a>
				<?php
					if ($role === "admin") {
						echo '<a href="creationCmpt.php">Ajouter un ' .
							'utilisateur</a>' . PHP_EOL;
					}
				?>
				<a href="backend/deconnexion.php">Déconnexion</a>
			</div>
		</div>
	</section>
</header>
<div id="corps">
	<section id="secCmpt">
		<div id="infosCmpt" class="containerSecVerti">
			<h1>Modifier les informations</h1>
			<?php if ($role === "admin")
				include "assets/selecteurUtilisateur.php"
			?>
			<form id="formCmpt">
				<label class="colonne" for="idUtili">Identifiant utilisateur
				</label>
				<div id="secCopie">
					<input class="colonne" id="idUtili" disabled name="idUtili"
						placeholder='-'>
					</input>
					<div>
						<button
							type="button"
							onclick="copierPressePapier()"
							onmouseout="reinitBouton()"
						>
							<i class="fa fa-copy"></i>
							<span class="bulle" id="texteBouton">
								Copier dans le presse-papier
							</span>
						</button>
					</div>
				</div>
				<label class="colonne" for="prenom">Prénom</label>
				<input class="colonne" id="prenom" name="prenom"
					placeholder="Prénom" value='-'></input>
				<label class="colonne" for="nom">Nom</label>
				<input class="colonne" id="nom" name="nom"
					placeholder="Nom" value='-'></input>
				<?php if ($role === "admin")
					include "assets/selecteurRole.php"
				?>
				<label class="colonne" for="courriel">Courriel</label>
				<input class="colonne" id="courriel" name="courriel"
					placeholder="adresse@courriel.com" value='-'></input>
				<label class="colonne" for="mdp">Mot de passe</label>
				<div id="secMdp">
					<input type="password" id="mdp" name="mdp"
					class="colonne" placeholder="******" value=''></input>
					<span class="bulle">
						Minimum 14 caractères, 1 majuscule, 1 minuscule,
						1 chiffre et 1 caractère spécial
					</span>
				</div>
				<label class="colonne" for="couleur1">Couleur haute</label>
				<input class="colonne selectCouleur" id="couleur1"
					name="couleur1" type="color" placeholder="#000000"
					value="#000000"></input>
				<label class="colonne" for="couleur2">Couleur basse</label>
				<input class="colonne selectCouleur" id="couleur2"
					name="couleur2" type="color" placeholder="#ffffff"
					value="#ffffff"></input>
				<button type="button" id="reinit">Réinitialiser</button>
				<button type="button" id="enreg">Enregistrer</button>
				<button type="button" id="suppr">Supprimer le compte</button>
			</form>
		</div>
		<div id="icone">
			<div>-</div>
		</div>
	</section>
	<dialog id="quitter">
		<h1>Supprimer le compte ?</h1>
		<form method="dialog">
			<button class="btnDlg" value="annuler">Annuler</button>
			<button class="btnDlg" value="confirmer">Confirmer</button>
		</form>
	</dialog>
</div>
<?php include "assets/footer.php"?>
<script type="text/javascript" src="scripts/recupDonnees.js"></script>
<script type="text/javascript" src="scripts/afficherDonnees.js"></script>
<script type="text/javascript" src="scripts/verificationsInput.js"></script>
<script type="text/javascript" src="scripts/gestionCmpt.js"></script>
<?php if ($role === "admin") echo '<script type="text/javascript"
	src="scripts/interactionsBtn.js"></script>'?>
<script src="scripts/entete.js"></script>
<script>
	/*** Gestion des données ***/
		// Récupérer l'ID utilisateur
	const idUtilisateur = <?php
		echo json_encode($_SESSION["idAgri"]); //idUser ?
	?>;

		// Récupère le nom et prénom de l'utilisateur
	afficherNomUtilisateur(idUtilisateur);

		// Récupère les données de l'utilisateur et rempli le formulaire avec
	afficherDonneesUtilisateur(idUtilisateur<?php
		if ($role === "admin") echo ", true";?>);

		// Gère les vérifications des champs du formulaire et l'envoi
	document.getElementById("reinit").addEventListener("click",	e => {
		e.preventDefault();
		reinitInputCmpt();
	});
	document.getElementById("enreg").addEventListener("click",	e => {
		e.preventDefault();
		modifInputCmpt(<?php if ($role === "admin") echo "true";?>);
	});
	document.querySelector("form").addEventListener("submit", e => {
		e.preventDefault();
		modifInputCmpt(<?php if ($role === "admin") echo "true";?>);
	});

		// Gère la suppression du compte
	const dialogConfirmer = document.getElementById("quitter");
	document.getElementById("suppr").addEventListener("click",	e => {
		dialogConfirmer.showModal();
	});
	dialogConfirmer.addEventListener("click", e => {
		if (e.target.value === "confirmer") {
			supprCmpt(idUtilisateur);
		}
	});

		// Gère le changement couleur de l'icône
	chgmtCouleurIcone();

		// Gère le selecteur de rôle
	<?php if ($role === "admin") include "assets/scriptSelecteurAdmin.php"?>


	/** Changements du DOM **/
		// Gère le défilement vers le haut de la page
	activerDefilementHautPage();

		// Gère la taille du header en fonction du défilement
	activerHeaderReduit();
</script>
</body>
</html>