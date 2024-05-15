#!/bin/bash

# Boucle pour exécuter l'executable "mesures" 5 fois
for i in {1..5}; do
    bin/mesures
done

# Lancer l'agrégateur
bin/agregateur

# Envoyer le fichier au serveur SFTP
IP_SERVEUR="10.0.1.1"
UTILISATEUR="test"
MOT_DE_PASSE="tprli"
FICHIER_LOCAL="bin/stockage/agrege.txt"

# Utilisation de sftp non interactif pour automatiser le transfert
sshpass -p "${MOT_DE_PASSE}" sftp://${UTILISATEUR}@${IP_SERVEUR} <<EOF
cd /destination/du/serveur
put ${FICHIER_LOCAL}
bye
EOF