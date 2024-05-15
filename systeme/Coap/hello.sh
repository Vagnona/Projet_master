#!/bin/bash 

# Vérifier si un argument est fourni
if [ $# -eq 0 ]; then
    echo "Usage: $0 <argument>"
    exit 1
fi

# Récupérer l'argument
arg=$1

# Afficher l'argument
echo "L'argument fourni est : $arg"

echo "oui studio $USER $SUDO_USER $arg " >> /home/vagno/Coap/hello.txt 