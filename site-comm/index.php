<?php
if (isset($_GET["lang"])) {
	if ($_GET["lang"] === "fr") {
		include "assets/tradFr.php";
	}
	elseif ($_GET["lang"] === "en") {
		include "assets/tradEn.php";
	}
	elseif ($_GET["lang"] === "de") {
		include "assets/tradDe.php";
	}
	else {
		include "assets/tradFr.php";
	}
}
else {
	include "assets/tradFr.php";
}
?><!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="UTF-8"/>
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<meta name="robots" content="noindex, nofollow"/>
	<meta name="color-scheme" content="light dark"/>
	<meta name="theme-color" content="#4caf50"/>
	<link rel="icon" type="image/webp" href="img/favicon.webp"/>
	<link rel="stylesheet" type="text/css" href="style/index.css"/>
	<title>Accueil</title>
</head>
<body tabindex='0'>
	<header>
		<div>
			<img src="img/AlsAgriNet.svg" alt="<?=$trad["header"]["alt"];?>"/>
			<h1>AlsAgriNet</h1>
		</div>
		<div>
			<h2><?=$trad["header"]["slogan"];?></h2>
			<div id="ddLang" class="dropdown" title=''>
				<button class="dropbtn">🇫🇷</button>
				<div id="selectLang" class="dropdownContent ddHeader">
					<a id="fr" href="?lang=fr">🇫🇷 Français</a>
					<a id="en" href="?lang=en">🇬🇧 English</a>
					<a id="de" href="?lang=de">🇩🇪 Deutsch</a>
				</div>
			</div>
		</div>
	</header>
	<div id="corps">
		<section>
			<h2><?=$trad["pres"]["titre"];?></h2>
			<p>
				<?=$trad["pres"]["contenu"] . PHP_EOL;?>
			</p>
		</section>
		<section id="services">
			<h2><?=$trad["serv"]["titre"];?></h2>
			<div>
				<ul>
					<?=$trad["serv"]["contenu"] . PHP_EOL;?>
				</ul>
				<div>
					<img src="img/rpi4.webp"
						alt="<?=$trad["serv"]["alt"];?>"/>
				</div>
			</div>
		</section>
		<section>
			<h2><?=$trad["apropos"]["titre"];?></h2>
			<p>
				<?=$trad["apropos"]["contenu"] . PHP_EOL;?>
			</p>
			<div id="equipe">
				<h3><?=$trad["apropos"]["equipe"]["titre"];?></h3>
				<div>
					<p>
						<?=$trad["apropos"]["equipe"]["contenu"] . PHP_EOL;?>
					</p>
					<img src="img/equipe.webp"
						alt="<?=$trad["apropos"]["equipe"]["alt"];?>"/>
				</div>
			</div>
			<div id="locaux">
				<h3>Nos locaux</h3>
				<div>
					<iframe title="Carte d'accès à notre local"
					src="https://www.google.com/maps/embed?pb=!1m14!1m8!1m3!1d5279.154413707231!2d7.762937!3d48.579646!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x0%3A0x617f2b3fe9ea7667!2sUnit%C3%A9%20de%20Formation%20de%20Recherche%20Math%C3%A9matique%20et%20Informatique%20(UFR)!5e0!3m2!1sfr!2suk!4v1606318473139!5m2!1sfr!2suk"
					style="border:0;" allowfullscreen="" aria-hidden="false"
					tabindex="0"></iframe>
					<section>
						<div>
							<h4><?=$trad["contact"]["courriel"];?></h4>
							<a href="mailto:projet@alsagrinet.alsace">
								projet@alsagrinet.alsace
							</a>
						</div>
						<div>
							<h4><?=$trad["contact"]["telephone"];?></h4>
							<a href="tel:+33-3-01-02-03-04">+33 3 01 02 03 04</a>
						</div>
						<div>
							<h4><?=$trad["contact"]["adresse"];?></h4>
							<a href="https://www.google.com/maps/place/Unit%C3%A9+de+Formation+de+Recherche+Math%C3%A9matique+et+Informatique+(UFR)/@48.5796169,7.7625071,17z/data=!4m8!1m2!2m1!1s7+Rue+Ren%C3%A9+Descartes,+67084+Strasbourg,+France!3m4!1s0x0:0x617f2b3fe9ea7667!8m2!3d48.579646!4d7.7629372">
								42 Rue des Pépins, 67000 Strasbourg, France
							</a>
						</div>
						<div>
							<h4><?=$trad["contact"]["horaires"];?></h4>
							<ul>
								<li><?=$trad["contact"]["jours"][1];?>8h - 17h</li>
								<li><?=$trad["contact"]["jours"][2];?>8h - 17h</li>
								<li><?=$trad["contact"]["jours"][3];?>10h - 17h</li>
								<li><?=$trad["contact"]["jours"][4];?>8h - 17h</li>
								<li><?=$trad["contact"]["jours"][5];?>8h - 17h</li>
								<li><?=$trad["contact"]["jours"][6];?>8h - 12h</li>
								<li><?=$trad["contact"]["jours"][7];?><?=$trad["contact"]["jours"]["ferme"];?></li>
							</ul>
						</div>
					</section>
				</div>
			</div>
			<div id="reseaux">
				<h3><?=$trad["apropos"]["rs"]["titre"]?></h3>
				<div>
					<a href="https://www.facebook.com/alsagrinet/"
						target="_blank" rel="noopener">
						<img src="img/icones/facebook.svg"
							alt="<?=$trad["apropos"]["rs"]["alt"]["fb"]?>"/>
						<p>Facebook</p>
					</a>
					<a href="https://www.x.com/AlsAgriNet"
						target="_blank" rel="noopener">
						<img src="img/icones/x.svg"
							alt="<?=$trad["apropos"]["rs"]["alt"]["x"]?>"/>
						<p>X</p>
					</a>
					<a href="https://www.linkedin.com/alsagrinet/"
						target="_blank" rel="noopener">
						<img src="img/icones/linkedin.svg"
							alt="<?=$trad["apropos"]["rs"]["alt"]["lkdn"]?>"/>
						<p>LinkedIn</p>
					</a>
				</div>
			</div>
		</section>
	</div>
	<div>
		<div id="bulle">
			<img src="img/icones/interrogation.svg"
				alt="<?=$trad["bulle"]["altBulle"]?>"/>
		</div>
		<div id="formulaire">
			<div id="enteteForm">
				<h2><?=$trad["bulle"]["titre"]?></h2>
				<div>
					<img src="img/icones/croix.svg"
						alt="<?=$trad["bulle"]["altEnt"]?>"/>
				</div>
			</div>
			<form>
				<label for="nom"><?=$trad["bulle"]["form"]["nom"]?></label>
				<input type="text" name="nom" id="nom"
					placeholder="<?=$trad["bulle"]["form"]["nom"]?>" required/>
				<label for="prenom"><?=$trad["bulle"]["form"]["prenom"]?>
				</label>
				<input type="text" name="prenom" id="prenom"
					placeholder="<?=$trad["bulle"]["form"]["prenom"]?>"
					required/>
				<label for="email"><?=$trad["bulle"]["form"]["courriel"]?>
				</label>
				<input type="email" name="courriel" id="courriel"
					placeholder="<?=$trad["bulle"]["form"]["phCourriel"]?>"
					required/>
				<label for="message" aria-required>
					<?=$trad["bulle"]["form"]["message"]?>
				</label>
				<textarea id="message"
					placeholder="<?=$trad["bulle"]["form"]["phMessage"]?>"
					required></textarea>
				<input type="submit"
					value="<?=$trad["bulle"]["form"]["envoi"]?>"/>
			</form>
		</div>
	</div>
	<footer>
		<?=$trad["footer"]["droits"]?> - AlsAgriNet - 2024
	</footer>
<script src="scripts/recupDonnees.js"></script>
<script src="scripts/formulaire.js"></script>
<script>
	// Enregistrement du message de contact
	document.querySelector("#formulaire > form").addEventListener("submit",
	(e) => {
		enregistrementContact(e, "<?=$trad["langue"]["abrevia"];?>");
	});
	document.querySelector("#formulaire input[type=submit]").addEventListener(
	"click", e => {
		enregistrementContact(e, "<?=$trad["langue"]["abrevia"];?>");
	});

	// Affichage du formulaire
	document.querySelector("#bulle").addEventListener("click", () => {
		const formulaire = document.querySelector("#formulaire");
		formulaire.classList.toggle("visible");
	});
	document.querySelector("#formulaire > div").addEventListener("click", _ => {
		const formulaire = document.querySelector("#formulaire");
		formulaire.classList.remove("visible");
	});

	// Selecteur de langue
	document.getElementById("<?=$trad["langue"]["abrevia"];?>").classList
		.add("selected");
	document.querySelector("#ddLang > button").innerHTML =
		"<?=$trad["langue"]["drap"];?>";
</script>
</body>
</html>
