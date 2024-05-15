#!/bin/bash
#Intégralité des paquets à installer

sudo apt-get update
sudo apt-get upgrade

# Pour faire fonctionner le script test :
sudo apt install cmake
sudo apt install libssh2-1-dev
sudo apt-get install libsqlite3-dev

# Pour le réseau mesh :
sudo apt-get install -y batctl

# Seulement pour le Gateway :
sudo apt-get install -y dnsmasq 
sudo apt install iptables

# Pour utiliser sshpass
sudo apt-get install sshpass

# Pour lescript (Python) sftp simulant une connection mesh serveur
sudo apt install python3
sudo apt install python3-pip
sudo pip install pysftp
sudo apt-get install cron

# Pour le fonctionnement de Coapthon
#mkdir /home/$SUDO_USER/stockage/
#sudo cp -r Coap /home/$SUDO_USER/Coap
