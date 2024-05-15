# Security

## Préambule
Ce document Markedown contient:
- un résumé des différentes sécurité mise en place pour différentes failles
- les différentes possible faille de sécurité
- les maintenances à effectué pour conserver un bon niveau de sécurité

## Point sécurisé
### Transmission des messages
Pour communiquer les données collectés au gateway on utilise le protocole sftp. Ce protocole offre une encryption de ces messages spécifiques.

### Visibilité du réseaux
#### De l'extérieur
Actuellement ce qui s'épare le réseau mesh du restant de l'internet c'est le gateway. Depuis l'internet nous n'avons pas de visibilité sur l'infrastructure du réseau mesh. Pour pouvoir le voir il faut se connecter en ssh au gateway et executer les commandes depuis celui-ci.

[TODO] L'intérieur du réseau mesh ne devrait pas non plus pouvoir voir internet. Ainsi si une faille est découverte dans le réseau mesh l'attaquant à l'intérieur du mesh ne pourra pas dépasser le gateway.

## Maintenance
### VPN
Pour maintenir une certaine sécurité il est important de renouvelé les paramètre **Diffie-Hellman** à l'aide de la commande `easyrsa gen-dh`. La mise à jour régulière des paramètres réduit le faille.

Le certificat générer est valable 825 jours. Pour des raisons de sécurité et par précaution. Il sera demander de renouveler les certificats chaque année.

## Firewall
L'outil **iptables-persistent** peut être utilisé pour simplifier la sauvegarde des règles du firewall.
```bash
sudo apt-get install iptables-persistent
```

Pour voir l'état actuel du firewall on peut utiliser la commande:
```bash
sudo iptables -L
```

La modification des règles s'effectue comme suit. Ici ce sont les modifications effectué sur le Gateway du réseau mesh.
```bash
sudo iptables -P FORWARD ACCEPT
sudo iptables -A FORWARD -i wlan0 -o eth0 -j DROP
sudo iptables -A FORWARD -i bat0 -o eth0 -j DROP
```

Pour supprimer une règle vous pouvez faire les commandes suivantes
```bash
sudo iptables-save # Récapitule les modifications actuels
sudo iptables -D FORWARD 1 # supprimera la première règle de forward, 1 étant le premier
```

Sauvegarder la configuration et l'appliqué (pour des backups il faut d'autres nom que *rules.v4* et *rules.v6*)
```bash
sudo iptables-save # verif conf
sudo sh -c 'iptables-save > /etc/iptables/rules.v4'
sudo systemctl restart iptables
```
