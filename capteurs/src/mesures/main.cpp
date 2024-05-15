#include "recupMesures.h"

void verifArgs(std::vector<std::string> params) {
	if (stoi(params[3]) != 0 && stoi(params[3]) != 1) {
		std::cerr << "Simuler doit être égal à 0 (désactiver) ou 1 (activer)" <<
			std::endl;
		exit(EXIT_FAILURE);
	}

	// Affiche les arguments
	if (DEBUG) {
		std::cout << "Id agri : " << params[0] << std::endl;
		std::cout << "Id champ : " << params[1] << std::endl;
		std::cout << "Id ilot : " << params[2] << std::endl;
		std::cout << "Simuler : " << params[3] << std::endl << std::endl;
	}

	// Vérifie que les arguments sont des entiers positifs
	if (
		(stof(params[0]) != stoi(params[0]) || stoi(params[0]) < 0) ||
		(stof(params[1]) != stoi(params[1]) || stoi(params[1]) < 0) ||
		(stof(params[2]) != stoi(params[2]) || stoi(params[2]) < 0)
	) {
		std::cerr << "Les arguments doivent être des entiers positifs"
			<< std::endl;
		exit(EXIT_FAILURE);
	}
}

int main(int argc, char** argv) {
	// Vérifie le nombre d'arguments
	std::vector<std::string> params;

	// Récupère les arguments dans un fichier
	if (argc == 1) {
		params = StockageDonnees::recupereParams(FICHIER_PARAMS);
	}
	// Récupère les arguments dans la ligne de commande
	else if (argc == 5) {
		for (int i = 1; i < argc; i++)
			params.push_back(argv[i]);
	}
	// Nombre d'arguments incorrect
	else {
		std::cerr << "Usage: " <<
			argv[0] <<
			" <id agri> <id champ> <id ilot> <simuler [0|1]>" <<
			std::endl;

		return EXIT_FAILURE;
	}

	// Vérifie les arguments
	verifArgs(params);

	// Stocke les informations du champ
	InfosChamp infosChamp;
	infosChamp.setInfosChamp(stoi(params[0]), stoi(params[1]), stoi(params[2]));

	// Génère ou récupère des mesures
	Mesures mesures;
	float temp = NAN, humi = NAN;
	double lumi = NAN;

		// Génère des valeurs factices
	if (stoi(params[3]) == 1) {
		temp = Mesures::genValeur(-20.0, 40.0, 0);
		humi = Mesures::genValeur(0.0, 150.0, 0);
		lumi = Mesures::genValeur(0, 120000, 1);
	}
		// Récupère les valeurs des capteurs
	else {
		// >> Récupère ici les valeurs des capteurs
	}

	// Stocke les valeurs générées
	mesures.setDate(StockageDonnees::dateUTCActuelle());
	mesures.setTemperature(temp);
	mesures.setHumidite(humi);
	mesures.setLuminosite(lumi);

	// Affiche les valeurs générées
	if (DEBUG) {
		std::cout << "Temperature : " << mesures.getTemperature() << std::endl;
		std::cout << "Humidite : " << mesures.getHumidite() << std::endl;
		std::cout << "Luminosite : " << mesures.getLuminosite() << std::endl
			<< std::endl;
	}

	// Génère le nom du fichier où écrire les données
	std::string cheminMesures = StockageDonnees::CHEMIN_FICHIER_MESURES +
		std::to_string(infosChamp.getIdAgri()) +
		std::to_string(infosChamp.getIdChamp()) +
		std::to_string(infosChamp.getIdIlot()) + ".txt";

	// Ecrit les données dans un fichier
	StockageDonnees::ecrireDonneesFichier(cheminMesures, infosChamp, mesures);

	return EXIT_SUCCESS;
}