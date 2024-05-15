/**
 * Paramètre le graphique, récupère les données et affiche l'ensemble
 *
 * @param {int} numChamp - Numéro du champ
 * @param {int} numIlot - Numéro de l'ilot
 * @param {string} typeMesures - Type de mesures à récupérer
 * @returns {Promise} - Un tableau contenant les paramètres du graphique
 * 						et le type de mesures
 */
function afficherGraphique(numChamp, numIlot, typeMesures) {
	let typeMesuresStr, unite, degrade, margeMesure;
	if (typeMesures === "humi") {
		[typeMesuresStr, unite, degrade, min, max, margeMesure] =
			["Humidité", "%", new CouleursDonneesHum(), 25, 75, 5];
	}
	else if (typeMesures === "temp") {
		[typeMesuresStr, unite, degrade, min, max, margeMesure] =
			["Température", "°C", new CouleursDonneesTemp(), 10, 30, 5];
	}
	else if (typeMesures === "lumi") {
		[typeMesuresStr, unite, degrade, min, max, margeMesure] =
			["Luminosité", " lux", new CouleursDonneesLumi(), 0, 100000, 10000];
	}
	else {
		console.error("Type de mesures inconnu \"" + typeMesures + "\"");
		return;
	}

	// Configure les paramètres du graphique
	const config = {
		locale: "fr",
		responsive: true,
		displayModeBar: false,
		showAxisDragHandles: false
	}

	// Récupère les données et affiche le graphique
	return new Promise((resolve, reject) => {
		let champPost = new FormData();
		champPost.append("numChamp", numChamp);
		champPost.append("numIlot", numIlot);
		champPost.append("typeMesures", typeMesures);

		recupDonnees(champPost, "recupMesuresIlot.php")
		.then(retour => {
			const abscisse = retour[0];
			const ordonnee = retour[1];

			// Détermine la valeur minimale de l'axe des ordonnées
			const ordMin = Math.min.apply(Math, ordonnee) - margeMesure;
			const ordMax = Math.max.apply(Math, ordonnee) + margeMesure;

			// Détermine le zoom (intervalle) minimum du graphique
			const rangeMin = abscisse[0];
			const rangeMinMob = abscisse[abscisse.length - (7 * 24) - 1];
			const rangeMax = abscisse[abscisse.length - 1]

			// Configure les données
			const data = [{
				x: abscisse,
				y: ordonnee,
				fill: "tozeroy",
				mode: "lines+markers",
				connectgaps: true,
				marker: {
					colorscale: degrade.getPairesPourcentCouleur(),
					color: ordonnee,
					size: 6,
					cmin: min,
					cmax: max
				},
				line: {
					width: 2,
					shape: "spline"
				},
				hoverlabel: {
					align: "left",
					bordercolor: "transparent",
					font: {
						family: "Open Sans",
						color: "#000000"
					}
				}
			}];

			// Configure le style
			const layout = confLayout(rangeMin, rangeMinMob, rangeMax,
				ordMin, ordMax, unite);

			// Complémente le style des données
			const complementData = confData(typeMesuresStr, unite);

			// Affiche le graphique
			Plotly.newPlot("graph", data, layout, config);
			Plotly.restyle("graph", complementData);

			resolve(Array(
				[typeMesuresStr, unite],
				[rangeMin, rangeMinMob, rangeMax, ordMin, ordMax]
			));
		})
		.catch(err => {
			reject(err);
		});
	});
}

/**
 * Génère la configuration du style des données pour le graphique
 *
 * @param {string} typeMesuresStr - Type de mesures à récupérer
 * @param {string} unite - Unité de la mesure
 * @returns {object} - Un objet contenant la configuration du style
 */
function confData(typeMesuresStr, unite) {
	// Adapate le graphique en fonction de la taille de l'écran
	const formatMois = (window.matchMedia("(max-width: 769px)").matches) ?
		"%b" : "%B";

	// Récupère les couleurs en fonction du thème
	const couleursGraph =
		(window.matchMedia("(prefers-color-scheme: light)").matches) ?
		new CouleursClaires() : new CouleursSombres();
	const [lineColor, fillColor] = couleursGraph.getCouleursData();

	// Adapte la précision des données en fonction de l'unité
	let formatDonnees = ".1f";
	if (unite === " lux") {
		formatDonnees = ".0f";
	}

	// Configure les données
	const data = {
		fillcolor: fillColor,
		line: {color: lineColor},
		hovertemplate: "<b>" + typeMesuresStr + " :</b> %{y:" + formatDonnees +
						"}" + unite + "<br><b>Date :</b> %{x|%a %-d " +
						formatMois + " à %Hh%M}<extra></extra>"
	}

	return data;
}

