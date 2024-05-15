#ifndef RECUPMESURES_H
#define RECUPMESURES_H

#include "envoiDonnees.hpp"
#include "erreur.hpp"
#include "infosChamp.hpp"
#include "mesures.hpp"
#include "stockageDonnees.hpp"

#include <iostream>

/* Constantes */

#define DEBUG 1	// À 1, affiche les valeurs générées
#define FICHIER_PARAMS "./configuration/argumentsMesures.txt"

/* Fonction */

/**
 * @brief Vérifie le format des arguments
 * 
 * @param params les paramètres à vérifier
 */
void verifArgs(std::vector<std::string> params);

#endif