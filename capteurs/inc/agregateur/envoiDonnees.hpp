#ifndef ENVOI_DONNEES_HPP
#define ENVOI_DONNEES_HPP

#include "infosChamp.hpp"
#include "stockageDonnees.hpp"

#include <arpa/inet.h>
#include <fstream>
#include <iostream>
#include <libssh2.h>
#include <libssh2_sftp.h>
#include <netinet/in.h>
#include <sys/types.h>
#include <sys/socket.h>
#include <unistd.h>

class EnvoiDonnees {
	/* Variable */
	private:
		const inline static std::string DOSSIER_DISTANT {
			"/upload/"
		};
		const inline static std::string CHEMIN_FICHIER_IDENTIFIANTS {
			"./configuration/identifiantsSFTP.txt"
		};


	/* Constructeur et destructeur */
	public:
		EnvoiDonnees(void) = default;
		~EnvoiDonnees(void) = default;


	/* Méthodes */
	public:
		/**
		 * @brief Affiche un message d'erreur renvoyé par libssh2
		 *
		 * @param session du serveur SFTP
		 * @param msgErreur à afficher
		 */
		static void afficheMsgErrLibssh2(
			LIBSSH2_SESSION* session, const std::string& msgErreur
			);

		/**
		 * @brief Initialise la socket
		 *
		 * @param port du serveur SFTP
		 * @param ip du serveur SFTP
		 * @return int -1 si erreur, 0 sinon
		 */
		static int initialisationSocket(const int& port, const char* ip);

		/**
		 * @brief Envoie les données de la base de données vers le serveur SFTP
		 *
		 * @param cheminFichier du fichier contenant les données
		 * @return int -1 si erreur, 0 sinon
		 */
		static int envoiFichierSFTP(std::string cheminFichier);
};

#endif