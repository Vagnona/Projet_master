/**
 * Vérifie les champs de Prénom, Nom et Courriel du formulaire, lorsqu'un
 * événement se produit
 *
 * @returns {int} - le nombre de champs incorrects
 */
function verifInputCmpt() {
	let nbrErr = 0;

	// Regex
	const regexInput = /^[\S\s]{1,100}$/;

	/* Fonction de vérification des champs */
		// Au chargement de la page
	function inputPreVerif(donnee) {
		if (donnee.value.match(regexInput) === null) {
			donnee.classList.add("erreur");
			nbrErr++;
		}
	}

		// Pendant que le champ est rempli
	const inputPostVerif = function() {
		if (this.value.match(regexInput) === null) {
			this.classList.add("erreur");
			nbrErr++;
		}
		else {
			this.classList.remove("erreur");
			nbrErr--;
		}
	}

	/* Vérification des champs */
		// Prénom
	let prenomInput = document.getElementById("prenom");
	inputPreVerif(prenomInput);
	prenomInput.addEventListener("input", inputPostVerif);

		// Nom
	let nomInput = document.getElementById("nom");
	inputPreVerif(nomInput);
	nomInput.addEventListener("input", inputPostVerif);

		// Courriel
	nbrErr += verifInputCourriel();

	return nbrErr;
}

/**
 * Vérifie le champ du rôle dans le formulaire, lorsqu'un événement se produit
 * Le rôle doit être "admin" ou "standard"
 *
 * @returns {int} - le nombre de champs incorrects
 */
function verifSelectRole() {
	let nbrErr = 0;

	let roleInput = document.getElementById("role");
	if (roleInput.value !== "admin" && roleInput.value !== "standard") {
		roleInput.classList.add("erreur");
		nbrErr++;
	}
	roleInput.addEventListener("input", function() {
		if (roleInput.value !== "admin" && roleInput.value !== "standard") {
			this.classList.add("erreur");
			nbrErr++;
		}
		else {
			this.classList.remove("erreur");
			nbrErr--;
		}
	});

	return nbrErr;
}

/**
 * Vérifie le champ du courriel dans le formulaire, lorsqu'un événement se
 * produit
 * Le courriel doit contenir au moins 1 caractère avant le @, 1 caractère entre
 * le '@' et le '.', 1 caractère après le '.'
 *
 * @returns {int} - le nombre de champs incorrects
 */
function verifInputCourriel() {
	let nbrErr = 0;

	// Regex
	const regexCourriel = /^[a-z0-9-_.]+@[a-z0-9-_.]+\.[a-z]{1,}$/;

	/* Fonction de vérification des champs */
		// Au chargement de la page
	let courrielInput = document.getElementById("courriel");
	if (courrielInput.value.match(regexCourriel) === null) {
		courrielInput.classList.add("erreur");
		nbrErr++;
	}

		// Pendant que le champ est rempli
	courrielInput.addEventListener("input", function() {
		if (this.value.match(regexCourriel) === null) {
			this.classList.add("erreur");
			nbrErr++;
		}
		else {
			this.classList.remove("erreur");
			nbrErr--;
		}
	});

	return nbrErr;
}

/**
 * Vérifie le champ du mot de passe dans le formulaire, lorsqu'un événement se
 * produit
 * Le mot de passe doit contenir au moins 14 caractères, 1 chiffre, 1 minuscule,
 * 1 majuscule et 1 caractère spécial
 *
 * @returns {int} - le nombre de champs incorrects
 */
function verifInputMdp() {
	let nbrErr = 0;

	// Regex
	const regexMdp = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()\-_=+{};:,<.>]).{14,}$/;

	/* Fonction de vérification des champs */
		// Au chargement de la page
	let mdpInput = document.getElementById("mdp");
	if (mdpInput.value.match(regexMdp) === null) {
		mdpInput.classList.add("erreur");
		nbrErr++;
	}

		// Pendant que le champ est rempli
	mdpInput.addEventListener("input", function() {
		if (this.value.match(regexMdp) === null) {
			this.classList.add("erreur");
			nbrErr++;
		}
		else {
			this.classList.remove("erreur");
			nbrErr--;
		}
	});

	return nbrErr;
}

/**
 * Vérifie les champs du formulaire de modification d'un compte, lorsqu'un
 * événement se produit
 * Le format de la couleur doit être # suivi de 6 caractères hexadécimaux
 *
 * @returns {int} - le nombre de champs incorrects
 */
function verifCouleur() {
	let nbrErr = 0;

	// Regex
	const regexCouleur = /^#[0-9a-f]{6}$/i;

	/* Fonction de vérification des champs */
		// Au chargement de la page
	function inputPreVerif(donnee) {
		if (donnee.value.match(regexCouleur) === null) {
			donnee.classList.add("erreur");
			nbrErr++;
		}
	}

		// Pendant que le champ est rempli
	const inputPostVerif = function() {
		if (this.value.match(regexCouleur) === null) {
			this.classList.add("erreur");
			nbrErr++;
		}
		else {
			this.classList.remove("erreur");
			nbrErr--;
		}
	}

	/* Vérification des champs */
		// Couleur 1
	let couleur1Input = document.getElementById("couleur1");
	inputPreVerif(couleur1Input);
	couleur1Input.addEventListener("input", inputPostVerif);

		// Couleur 2
	let couleur2Input = document.getElementById("couleur2");
	inputPreVerif(couleur2Input);
	couleur2Input.addEventListener("input", inputPostVerif);

	return nbrErr;
}