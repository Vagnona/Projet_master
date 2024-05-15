#!/bin/bash

# Mets les fichiers de CMake dans un dossier spécifique
# Puis construit le projet en nettoyant d'abord

# Si l'argument est "clean", nettoie le projet

if [ $# -ne 1 ];
then
	echo "Erreur : Nombre d'argument incorrect"
	echo "Usage : sh $0 [clean|all|mesures|agregateur]"
	exit 1
elif [ "$1" != "clean" ] && [ "$1" != "all" ] && [ "$1" != "mesures" ] &&
	[ "$1" != "agregateur" ];
then
	echo "Erreur : Mauvais argument"
	echo "Usage : sh $0 [clean|all|mesures|agregateur]"
	exit 1
fi

if [ "$1" = "clean" ];
then
	rm -rf build bin stockage
	echo "Projet nettoyé"
else
	cmake -DPROG_TYPE=$1 -S . -B build
	cmake --build build --clean-first 
fi