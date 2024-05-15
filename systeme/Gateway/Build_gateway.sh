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

#Configuration Gateway
## Configuration du serveur DHCP (interface bat0)
sudo chmod +0770 /etc/dnsmasq.conf

if sudo grep -q "dhcp-range=192.168.199.2,192.168.199.99,255.255.255.0,12h" /etc/dnsmasq.conf; then
    echo "La ligne existe déjà."
else
    echo "La ligne n'existe pas. Ajout en cours..."
    sudo echo "interface=bat0" >> /etc/dnsmasq.conf
    sudo echo "dhcp-range=192.168.199.2,192.168.199.99,255.255.255.0,12h" >> /etc/dnsmasq.conf
    echo "Lignes ajoutées avec succès."
fi

#(interface wlan0)
sudo echo "interface=wlan0" >> /etc/dnsmasq.conf
sudo echo "dhcp-range=10.0.1.2,10.0.1.255,255.255.255.0,12h" >> /etc/dnsmasq.conf

if grep -q "dhcp-range=192.168.199.2,192.168.199.99,255.255.255.0,12h" /etc/dnsmasq.conf; then
    echo "La ligne existe déjà."
else
    echo "La ligne n'existe pas. Ajout en cours..."
    sudo echo "interface=wlan0" >> /etc/dnsmasq.conf
    sudo echo "dhcp-range=10.0.1.2,10.0.1.255,255.255.255.0,12h" >> /etc/dnsmasq.conf
    echo "Lignes ajoutées avec succès."
fi

cp -r ../Coap /home/$SUDO_USER/
./Build_coap

echo "Le systeme va redemarrer dans 5 secondes"
sleep 5
sudo reboot
