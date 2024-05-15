#!/bin/bash
# batman-adv interface to use
sudo batctl if add wlan0
sudo ifconfig bat0 mtu 1468

# Tell batman-adv this is an internet gateway
sudo batctl gw_mode server

# Mise en place de wlan0
sudo ifconfig wlan0 down
sudo rfkill unblock wifi; sudo rfkill unblock all

sudo iwconfig wlan0 mode ad-hoc
sudo iwconfig wlan0 essid call-code-mesh
sudo iwconfig wlan0 channel 1

sudo ifconfig wlan0 10.0.1.1/24

# Activates batman-adv interfaces
sudo ifconfig wlan0 up
sudo ifconfig bat0 up
sudo ifconfig bat0 192.168.199.1/24

bash ~/projet-master-23-24/systeme/Coap/coap_serveur.sh > /dev/null 2>&1

# ============ Firewall ====================
# sudo iptables -P INPUT DROP
sudo iptables -P FORWARD DROP
# sudo iptables -P OUTPUT DROP

# FORWARD
sudo sysctl -w net.ipv4.ip_forward=1
sudo iptables -t nat -A POSTROUTING -o eth0 -j MASQUERADE
sudo iptables -A FORWARD -i eth0 -o bat0 -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT
sudo iptables -A FORWARD -i bat0 -o eth0 -j ACCEPT
# Bloquer la communication sortante du réseau mesh
# A TESTER AVANT D'ENLVER LES COMMENTAIRES
# CA FONCTIONNE MAIS POUR LE MOMENT ON NE SAIT PAS SI CA NE BLOQUE
# PAS L'EMITION VERS L'INFRA
#
sudo iptables -A FORWARD -i bat0 -o eth0 -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT
# OU
# sudo iptables -A FORWARD -i bat0 -o eth0 -j DROP

# INPUT
## Localhost
# sudo iptables -A INPUT -p udp -i lo -j ACCEPT
## SSH
# sudo iptables -A INPUT -p tcp --dport 22 -j ACCEPT
### DNS
# sudo iptables -A INPUT -p udp --dport 53 -j ACCEPT
## DHCP
# sudo iptables -A INPUT -p udp --dport 67:68 -j ACCEPT
## NTP
# sudo iptables -A INPUT -p udp --dport 123 -j ACCEPT
## ICMP
# sudo iptables -A INPUT -p icmp --icmp-type echo-request -j ACCEPT
## Trafic deja etabli
# sudo iptables -A INPUT -m conntrack --ctstate RELATED,ESTABLISHED -j ACCEPT

# OUTPUT
# sudo iptables -A OUTPUT -p tcp --dport 22 -j ACCEPT
# sudo iptables -A OUTPUT -p tcp --dport 80 -j ACCEPT
# sudo iptables -A OUTPUT -p tcp --dport 443 -j ACCEPT

sudo iptables -A INPUT -i bat0 -j ACCEPT
sudo iptables -A OUTPUT -i bat0 -j ACCEPT

# =======================================

/home/pi/Coap/coap_serveur.sh pi > /dev/null 2>&1 &
