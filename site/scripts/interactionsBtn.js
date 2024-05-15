/**
 * Activer les boutons d'un dropdown. Si un bouton est sélectionné, il est
 * marqué d'un ID unique, permettant de récupérer sa valeur facilement.
 *
 * @param {string} idContainer - ID du container du dropdown
 * @param {string} idAttr - ID à attribuer au bouton sélectionné
 * @param {bool} activerPreselect - Si true, sélectionne le premier bouton
 */
function activerBouton(idContainer, idAttr, activerPreselect) {
	const dropdownContent = document.getElementById(idContainer);
	const buttons = dropdownContent.querySelectorAll("button");

	buttons.forEach((button, index) => {
		button.addEventListener("click", _ => {
			// Récupérer la valeur du bouton sélectionné
			const valeurSelectionnee = button.value;

			// Marquer le bouton comme sélectionné
			buttons.forEach(btn => {
				if (btn.value === valeurSelectionnee) {
					btn.classList.add("selected");
					btn.setAttribute("id", idAttr);

					afficherTitreDropdown(idContainer, idAttr);
				}
				else {
					btn.classList.remove("selected");
					btn.removeAttribute("id");
				}
			});
		});

		/*
		 * Ajouter la classe "selected" et l'id avec comme valeur idAttr au
		 * premier button, si aucun autre ne possède déjà la classe
		 */
		if (
			activerPreselect === true &&
			index === 0 &&
			!button.classList.contains("selected")
		) {
			button.classList.add("selected");
			button.setAttribute("id", idAttr);

			afficherTitreDropdown(idContainer, idAttr);
		}
	});
}

/**
 * Modifie le texte adjacent au dropdown pour afficher la valeur sélectionnée
 *
 * @param {string} idContainer - ID du container du dropdown
 * @param {string} idAttr - ID attribué au bouton sélectionné
 */
function afficherTitreDropdown(idContainer, idAttr) {
	// Titre du champ
	if (idContainer === "selectChamp") {
		afficherChampSelectionne(idContainer, idAttr);
	}

	// Titre de l'ilot
	else if (
		idContainer === "selectIlot" ||
		idContainer === "selectIlotExport"
	) {
		afficherIlotSelectionne(idContainer, idAttr);
	}

	// Titre du type de mesure
	else if (
		idContainer === "selectType" ||
		idContainer === "selectTypeExport"
	) {
		afficherMesureSelectionnee(idContainer, idAttr);
	}

	// Titre durée mesure export
	else if (idContainer === "selectDureeExport") {
		afficherDureeSelectionnee(idContainer, idAttr);
	}
}

/**
 * Affiche le nom du champ sélectionné dans le header
 *
 * @param {string} idContainer - ID du container du dropdown
 * @param {string} idAttr - ID attribué au bouton sélectionné
 */
function afficherChampSelectionne(idContainer, idAttr) {
	const container = document.getElementById(idContainer).parentNode
		.previousElementSibling;
	container.textContent = "Champ " +
		document.getElementById(idAttr).value;
}

/**
 * Affiche le numéro de l'ilot sélectionné dans les options du graphique et
 * de l'export de données
 *
 * @param {string} idContainer - ID du container du dropdown
 * @param {string} idAttr - ID attribué au bouton sélectionné
 */
function afficherIlotSelectionne(idContainer, idAttr) {
	const container = document.getElementById(idContainer).parentNode
		.previousElementSibling;

	if (document.getElementById(idAttr).value === "-1") {
		container.textContent = "Tous les ilots";
		return;
	}

	container.textContent = "Ilot " + document.getElementById(idAttr).value;
}

/**
 * Affiche le type de mesure sélectionné dans les options du graphique et
 * de l'export de données
 *
 * @param {string} idContainer - ID du container du dropdown
 * @param {string} idAttr - ID attribué au bouton sélectionné
 */
function afficherMesureSelectionnee(idContainer, idAttr) {
	const container = document.getElementById(idContainer).parentNode
		.previousElementSibling;
	container.textContent = document.getElementById(idAttr).textContent;
}

/**
 * Affiche la durée de mesure sélectionnée dans les options de l'export de
 * données
 *
 * @param {string} idContainer - ID du container du dropdown
 * @param {string} idAttr - ID attribué au bouton sélectionné
 */
function afficherDureeSelectionnee(idContainer, idAttr) {
	const container = document.getElementById(idContainer).parentNode
	.previousElementSibling;
	container.textContent = document.getElementById(idAttr)
		.textContent;
}

/**
 * Active la gestion de la mise à jour des ilots disponibles en fonction du
 * champ sélectionné.
 * Lance également la mise à jour du graphique pour le nouvel ilot sélectionné
 * par défaut.
 *
 * @param {int} idUtilisateur - ID de l'utilisateur
 * @param {array} contIdButtons - ID des containers des boutons
 */
function activerBoutonChgmtChamp(idUtilisateur, contIdButtons) {
	const dropdownContent = document.getElementById(contIdButtons[0][0]);
	const buttons = dropdownContent.querySelectorAll("button");

	buttons.forEach(button => {
		button.addEventListener("click", _ => {
			afficherMeteo(idUtilisateur);
			helperAffichageDonneesChamp(idUtilisateur)
			.then(_ => {
				// Active les boutons des ilots
				activerBouton(contIdButtons[3][0], contIdButtons[3][1],
					contIdButtons[3][2]);
				activerBouton(contIdButtons[7][0], contIdButtons[7][1],
					contIdButtons[7][2]);

				// Mets à jour le graphique
				helperAfficherGraph();
			});
		});
	});
}

/**
 * Converti les données passées en paramètre en CSV
 *
 * @param {array} donnees - à convertir
 * @returns {string} - les données converties en CSV
 */
function convertirEnCSV(donnees) {
	let csv = '';

	// Ajoute les titres des colonnes
	csv += "numChamp;numIlot;dateHeureMesure;temp;humi;lumi\n"

	// Ajoute les données
	donnees.forEach(donnee => {
		csv += donnee.join(";") + "\n";
	});

	return csv;
}

/**
 * Lance le téléchargement d'un fichier, avec les données passées en paramètre
 *
 * @param {string} nomFichier - à télécharger
 * @param {string} donnees - à placer dans le fichier
 */
function lancerTelechargement(nomFichier, donnees) {
	// Créé un lien de téléchargement, avec les données à télécharger
	const container = document.createElement('a');
	container.setAttribute("href", "data:text/plain;charset=utf-8," +
		encodeURIComponent(donnees));
	container.setAttribute("download", nomFichier);

	// Ajoute le lien au DOM
	container.style.display = "none";
	document.body.appendChild(container);

	// Clique sur le lien pour lancer le téléchargement
	container.click();

	// Supprime le lien du DOM
	document.body.removeChild(container);
}

/**
 * Exporte les données de l'utilisateur au format CSV
 *
 * @param {int} idUtilisateur - ID de l'utilisateur
 */
function exportCSV(idUtilisateur) {
	const valChamp = document.getElementById("champSlct").value;
	const valType = document.getElementById("typeExportSlct").value
	const valDuree = document.getElementById("dureeExportSlct").value;
	const valIlot = document.getElementById("ilotExportSlct").value;

	let champPost = new FormData();
	champPost.append("idUtilisateur", idUtilisateur);
	champPost.append("champ", valChamp);
	champPost.append("type", valType);
	champPost.append("duree", valDuree);
	champPost.append("ilot", valIlot);

	recupDonnees(champPost, "recupExport.php")
	.then(retour => {
		lancerTelechargement("export.csv", convertirEnCSV(retour));
	})
	.catch(err => {
		console.error(err);
	});
}