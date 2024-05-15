/**
 * Activer le défilement jusqu'en haut de la page, lors d'un clic sur le header
 * (sur les espaces vides de contenus)
 */
function activerDefilementHautPage() {
	// Sur le header
	defielementSurElement(document.querySelector("header"))

	// Sur les sections du header
	document.querySelectorAll("header > section").forEach(element => {
		defielementSurElement(element)
	});
}

/**
 * Active le défilement sur un élément spécifique
 *
 * @param {div} element - sur lequel activer le défilement
 */
function defielementSurElement(element) {
	// Ajoute le curseur "pointer" sur l'élément
	element.style.cursor = "pointer";

	// Ajoute l'événement de défilement
	element.addEventListener("click", function(e) {
		if (e.target !== this) {
			return;
		}

		window.scrollTo(0, 0);
	});
}

/**
 * Active la gestion du header réduit en fonction de la distance de défilement
 */
function activerHeaderReduit() {
	// Détermine la distance de défilement avant rétractation du header
	if (window.matchMedia("(max-width: 769px)").matches) {
		distanceScroll = 90;
	}
	else {
		distanceScroll = 35;
	}

	window.onload = function() {retracterScroll()};
	window.onscroll = function() {retracterScroll()};
}

/**
 * Rétracte le header en fonction de la distance de défilement
 */
function retracterScroll() {
	if (document.documentElement.scrollTop > distanceScroll) {
		// Header
		document.querySelector("header").classList
			.add("miseEchelleHeader");

		// Box centrale
		document.querySelector("header > a > picture > img").classList
			.add("masqueLogo");

		// Sections
		document.querySelectorAll("header > section")
			.forEach(function(section) {
				section.classList.add("miseEchelleSection");
			});
	}
	else {
		// Header
		document.querySelector("header").classList
			.remove("miseEchelleHeader");

		// Box centrale
		document.querySelector("header > a > picture > img").classList
			.remove("masqueLogo");

		// Sections
		document.querySelectorAll("header > section")
			.forEach(function(section) {
				section.classList.remove("miseEchelleSection");
			});
	}
}