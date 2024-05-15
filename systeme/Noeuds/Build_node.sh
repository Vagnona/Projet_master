#!/bin/bash
# Donne les droits d'execution d'Installation.sh
chmod +x ../Installation.sh

yes | ../Installation.sh

sudo systemctl stop NetworkManager
sudo systemctl disable NetworkManager


#Configuration noeud
cp start-batman-adv.sh /home/$SUDO_USER/start-batman-adv.sh
chmod +x /home/$SUDO_USER/start-batman-adv.sh
echo 'batman-adv' | sudo tee --append /etc/modules
echo 'denyinterfaces wlan0' | sudo tee --append /etc/dhcpcd.conf

fichier="/etc/rc.local"

# Vérifier si le fichier existe
if [ ! -f "$fichier" ]; then
    echo "Le fichier $fichier n'existe pas."
    exit 1
fi

python3 ../rclocalwrite.py

./Build_coap.sh

echo "Le systeme va redemarrer dans 5 secondes"
sleep 5
sudo reboot
