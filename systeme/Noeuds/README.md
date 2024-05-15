# README NOEUDS

## Installation avec Script
Vous pouvez lancer le script `sudo ./Build_gateway.sh` pour l'installation. Celui installera également les paquets nécessaire à l'aide du script `../Installation.sh`.

## Installation manuel
```bash
# Création du fichier de configuration qui sera exécuté à chaque démarrage
# Text comportant (voir system/Noeuds/start-batman-adv.sh)
nano ~/start-batman-adv.sh
# Ajout des droits d'excution 
chmod +x ~/start-batman-adv.sh

# Ajout du protocole batman
echo 'batman-adv' | sudo tee --append /etc/modules
# Ajout de la configuration dhcp
echo 'denyinterfaces wlan0' | sudo tee --append /etc/dhcpd.conf
# Ajout du fichier de configuration start-batman-adv.sh
# La ligne est à ajouter avant le exit 0
# /home/<VotreNomUtilisateur>/start-batman-adv.sh &
sudo nano /etc/rc.local
```

## Bibliographie
[Tuto installation Noeuds](https://github.com/binnes/WiFiMeshRaspberryPi/blob/master/part1/PIMESH.md#setup-batman-adv)