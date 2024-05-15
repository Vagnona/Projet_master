#ifndef AGREGATEURBDD_H
#define AGREGATEURBDD_H

#include "envoiDonnees.hpp"
#include "erreur.hpp"

#include <cstdlib>
#include <ctime>
#include <iostream>

/* Fonction */

/**
 * @brief Génère un nombre aléatoire entre 10000 et 99999
 * 
 * @return int nombre aléatoire
 */
int genereNombre(void);

/**
 * @brief Génère un horodatage en secondes depuis le 1er janvier 1970
 * 
 * @return std::string l'horodatage en secondes
 */
std::string genereHorodatage(void);

#endif