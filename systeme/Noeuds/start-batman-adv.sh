#!/bin/bash
# interface à utiliser pour batman-adv
sudo batctl if add wlan0
sudo ifconfig bat0 mtu 1468

# Le noeud est definit comme un client de la passerelle
sudo batctl gw_mode client

# Mise en place de wlan0
sudo ifconfig wlan0 down
sudo rfkill unblock wifi; sudo rfkill unblock all

sudo iwconfig wlan0 mode ad-hoc
sudo iwconfig wlan0 essid call-code-mesh
sudo iwconfig wlan0 channel 1

# Activates batman-adv interfaces
sudo ifconfig wlan0 up
sudo ifconfig bat0 up

sudo dhclient wlan0 
sudo dhclient bat0
