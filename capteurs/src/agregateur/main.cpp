#include "agregateurBdd.h"

int genereNombre(void) {
	std::random_device rdm;
	std::mt19937 gen(rdm());
	std::uniform_int_distribution<int> distr(10000, 99999);

	return distr(gen);
}

std::string genereHorodatage(void) {
	std::time_t secondes = std::time(nullptr);
	return std::to_string(secondes);
}

int main(int argc, char** argv) {
	// Vérifie le nombre d'arguments
	if (argc != 1) {
		std::cerr << "Usage: " << argv[0] << std::endl;
		return EXIT_FAILURE;
	}

	// Génère le nom du fichier où agréger
	std::string cheminAgrege = StockageDonnees::CHEMIN_FICHIER_AGREGE +
		std::to_string(genereNombre()) + '_' + genereHorodatage() + ".txt";

	// Agrège les fichiers de données
	StockageDonnees::agregeFichiersDonnees(cheminAgrege);

	// Envoie les données agrégées vers le serveur SFTP
	EnvoiDonnees::envoiFichierSFTP(cheminAgrege);

	return EXIT_SUCCESS;
}