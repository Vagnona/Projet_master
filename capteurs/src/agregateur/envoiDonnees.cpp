#include "envoiDonnees.hpp"

/* Public */

void EnvoiDonnees::afficheMsgErrLibssh2(
	LIBSSH2_SESSION* session,
	const std::string& msgErreur
) {
	char* tamponMsgErreur;
	int longeurErreur;
	libssh2_session_last_error(session, &tamponMsgErreur, &longeurErreur, 0);
	std::cerr << msgErreur << "\nErreur : " << tamponMsgErreur << std::endl;
}

int EnvoiDonnees::initialisationSocket(const int& port, const char* ip) {
	int sockfd = socket(AF_INET, SOCK_STREAM, 0);

	struct sockaddr_in adresse;
	adresse.sin_family = AF_INET;
	adresse.sin_port = htons(port);
	adresse.sin_addr.s_addr = inet_addr(ip);

	if (connect(sockfd, (struct sockaddr*)&adresse, sizeof(adresse)) < 0) {
		std::cerr << "Echec lors de la connexion de la socket" << std::endl;
		return -1;
	}

	return sockfd;
}

int EnvoiDonnees::envoiFichierSFTP(std::string cheminFichier) {
	// Récupère les identifiants
	std::vector<std::string> params = StockageDonnees::recupereParams(
		EnvoiDonnees::CHEMIN_FICHIER_IDENTIFIANTS);

	/*
	 * Vérifie que le fichier n'est pas mal formé
	 * (4 lignes : IP, port, identifiant et mot de passe)
	 */
	if (params.size() != 4) {
		std::cerr << "Le fichier d'identifiants est mal formé" << std::endl;
		return -1;
	}
	std::string ip = params[0];
	const int port = std::stoi(params[1]);
	std::string identifiant = params[2];
	std::string mdp = params[3];

	// Récupère le nom du fichier
	std::string nomFichier = cheminFichier.substr(
		cheminFichier.find_last_of('/') + 1);
	std::string cheminDistantServ = EnvoiDonnees::DOSSIER_DISTANT + nomFichier;

	// Initialise la session
	int err = libssh2_init(0);
	if (err < 0) {
		std::cerr << "Echec lors de l'initialisation de libssh2" << std::endl;
		return err;
	}

	LIBSSH2_SESSION* session = libssh2_session_init();
	if (!session) {
		afficheMsgErrLibssh2(session,
			"Echec lors de la création de la session");
		return -1;
	}

	// Initialise la socket
	int sockfd = initialisationSocket(port, ip.c_str());
	if (sockfd < 0)
		return sockfd;

	err = libssh2_session_startup(session, sockfd);
	if (err) {
		afficheMsgErrLibssh2(session,
			"Echec lors du démarage de la session");
		return err;
	}

	err = libssh2_userauth_password(session, identifiant.c_str(), mdp.c_str());
	if (err) {
		afficheMsgErrLibssh2(session, "Echec lors de l'authenification");
		libssh2_session_disconnect(session, "Extinction normale");
		libssh2_session_free(session);
		libssh2_exit();
		return err;
	}

	LIBSSH2_SFTP* sftp = libssh2_sftp_init(session);
	if (!sftp) {
		afficheMsgErrLibssh2(session,
			"Echec lors de l'initialisation de la session SFTP");
		return -1;
	}

	LIBSSH2_SFTP_HANDLE* agent = libssh2_sftp_open(
		sftp,
		cheminDistantServ.c_str(),
		LIBSSH2_FXF_WRITE | LIBSSH2_FXF_CREAT,
		LIBSSH2_SFTP_S_IRUSR | LIBSSH2_SFTP_S_IWUSR | LIBSSH2_SFTP_S_IRGRP |
			LIBSSH2_SFTP_S_IROTH
	);

	if (!agent) {
		afficheMsgErrLibssh2(session,
			"Echec lors de l'ouverture du fichier distant");
		return -1;
	}

	// Rempli le tampon avec le contenu du fichier
	std::ifstream fichier(cheminFichier);
	std::string tampon((std::istreambuf_iterator<char>(fichier)), 
		std::istreambuf_iterator<char>());

	// Envoie le tampon vers le serveur SFTP
	err = libssh2_sftp_write(agent, tampon.c_str(), tampon.size());
	if (err < 0) {
		afficheMsgErrLibssh2(session,
			"Echec lors de l'écriture dans le fichier distant");
		return err;
	}

	// Ferme les connexions
	libssh2_sftp_close(agent);
	libssh2_sftp_shutdown(sftp);
	libssh2_session_disconnect(session, "Extinction normale");
	libssh2_session_free(session);
	libssh2_exit();
	close(sockfd);

	// Supprime le fichier de données, si l'envoi s'est bien passé
	std::remove(cheminFichier.c_str());

	return 0;
}