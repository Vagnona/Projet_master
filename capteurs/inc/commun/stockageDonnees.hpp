#ifndef STOCKAGE_DONNEES_HPP
#define STOCKAGE_DONNEES_HPP

#include "mesures.hpp"
#include "infosChamp.hpp"

#include <chrono>
#include <ctime>
#include <filesystem>
#include <fstream>
#include <iostream>

class StockageDonnees {
	/* Variable */
	public:
		inline static std::string DOSSIER_STOCKAGE {
			getenv("HOME") + std::string("/stockage/")
		};
		inline static std::string CHEMIN_FICHIER_MESURES {
			DOSSIER_STOCKAGE + "mesures_"
		};
		inline static std::string CHEMIN_FICHIER_AGREGE {
			DOSSIER_STOCKAGE + "agrege_"
		};


	/* Constructeur et destructeur */
	public:
		StockageDonnees(void) = default;
		~StockageDonnees(void) = default;


	/* Méthodes */
	public:
		/**
		 * @brief Récupère les paramètres dans un fichier
		 *
		 * @param cheminFichier du fichier contenant les informations
		 * @return std::vector<std::string> tableau contenant les informations
		 */
		static std::vector<std::string> recupereParams(
			const std::string cheminFichier
		);

		/**
		 * @brief Ecrit les données des différentes mesures dans un fichier
		 * 
		 * @param cheminFichierMesures où écrire les données
		 * @param infosChamp informations du champ
		 * @param mesures mesures à écrire
		 * @return int EXIT_SUCCESS ou EXIT_FAILURE
		 */
		static int ecrireDonneesFichier(
			const std::string& cheminFichierMesures,
			InfosChamp infosChamp,
			Mesures mesures
		);

		/**
		 * @brief Génère la date actuelle au format UTC
		 * 
		 * @return std::string date au format "AAAA-MM-JJ HH:MM:SS"
		 */
		static std::string dateUTCActuelle(void);

		/**
		 * @brief Agrège les fichiers de données en un seul
		 * 
		 * @param cheminFichierAgrege où écrire les données agrégées
		 */
		static void agregeFichiersDonnees(
			const std::string& cheminFichierAgrege
		);
};

#endif