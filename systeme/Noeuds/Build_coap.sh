#!/bin/bash

mkdir /home/$SUDO_USER/stockage
cp -r ../Coap /home/$SUDO_USER/


touch /home/$SUDO_USER/log_erreur.txt
touch /home/$SUDO_USER/log_client.txt

# Chemin complet vers le script à exécuter
script_path="/home/$SUDO_USER/Coap/coap_client.sh $SUDO_USER 2> /home/$SUDO_USER/log_erreur.txt"

# Ligne à ajouter dans le crontab
cron_line="* * * * * $script_path"

# Ajouter la ligne au crontab
(crontab -l ; echo "$cron_line") | crontab -