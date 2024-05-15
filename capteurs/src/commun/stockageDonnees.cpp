#include "stockageDonnees.hpp"

/* Public */

std::vector<std::string> StockageDonnees::recupereParams(
	const std::string cheminFichier
) {
	// Ouvre le fichier
	std::ifstream fichierParams(cheminFichier);
	std::string ligne;
	std::vector<std::string> tableauRetour;

	// Si le fichier est ouvert
	if (fichierParams) {
		// Parcours le fichier
		while (getline(fichierParams, ligne)) {
			// Si la ligne est un commentaire
			if (ligne[0] == '#') {
				continue;
			}

			tableauRetour.push_back(ligne);
		}
	}
	else {
		std::cerr << "Impossible d'ouvrir le fichier " << cheminFichier <<
			std::endl;
	}

	return tableauRetour;
}

int StockageDonnees::ecrireDonneesFichier(
	const std::string& cheminFichierMesures,
	InfosChamp infosChamp,
	Mesures mesures
) {
	// Créé le dossier s'il n'existe pas
	std::filesystem::create_directory(DOSSIER_STOCKAGE);

	// Ecrit les données dans le fichier
	std::ofstream file(cheminFichierMesures, std::ios::app);
	if (file.is_open()) {
		file <<
			mesures.getDate() << ';' <<
			infosChamp.getIdAgri() << ';' <<
			infosChamp.getIdChamp() << ';' <<
			infosChamp.getIdIlot() << ';' <<
			mesures.getTemperature() << ';' <<
			mesures.getHumidite() << ';' <<
			mesures.getLuminosite() <<
			std::endl;
		file.close();
	}
	else {
		std::cerr << "Impossible d'ouvrir le fichier : \"" <<
			cheminFichierMesures << "\"" << std::endl;
		return EXIT_FAILURE;
	}
	return EXIT_SUCCESS;
}

std::string StockageDonnees::dateUTCActuelle() {
	// Récupère la date actuelle
	auto dateActuelle = std::chrono::system_clock::now();

	// Converti en temps UTC
	std::time_t dateActuelleUTC = std::chrono::system_clock::to_time_t(
		dateActuelle);

	// Formate la date en string
	char buffer[20];
	std::strftime(buffer, sizeof(buffer), "%Y-%m-%d %H:%M:%S",
		std::gmtime(&dateActuelleUTC));

	return buffer;
}

void StockageDonnees::agregeFichiersDonnees(
	const std::string& cheminFichierAgrege
) {
	// Créé le dossier s'il n'existe pas
	std::filesystem::create_directory(DOSSIER_STOCKAGE);

	// Ouvre le fichier de destination
	std::ofstream fichierAgrege(cheminFichierAgrege,
		std::ios::out | std::ios::app);

	// Vérifie si le fichier est ouvert
	if (fichierAgrege.is_open()) {
		// Parcourt tous les fichiers dans le dossier "stockage"
		for (
			const auto& fichier :
			std::filesystem::directory_iterator(
				StockageDonnees::DOSSIER_STOCKAGE
			)
		) {
			// Vérifie si le fichier source est le fichier de destination
			if (fichier.path().string() == cheminFichierAgrege) {
				continue;
			}

			// Vérifie si le fichier source contient dans son nom "agrege_"
			if (
				fichier.path().string().find(
					StockageDonnees::CHEMIN_FICHIER_AGREGE
				) != std::string::npos
			) {
				continue;
			}

			// Vérifie si le fichier source est un fichier texte
			if (fichier.path().extension() == ".txt") {
				// Ouvre le fichier source
				std::ifstream fichierSource(fichier.path().string(),
					std::ios::in);

				// Vérifie si le fichier source est ouvert
				if (fichierSource.is_open()) {
					/*
					 * Lit le contenu du fichier source et l'écrit dans le
					 * fichier de destination
					 */
					fichierAgrege << fichierSource.rdbuf();

					// Ferme le fichier source
					fichierSource.close();

					// Supprime le fichier source
					std::filesystem::remove(fichier.path());
				}
				else {
					std::cerr << "Impossible d'ouvrir le fichier source : \"" <<
						fichier.path().string() << "\"" << std::endl;
				}
			}
		}

		// Ferme le fichier de destination
		fichierAgrege.close();
	}
	else {
		std::cerr << "Impossible d'ouvrir le fichier de destionation : \"" <<
			cheminFichierAgrege << "\"" << std::endl;
	}
}