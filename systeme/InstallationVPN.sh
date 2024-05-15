# Installation des programmes requis
yes | sudo apt update
yes | sudo apt-get install wireguard wireguard-tools

# Configuration VPN
# Copie fichier & ajout mode exec
sudo cp ./VPN/wg0.conf /etc/wireguard
sudo chmod +x ./VPN/scriptAddClient.sh
# Génération de clés
sudo -i
cd /etc/wireguard
unmask 077
wg genkey | tee server.key | wg pubkey > server.pub

