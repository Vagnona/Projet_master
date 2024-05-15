# Capteurs
## Programme
Pour simplifier la compilation, il suffit de lancer le script `./build.sh`.  
Il est nécessaire d'indiquer un paramètre, afin de spécifier quel programme
compiler :

**Tous les programmes**
`./build.sh all`

**Programme de mesures :**  
`./build.sh mesures`

**Programme d'agrégation :**  
`./build.sh agregateur`

**Nettoyage du projet :**  
`./build.sh clean`

---
### Usage
#### Programme de mesures
Une fois compilé, un fichier `mesures` est créé dans le dossier `bin` et
peut être lancé avec les arguments suivants : `<id agri>` `<id champ>`
`<id ilot>` `<simuler [0|1]>`.
Il peut également être lancé sans arguments, grâce au fichier
`argumentsMesures.txt`, se trouvant le dossier `capteurs/configuration'.
Un fichier est déjà donné, où il suffit de modifier les champs ne commencants
pas par '#'.

Les identifiants sont des entiers positifs, commencants à 0, et le paramètre
`simuler` est un booléen (0 ou 1), permettant d'activer le mode générant de
fausses valeurs, afin de se passer des sondes pour le débug.  
`idIlot` correspond à l'ilot où se trouve le capteur, par rapport à la carte
forunie dans la commande de l'agriculteur.

Une constante, nommée `DEBUG`, se trouvant dans le fichier 'inc/main.h', permet
d'afficher des informations supplémentaires dans la sortie standard.

Les données sont enregistrées dans le dossier `~/stockage`, dans un fichier
nommé `mesures_idAgriIdChampIdIlot.txt`, sous
la forme :  
```
YYYY-MM-DD HH:MM:SS (UTC);idAgri [int];idChamp [int];idIlot [int]; temp [float];humi [float];lumi [double]
```

Exemple :
`2023-12-11 15:05:43;4;2;1;22.5883;23.1385;105807`

#### Programme d'agrégation
Une fois compilé, un fichier `agregateur` est créé dans le dossier `bin` et
peut être lancé.

> **Remarque**  
Il est nécessaire d'installer le module `libssh2` pour pouvoir compiler le
programme d'agrégation (notamment la fonction d'envoi en SFTP).

Il agrégera les mesures des fichiers de stockage présents dans le dossier
`~/stockage`, dans un nouveau fichier nommés
`agrege_nombreAleatoire_horodatage.txt` (afin de le rendre unique).

Le programme se charge d'envoyer le fichier sur le serveur SFTP.  
Pour cela, un fichier stockant les identifiants SFTP est nécessaire.
Il doit se trouver dans le dossier `capteurs/configuration` et se nommer
`identifiantsSFTP.txt`.  
Un fichier est déjà donné, où il suffit de modifier les champs ne commencants
pas par '#'.