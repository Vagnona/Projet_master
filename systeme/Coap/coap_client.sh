#!/bin/bash 

# Vérifier si un argument est fourni
if [ $# -eq 0 ]; then
    echo "Usage: $0 <argument>"
    exit 1
fi

# Récupérer l'argument
arg_USER=$1

# Afficher l'argument
echo "L'argument fourni est : $arg_USER"

INTERFACE=lo
PORT=5683
IP=192.168.199.1

COAP_FOLDER_to_watch=/home/$arg_USER/stockage
COAP_FOLDER=/home/$arg_USER/Coap
COUNT=0

if [ "$(ls -A $COAP_FOLDER_to_watch)" ]; then
    # Itérer sur chaque fichier dans le dossier
    for file in "$COAP_FOLDER_to_watch"/*; do
        if [ -f "$file" ]; then
        echo "$file"
        # Le dossier n'est pas vide, exécutez la commande
        python3 $COAP_FOLDER/coapclient.py -o POST -p "coap://$IP:$PORT/basic" -f "$file" >> /home/$arg_USER/log_client.txt
        #sudo rm $file 
        fi 
    done 
    # Ajoutez une pause (sleep) si nécessaire avant la prochaine itération
fi
