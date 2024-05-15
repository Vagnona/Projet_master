/**
 * Récupère des données dans le back, en fonction du champPost, en
 * accédant à un fichier spécifié, dans le backend
 *
 * @param {formData} champPost - Champ à envoyer au back
 * @param {string} urlBackend - URL du backend
 * @returns {promise} - Promesse contenant les données récupérées
 */
function recupDonnees(champPost, fichierBackend) {
	return new Promise((resolve, reject) => {
		fetch("../backend/" + fichierBackend, {
			method: "POST",
			body: champPost
		})
		.then(reponse => {
			reponse.json()
				.then(retour => {
					resolve(retour);
				})
				.catch(err => {
					reject(err);
				})
		})
		.catch(err => {
			reject(err);
		});
	});
}