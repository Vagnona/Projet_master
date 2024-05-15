# README

## Introduction au réseau mesh avec des RPI
Le réseau mesh pour lequel nous avons opté utilise le protocole de routage batman-adv. Ce protocole de routage permet d'avoir un Gateway et plusieurs Noeuds, la limite de noeuds étant défini par la configuration DHCP du Gateway. 
Pour interconnecter les RPI nous configuration le mode wifi à ad-hoc. Celui-ci permet de connecté des wifi entre eux, même si deux wifi ne sont pas à porté ils peuvent passé par l'intermédiaire d'une troisième RPI, celle-ci à porté des deux permières RPI.

## Préparer la RPI
### Equipement requis
* RPI3 (alimentation avec)
* Carte micro SD (de préférence >= 32go)
* Câble HDMI (micro HDMI <--> HDMI)
* Clavier
* Ecran 
* Câble Ethernet

Noté que le clavier et l'écran sont seulement utilisé en cas de dernier recours si la connection ssh ne semble pas s'établir et qu'il faut intervenir manuellement.

### Flash de carte SD
Tout d'abord il sera nécessaire d'initliaser une image pour la rasberry pi. Dans le cadre de ce projet nous avons opté pour `RASPBERRY PI OS (LEGAGY, 64-BITS) LITE`. Pour installer l'image nous recommandons d'utiliser l'utilitaire de RPI.

```bash
sudo apt install rpi-imager
```
L'installation que nous faisons se fait en ssh. Il est donc utile de configurer les paramètres nécessaire avant de flasher la carte SD.
Une fois l'installation faite nous pouvons passer à la suite.

### Mise en place réseau mesh
* Les Noeuds ont seulement besoin d'être branché au secteur pour pouvoir s'allumer. Cependant lors de l'installation vous pouvez utilisez la manière que vous préférez pour pouvoir vous y connecter. Une fois l'installation fini il ne sera plus nécessaire d'avoir un accès "classique" au réseau puisqu'on passera par le réseau mesh pour s'y connecter.
* Le gateway à besoin d'utiliser deux interfaces réseaux. Il faudra qu'il soit branché au secteur au réseau public par câble ethernet et le wifi sera utilisé pour se connecter au réseau mesh.

Vous pouvez insérer les cartes SD et démarrer les RPI.





## Installation et mise en place réseau mesh
### Installation à l'aide des scripts
* Gateway: une fois la la RPI connecté. Déplacer y les fichiers "systeme" et "capteur" (à l'aide de SFTP, clé USB,...). Une fois récupérer placé vous dans le répertoire `~/systeme/Gateway/` puis exécuter la commande `sudo ./Build_gateway.sh`. N'oubliez pas le `sudo` sans quoi l'installation échouera. **Attention** une fois la manipulation faite vous ne pourrez plus vous y connecter en wifi.

* Noeuds: une fois la la RPI connecté. Déplacer y les fichiers "systeme" et "capteur" (à l'aide de SFTP, clé USB,...). Une fois récupérer placé vous dans le répertoire `~/systeme/Noeuds/` puis exécuter la commande `sudo ./Build_node.sh`. N'oubliez pas le `sudo` sans quoi l'installation échouera. **Attention** une fois la manipulation faite vous ne pourrez plus vous y connecter en wifi.

### Installation manuel
Voir `Gateway/README.md` et `Noeuds/README.md` pour installer manuellement le gateway et les noeuds.

#### Installation des paquets nécessaire
Vous pouvez executer `Installation.sh` pour installer les paquets ou bien installer manuellement toutes les commandes si trouvant.


## Commande utile
```bash
# Vérifie l'état de l'interface bat0
# devrait retourné le nom de l'interface et active
sudo batctl if
# Vérifier les noeuds voisins au gateway
sudo batctl n

# Affiche les modes accepter pour le Wifi (notamment ad-hoc)
iw list | grep -A 10 "Supported interface modes"

# Vérifier les interfaces
ifconfig
# Vérfifier l'interface wifi
iwconfig
```

## Aide
### Documentation
* Gateway: ./Gateway/README.md
* Noeuds: ./Noeuds/README.md
### Interfaces et réseau
* interface wifi: `/etc/network/interfaces.d/wlan0`
## Connexion à l'infra
`sshpass -p '$PWD' sftp $USER@$IP`

## Source
* Création d'un réseau mesh: [Tutoriel](https://github.com/binnes/WiFiMeshRaspberryPi/blob/master/part1/PIMESH.md#setup-batman-adv)
* Norme des cannaux en Europe: [Wiki](https://en.wikipedia.org/wiki/List_of_WLAN_channels)