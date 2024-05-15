## Démarrer le replica set:
```
./setup.sh      # créé les dossiers des dbs (data/*)
./start.sh      # lance conteneurs et initie replica set avec conf de rs-init.sh
```

## Stoper les containers
```
./stop.sh
```

## Infos utiles:
* se connecter à l'instance mongo primaire par défaut:  
    ```
    docker exec -it mongo1 mongosh --port 30001
    ```
* url de connection au replica set:
    ```
    mongodb://mongo1:30001,mongo2:30002,mongo3:30003/?replicaSet=rs0
    # ou pour se connecter directement à la bonne db (data):
    mongodb://mongo1:30001,mongo2:30002,mongo3:30003/data/?replicaSet=rs0
    ```
* script de remplissage de la bdd:
    lancé automatiquement dans start.sh (délai de 20 secs) pour les tests (à désactiver pour version finale)
    ```
    ./add-data.sh   # ajoute des données dans la base "data"
    ```

## Structure de la BDD

```
{
    "compte": {
        "idUser": "id utilisateur",
        "idAgri": "IDa",
        "role": "admin ou standard",
        "nom": "nom",
        "prenom": "prénom",
        "mail": "email@bidon.eu",
        "mdp": "mdp",
        "mdp_temp": true|false
    },

    "agriculteur": {
        "idAgri": "IDa",
        "nomAgri": "NOMa",
        "champs": {
            "coordonnees" : ["(lat, long) champs 0", "(lat, long) champs 1", "..."],
            "ilots": ["nb ilots champs 0", "nb ilots champs 1", "..."]
        }

    },

    "humi": {
        "idAgri": "IDa",
        "idChamps": "IDc",
        "idIlot": "Idi",
        "date": "date mesure ilot Idi",
        "humi": "humidité ilot Idi"
    },

    "temp": {
        "idAgri": "IDa",
        "idChamps": "IDc",
        "idIlot": "Idi",
        "date": "date mesure ilot Idi",
        "temp": "température ilot Idi"
    },

    "lumi": {
        "idAgri": "IDa",
        "idChamps": "IDc",
        "idIlot": "Idi",
        "date": "date mesure ilot Idi",
        "lumi": "luminosité ilot Idi"
    }
}
```
