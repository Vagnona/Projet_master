<?php
	include "backend/checkConnexion.php";
	$role = $_SESSION["role"]; // "admin" ou "standard"
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<?php include "assets/head.php"; echo PHP_EOL;?>
	<title>Gestion champs</title>
	<meta name="description" content="Gestion de champs"/>
	<link rel="stylesheet" type="text/css" href="style/index.css"/>
</head>
<body tabindex='0'>
<header>
	<?php include "assets/logo.php"?>
	<section title="Retourner en haut de la page">
		<p title=''>-</p>
		<div id="ddChamp" class="dropdown" title=''>
			<button class="dropbtn">⇩</button>
			<div id="selectChamp" class="dropdownContent ddHeader">
			</div>
		</div>
	</section>
	<section title="Retourner en haut de la page">
		<p title=''>-</p>
		<div id="ddCmpt" class="dropdown" title=''>
			<button class="dropbtn">⇩</button>
			<div id="selectCmpt" class="dropdownContent ddHeader">
				<a href="gestionCmpt.php">Gestion du compte</a>
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
	<section id="secInfosMoy">
		<section id="secInfos" class="containerDoubleVerti">
			<h1>Informations sur le champ</h1>
			<section>
				<div>
					<h1>État général</h1>
					<p>-</p>
				</div>
				<div>
					<h1>Nombre de capteurs</h1>
					<div id="nbrCapteurs">
						<p>-</p>
						<p>/</p>
						<p>-</p>
					</div>
				</div>
				<div>
					<h1>Dernière actualisation</h1>
					<p>-</p>
				</div>
			</section>
		</section>

		<section id="secMoyennes" class="containerDoubleVerti">
			<h1>Moyennes des mesures sur le champ</h1>
			<section>
				<div>
					<h1>Température</h1>
					<p>-</p>
				</div>
				<div>
					<h1>Humidité du sol</h1>
					<p>-</p>
				</div>
				<div>
					<h1>Luminosité</h1>
					<p>-</p>
				</div>
			</section>
		</section>
	</section>
	<section class="containerSecVerti">
		<h1>Évolution des mesures dans le temps sur l'ilot</h1>
		<section id="secGraph">
			<div id="optGraph" class="options">
				<div>
					<p>Température</p>
					<div id="ddType" class="dropdown">
						<button class="dropbtn">⇩</button>
						<div id="selectType" class="dropdownContent">
							<button value="temp">Température</button>
							<button value="humi">Humidité du sol</button>
							<button value="lumi">Luminosité</button>
						</div>
					</div>
				</div>
				<div>
					<p>Ilot</p>
					<div id="ddIlot" class="dropdown">
						<button class="dropbtn">⇩</button>
						<div id="selectIlot" class="dropdownContent ilot">
						</div>
					</div>
				</div>
			</div>
			<div id="graph">
			</div>
		</section>
	</section>
	<section class="containerSecVerti">
		<h1>Récapitulatif des mesures relevées sur le champ</h1>
		<section id="secTableau" class="tableau">
			<div>
				<div class="cellule titre">Ilot</div>
				<div class="cellule titre">Date et heure</div>
				<div class="cellule titre">État</div>
				<div class="cellule titre">Température (°C)</div>
				<div class="cellule titre">Humidité du sol (%)</div>
				<div class="cellule titre">Luminosité (lux)</div>
			</div>
			<div id="donneesTableau">
			</div>
		</section>
	</section>
	<section class="containerSecVerti">
		<h1>Prévisions météorologiques sur le champ</h1>
		<section id="secMeteo" class="tableau">
			<div>
				<div class="cellule titre">
					<p>
						Date
					</p>
					<div id="ddDuree" class="dropdown">
						<button class="dropbtn">⇩</button>
						<div id="selectDuree" class="dropdownContent">
							<button value="semaine">Semaine</button>
							<button value="jour">Journée</button>
						</div>
					</div>
				</div>
				<div class="cellule titre">Temp. max (°C)</div>
				<div class="cellule titre">Temp. min (°C)</div>
				<div class="cellule titre">Temp. (°C)</div>
				<div class="cellule titre">Humi. (%)</div>
				<div class="cellule titre">Précip. (mm/m²)</div>
				<div class="cellule titre">Type précip.</div>
				<div class="cellule titre">Dir. vent (°)</div>
				<div class="cellule titre">Couv. nua. (%)</div>
				<div class="cellule titre">UV</div>
				<div class="cellule titre">Vit. vent (km/h)</div>
			</div>
			<div id="donneesMeteo">
			</div>
		</section>
	</section>
	<section class="containerSecVerti">
		<h1>Export des données du champ</h1>
		<section id="secExport">
			<div id="optExport" class="options">
				<div>
					<p>Type de données</p>
					<div id="ddTypeExport" class="dropdown">
						<button class="dropbtn">⇩</button>
						<div id="selectTypeExport" class="dropdownContent">
							<button value="tous">Toutes mesures</button>
							<button value="temp">Température</button>
							<button value="humi">Humidité du sol</button>
							<button value="lumi">Luminosité</button>
						</div>
					</div>
				</div>
				<div>
					<p>Durée</p>
					<div id="ddTypeExport" class="dropdown">
						<button class="dropbtn">⇩</button>
						<div id="selectDureeExport" class="dropdownContent">
							<button value="7">Semaine passée</button>
							<button value="31">Mois passé</button>
							<button value="365">Année passée</button>
						</div>
					</div>
				</div>
				<div>
					<p>Ilot</p>
					<div id="ddIlotExport" class="dropdown">
						<button class="dropbtn">⇩</button>
						<div id="selectIlotExport" class="dropdownContent ilot">
						</div>
					</div>
				</div>
			</div>
			<div id="export">
				<button id="btnExport" class="btn">Exporter en CSV</button>
			</div>
		</section>
	</section>
