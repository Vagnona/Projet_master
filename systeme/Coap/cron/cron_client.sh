#!/bin/bash

# Chemin complet vers le script à exécuter
script_path="/home/$SUDO_USER/systeme/Coap/coap_client.sh $SUDO_USER 2> /home/$SUDO_USER/log_erreur.txt"

# Ligne à ajouter dans le crontab
cron_line="* * * * * $script_path"

# Ajouter la ligne au crontab
(crontab -l ; echo "$cron_line") | crontab -