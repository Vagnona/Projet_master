#!/bin/bash

mongosh --port 30001 <<EOF
use data;
db.compte.insertMany( [
    {
        idUser: 0,
	    idAgri: 0,
	    role: "admin",
        nom: "John",
        prenom: "Doe",
        mail: "email@bidon.eu",
        mdp: "\$2y\$10\$1U8UqTDO.24jCqj8aRaLU./hpPaZsvB431j92djtD9xwKYNPym6cy",
	mdp_temp: false
    },
    {
        idUser: 1,
	    idAgri: 0,
	    role: "standard",
        nom: "Jean",
        prenom: "Dupont",
        mail: "email2@bidon.eu",
        mdp: "\$2y\$10\$1U8UqTDO.24jCqj8aRaLU./hpPaZsvB431j92djtD9xwKYNPym6cy",
	mdp_temp: true
    },
    {
        idUser: 2,
	    idAgri: 1,
	    role: "admin",
        nom: "John",
        prenom: "Jones",
        mail: "email3@bidon.eu",
        mdp: "\$2y\$10\$1U8UqTDO.24jCqj8aRaLU./hpPaZsvB431j92djtD9xwKYNPym6cy",
	mdp_temp: false
    }
] );

db.agriculteur.insertMany( [
    {
        idAgri: 0,
        nomAgri: "agriDuRhin",
        champs: {
            coordonnees: [[48.526617, 7.73894], [51.034, 2.376], [48.525, 7.737]],
            ilots: [4, 3, 2]
        }
    },
    {
        idAgri: 1,
        nomAgri: "ChampsDeLest",
        champs: {
            coordonnees: [[48.1, 7.33]],
            ilots: [5]
        }
    }
] );

db.humi.insertMany( [
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 0,
        date: new Date(),
        humi: 29.4545
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 1,
        date: new Date(),
        humi: 23.4674
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 2,
        date: new Date(),
        humi: 29.4545
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 3,
        date: new Date(),
        humi: 23.4674
    },

    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 0,
        date: new Date(),
        humi: 47.4687
    },
    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 1,
        date: new Date(),
        humi: 43.1374
    },
    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 2,
        date: new Date(),
        humi: 55.6819
    },

    {
        idAgri: 0,
        idChamps: 2,
        idIlot: 0,
        date: new Date(),
        humi: 29.4545
    },
    {
        idAgri: 0,
        idChamps: 2,
        idIlot: 1,
        date: new Date(),
        humi: 23.4674
    },

    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 0,
        date: new Date(),
        humi: 23.4545
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 1,
        date: new Date(),
        humi: 29.4674
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 2,
        date: new Date(),
        humi: 46.4545
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 3,
        date: new Date(),
        humi: 44.4674
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 4,
        date: new Date(),
        humi: 67.4687
    }
] );


db.temp.insertMany( [
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 0,
        date: new Date(),
        temp: 21.4545
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 1,
        date: new Date(),
        temp: 23.4674
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 2,
        date: new Date(),
        temp: 22.4545
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 3,
        date: new Date(),
        temp: 23.4674
    },

    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 0,
        date: new Date(),
        temp: 21.4687
    },
    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 1,
        date: new Date(),
        temp: 23.1374
    },
    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 2,
        date: new Date(),
        temp: 22.6819
    },

    {
        idAgri: 0,
        idChamps: 2,
        idIlot: 0,
        date: new Date(),
        temp: 29.4545
    },
    {
        idAgri: 0,
        idChamps: 2,
        idIlot: 1,
        date: new Date(),
        temp: 28.4674
    },

    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 0,
        date: new Date(),
        temp: 25.4545
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 1,
        date: new Date(),
        temp: 26.4674
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 2,
        date: new Date(),
        temp: 26.4545
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 3,
        date: new Date(),
        temp: 24.4674
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 4,
        date: new Date(),
        temp: 25.4687
    }
] );

db.lumi.insertMany( [
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 0,
        date: new Date(),
        lumi: 789
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 1,
        date: new Date(),
        lumi: 780
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 2,
        date: new Date(),
        lumi: 785
    },
    {
        idAgri: 0,
        idChamps: 0,
        idIlot: 3,
        date: new Date(),
        lumi: 778
    },

    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 0,
        date: new Date(),
        lumi: 654
    },
    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 1,
        date: new Date(),
        lumi: 681
    },
    {
        idAgri: 0,
        idChamps: 1,
        idIlot: 2,
        date: new Date(),
        lumi: 678
    },

    {
        idAgri: 0,
        idChamps: 2,
        idIlot: 0,
        date: new Date(),
        lumi: 960
    },
    {
        idAgri: 0,
        idChamps: 2,
        idIlot: 1,
        date: new Date(),
        lumi: 970
    },

    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 0,
        date: new Date(),
        lumi: 856
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 1,
        date: new Date(),
        lumi: 873
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 2,
        date: new Date(),
        lumi: 847
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 3,
        date: new Date(),
        lumi: 869
    },
    {
        idAgri: 1,
        idChamps: 0,
        idIlot: 4,
        date: new Date(),
        lumi: 888
    }
] );

EOF