</div>
<?php include "assets/footer.php"?>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plotly.js/2.27.0/plotly-basic.min.js"
integrity="sha512-TiY/d3GpuSKgQYgnqegSfdqlXp6ebBvi6A47mFTMSpZM7BMbvfkkvU/SlDzZHs9lWqF+BteevHlqgauHhLLbIA=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/plotly.js/2.27.0/plotly-locale-fr.min.js"
integrity="sha512-nyAFXuhmcYPFCAawwaZOW22viMZW5Aw1jB7w84GbnbPqIz1SDHWGdQw17DB2BfU1jv4nnEdJgvolNINTjdSKMA=="
crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script src="scripts/interactionsBtn.js"></script>
<script src="scripts/recupDonnees.js"></script>
<script src="scripts/afficherDonnees.js"></script>
<script src="scripts/classesCouleurs.js"></script>
<script src="scripts/graphique.js"></script>
<script src="scripts/entete.js"></script>
<script>
	/*** Variables et constantes ***/
		/*
		 * Tableau de tableau contenant les ID des containers des dropdowns et
		 * les ID des boutons à ajouter quand ils sont sélectionnés
		*/
	const contIdButtons = [
		["selectChamp", "champSlct", true],
		["selectCmpt", "cmptSlct", false],
		["selectType", "typeSlct", true],
		["selectIlot", "ilotSlct", true],
		["selectDuree", "dureeSlct", true],
		["selectTypeExport", "typeExportSlct", true],
		["selectDureeExport", "dureeExportSlct", true],
		["selectIlotExport", "ilotExportSlct", true]
	];

		// Préselectionne les boutons des dropdowns
	contIdButtons.forEach(element => {
		activerBouton(element[0], element[1], element[2]);
	});

		// Retours des paramètres du graphique
	let typeMesuresStr, unite;
	let rangeMin, rangeMinMob, rangeMax, ordMin, ordMax;


	/*** Affichage des données ***/
		// Récupérer l'ID utilisateur
	const idUtilisateur = <?php
		echo json_encode($_SESSION["idAgri"]); //idUser ?
	?>;

		// Récupère le nom et prénom de l'utilisateur
	afficherNomUtilisateur(idUtilisateur);

		// Affiche les champs de l'utilisateur
	afficherChamps(idUtilisateur)
	.then(_ => {
		// Active les boutons des champs
		activerBouton(contIdButtons[0][0], contIdButtons[0][1],
			contIdButtons[0][2]);

		/*
		 * Active la fonction de changement de champ pour charger les nouveaux
		 * ilots dans le dropdown
		 */
		activerBoutonChgmtChamp(idUtilisateur, contIdButtons);

		// Affiche la météo pour le champ sélectionné
		afficherMeteo(idUtilisateur);

		/**
		 * Affiche le nom de l'utilisateur, les informations du champ,
		 * les moyennes, les mesures et les ilots disponibles
		 */
		helperAffichageDonneesChamp(idUtilisateur)
		.then(_ => {
			// Active les boutons des ilots
			activerBouton(contIdButtons[3][0], contIdButtons[3][1],
				contIdButtons[3][2]);
			activerBouton(contIdButtons[7][0], contIdButtons[7][1],
				contIdButtons[7][2]);

			// Affiche le graphique (nécessite de connaitre l'ilot sélectionné)
			helperAfficherGraph();
		});
	});


	/*** Interaction des boutons ***/
		// Bouton pour changer la temporalité de la météo
	let dropdownDuree = document.getElementById("ddDuree");
	dropdownDuree.addEventListener("click", _ => {
		const valChamp = document.getElementById("dureeSlct").value;
		afficherMeteo(idUtilisateur);
	});

		// Bouton pour changer la sélection du graphique (type de données/ilot)
	let dropdownTypeGraph = document.getElementById("ddType");
	dropdownTypeGraph.addEventListener("click", _ => {
		helperAfficherGraph();
	});
	let dropdownIlotGraph = document.getElementById("ddIlot");
	dropdownIlotGraph.addEventListener("click", _ => {
		helperAfficherGraph();
	});

		// Bouton pour exporter les données
	document.getElementById("btnExport").addEventListener("click", _ => {
		exportCSV(idUtilisateur);
	});


	/*** Changements du DOM ***/
		// Gère le défilement vers le haut de la page
	activerDefilementHautPage();

		// Gère la taille du header en fonction du défilement
	activerHeaderReduit();

		// Gère les changements de thème pour le graphique
	window.matchMedia("(prefers-color-scheme: light)")
	.addEventListener("change",	_ => {
		helperActualisationStyleGraph();
	});

		// Gère les changements de taille d'écran pour le graphique
	window.matchMedia("(max-width: 769px)").addEventListener("change", _ => {
		helperActualisationStyleGraph();
	});
</script>
</body>
</html>