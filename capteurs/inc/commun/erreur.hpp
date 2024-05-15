#ifndef ERREUR_HPP
#define ERREUR_HPP

/* Fonction */

/**
 * @brief Affiche un message d'erreur si le retour est différent de EXIT_SUCCESS
 *
 * @param retour code de retour
 * @param message d'erreur à afficher
 */
void testErreur(int retour, std::string message) {
	if (retour != EXIT_SUCCESS) std::cerr << message << std::endl;
}

#endif