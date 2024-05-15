#!/bin/bash 

# Vérifier si un argument est fourni
if [ $# -eq 0 ]; then
    echo "Usage: $0 <argument>"
    exit 1
fi

# Récupérer l'argument
arg_USER=$1

#Parametre de la communication coap
INTERFACE=lo
PORT=5683
IP=192.168.199.1

MYFOLDER=/home/$arg_USER/stockage/mesure_
COAP_FOLDER=/home/$arg_USER/Coap


#Lancement du serveur coap en arriere plan
sudo python3 $COAP_FOLDER/coap_serveur.py -i $IP -p $PORT -f $MYFOLDER
