#!/bin/bash

# Variable pour le nombre de tour de boucle
c=0

while true; do
	# On incrémente le nombre de tour de boucle
	c=$((c+1))
	result=$(find upload/ -type f -mmin -2)
	if [ -n "$result" ]; then
		mv $result data/donnees.txt
		python3 insert.py data/donnees.txt
	fi
	sleep 5
	# On écrit le nombre de tour de boucle dans un fichier pour pouvoir le récupérer dans le script de lancement
	echo $c > loop.count
done