/**
 * Génère la configuration du layout pour le graphique
 *
 * @param {string} rangeMin - Date de début du graphique
 * @param {string} rangeMinMob - Date de début du graphique pour mobile
 * @param {string} rangeMax - Date de fin du graphique
 * @param {int} ordMin - Valeur minimale de l'axe des ordonnées
 * @param {int} ordMax - Valeur maximale de l'axe des ordonnées
 * @param {string} unite - Unité de la mesure
 * @returns {object} - Un objet contenant la configuration du layout
 */
function confLayout(rangeMin, rangeMinMob, rangeMax, ordMin, ordMax, unite) {
	// Récupère les couleurs en fonction du thème
	const couleursGraph =
		(window.matchMedia("(prefers-color-scheme: light)").matches) ?
		new CouleursClaires() : new CouleursSombres();
	const [bgColor, gridColor, fontColor] = couleursGraph.getCouleursLayout();

	// Configure le placement du graphique, les ticks et les labels
	let [top, right, bottom, left, nTicks, tickAngle, formatMois] =
		[10, 10, 40, 55, 8, 0, "%B"];

	// Adapte la précision des données en fonction de l'unité
	let formatDonnees = ".1f";
	let tickAngleY = tickAngle;
	if (unite === " lux") {
		formatDonnees = ".0f";
		tickAngleY = -35;
	}

	// Adapate le graphique en fonction de la taille de l'écran
	if (window.matchMedia("(max-width: 769px)").matches) {
		[top, right, bottom, left, nTicks, tickAngle, formatMois] =
			[0, 7, 70, 23, 6, -70, "%b"];

		rangeMin = rangeMinMob;
		tickAngleY = tickAngle;

		if (unite === " lux") {
			tickAngleY = -75;
		}
	}

	// Configure le style
	const layout = {
		showlegend: false,
		separators: ".,",
		plot_bgcolor: bgColor,
		paper_bgcolor: bgColor,
		margin: {
			t: top,
			r: right,
			b: bottom,
			l: left,
			pad: 4
		},
		font: {
			family: "Open Sans",
			color: fontColor
		},
		xaxis: {
			showgrid: false,
			nticks: nTicks,
			tickangle: tickAngle,
			range: [rangeMin, rangeMax],
			tickformatstops: [
				{
					"dtickrange": [null, 60000],
					"value": "%-d " + formatMois + "<br>%Hh%M.%S"
				},
				{
					"dtickrange": [60000, 3600000],
					"value": "%-d " + formatMois + "<br>%Hh%M"
				},
				{
					"dtickrange": [3600000, 86400000],
					"value": "%-d " + formatMois + "<br>%Hh%M"
				},
				{
					"dtickrange": [86400000, null],
					"value": "%-d " + formatMois
				}
			]
		},
		yaxis: {
			gridcolor: gridColor,
			gridcolorwidth: 1,
			range: [ordMin, ordMax],
			nticks: nTicks,
			tickangle: tickAngleY,
			zeroline: false,
			fixedrange: true,
			tickformat: formatDonnees,
			ticksuffix: unite,
			tickformat: (value) => {
				if (value >= 1000) {
					return (value / 1000) + 'k';
				}
			}
		}
	}

	return layout;
}

/**
 * Affiche le graphique et renvoie les données nécessaires à son actualisation
 *
 * @returns {promise} - Les paramètres du graphique
 */
function helperRecupParamsGraph() {
	const valChamp = document.getElementById("champSlct").value;
	const valIlot = document.getElementById("ilotSlct").value;
	const valType = document.getElementById("typeSlct").value;

	return new Promise((resolve, reject) => {
		afficherGraphique(parseFloat(valChamp), valIlot, valType)
		.then(retour => {
			resolve(retour);
		})
		.catch(err => {
			reject(err);
		});
	});
}

/**
 * Lance l'affichage du graphique et enregistre les données nécessaires à son
 * actualisation, lorsque le graphique a été affiché
 */
function helperAfficherGraph() {
	helperRecupParamsGraph()
	.then(retour => {
		[typeMesuresStr, unite] = retour[0];
		[rangeMin, rangeMinMob, rangeMax, ordMin, ordMax] = retour[1];
	})
	.catch(err => {
		console.error(err);
	});
}

/**
 * Actualise le graphique avec les paramètres adaptés (thème, taille de l'écran)
 */
function helperActualisationStyleGraph() {
	const data = confData(typeMesuresStr, unite);
	const layout = confLayout(rangeMin, rangeMinMob, rangeMax, ordMin, ordMax,
		unite);
	Plotly.restyle("graph", data);
	Plotly.relayout("graph", layout);
}