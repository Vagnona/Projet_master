#!/usr/bin/env python3
import sys
import random

# fonctionnement script : 
# Le script crée un fichier bash faisant l'insertion 
# 1. insertion comptes
# 2. insertion agriculteurs + champs
# 3. insertion valeurs capteurs
# 4. insertion valeurs moyennes 

# fonction renvoyant la commande mongosh permettant l'ajout de nbagris comptes
def generate_comptes(nbagris):
    insertcmd = f"""
db.compte.insertMany([
        """
    # ajout d'un ligne par compte
    for i in range(nbagris):
        insertcmd += f"""
        {{
            idUser: {i},        
            idAgri: {i},
            role: "standard",
            nom: "auto{i}",
            preom: "auto{i}",
            mail: "auto{i}@bidon.eu",
            mdp: "testtest",
            mdp_temp: false
        }},
        """
    res = insertcmd[-1] + "]);\n\n"
    return res

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
]);

# fonction renvoyant la commande mongosh pour l'ajout 
def generate_agris(nbagris, nbmoyilots):
    nbchampposs = [1, 2, 3, 4, 5]
    insertcmd = f"""
db.agriculteur.insertMany([
        """
    for i in range(nbagris):
        coords = [round(random.uniform(20, 80), 2),
                round(random.uniform(20, 80), 2)]
        # Choix random du nombre de champs
        nbc = random.choice(nbchampposs)
        champs = f"""
            champs : {{
        """
        for j in range(nbc):


        insertcmd += f"""
        {{
            idAgri: {i},
            nomAgri: "nomauto{i}",
            champs: {{
                coordonnees: 
            }}
        }}
        """
    return insertcmd
    
def generate_capteurs(nbagris, nbentcapt, tabilot):
    insertcmd = f"""
        """

if (len(sys.argv) != 4) {
    print("Usage: ./fill-db.py nbagris nbmoyilots nbentréescapteurs\n");
    exit(1);
}
nbagri = int(sys.argv[1])
nbmoyi = int(sys.argv[2])
nbent = int(sys.argv[3])
listilots = []

# Création du fichier
filesc = open("tmpfill-db.sh", "w")
filesc.write("#!/bin/bash\n")
filesc.write("mongosh --port 30001 << EOF\n")
filesc.write("use data;\n\n")

# Ajout des lignes nécessaires pour l'insertion
filesc.write(generate_comptes(nbagri))
filesc.write(generate_agris(nbagri, nbmoyi))
filesc.write(generate_capteurs(nbagri, nbent, listilots))