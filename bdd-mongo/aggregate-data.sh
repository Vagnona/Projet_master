#!/bin/bash
# Script réalisant la moyenne des données datant d'une heure ou moins 
# pour les insérer dans la table historique, et supprimant les entrées datant
# d'un mois ou plus. 

function calculateAndInsertAverage() {
    local collectionName=$1
    local idAgri=$2
    local idChamp=$3
    local idIlot=$4
    local currentDate=$5
    local oneHourAgo=$(date -u -d "${currentDate} 1 hour ago" +"%Y-%m-%dT%H:%M:%SZ")
    # valeur conn pour prod :
    # var conn = new Mongo('mongodb://mongo1:30001,mongo2:30002,mongo3:30003/data/?replicaSet=rs0');
    # valeur conn local :
    # var conn = new Mongo('mongodb://localhost:30001/data');
    # ajouter --port 30001 après mongosh
    local result=$(mongosh --quiet --eval "
        var conn = new Mongo('mongodb://mongo1:30001,mongo2:30002,mongo3:30003/data/?replicaSet=rs0');
        var db = conn.getDB('data');
        var aggregateResult = db.getCollection('${collectionName}').aggregate([
            {
                \$match: {
                    idAgri: ${idAgri},
                    idChamps: ${idChamp},
                    idIlot: ${idIlot},
                    date: {\$gte: new Date('${oneHourAgo}'), \$lte: new Date('${currentDate}')}}
            },
            {
                \$group: {
                    _id: null,
                    average: {\$avg: '\$${collectionName}'}
                }
            }
        ]).toArray();

        if (aggregateResult.length > 0) {
            var average = aggregateResult[0].average;
            db.historique.updateOne(
                {
                    idAgri: ${idAgri},
                    idChamp: ${idChamp},
                    idIlot: ${idIlot},
                    date: new Date('${currentDate}')
                },
                {
                    \$set: {
                        idAgri: ${idAgri},
                        idChamp: ${idChamp},
                        idIlot: ${idIlot},
                        date: new Date('${currentDate}'),
                        m${collectionName}: average
                    }
                },
                { upsert: true }
            );
        } else {
            print(new Date('${currentDate}').toISOString().slice(0, 19).replace('T', ' ') +
            ' Pas de données datant d\'une heure ou moins dans ' +
            '${collectionName} pour idAgri:${idAgri}, ' +
            'idChamps:${idChamp}, idIlot:${idIlot}');
        }

        // Suppression des entrées datant de plus d'un mois
        var oneMonthAgo = new Date();
        oneMonthAgo.setMonth(oneMonthAgo.getMonth() - 1);
        var deleteResult = db.getCollection('${collectionName}').deleteMany({
            date: {\$lt: oneMonthAgo}
        });
        if (deleteResult.deletedCount > 0) {
            print(new Date('${currentDate}').toISOString().slice(0, 19).replace('T', ' ') +
            deleteResult.deletedCount +
            ' entrées supprimées de la table ${collectionName} datant de plus d\'un mois.');
        }
        print(JSON.stringify(aggregateResult));
    ")
    # Suppression
    result=$(echo "$result" | tr -d '[]')
    echo "$result"
}

# Calculer la moyenne pour chaque combinaison d'agriculteur, champ et îlot
# On récupère les combinaison via distinct de la table lumi
currentDate=$(date -u +"%Y-%m-%dT%H:%M:%SZ")
agris=$(mongosh --quiet --eval "
    var conn = new Mongo('mongodb://mongo1:30001,mongo2:30002,mongo3:30003/data/?replicaSet=rs0');
    var db = conn.getDB('data');
    db.lumi.distinct('idAgri', { idAgri: { \$exists: true } })")

for idAgri in $(echo "${agris}" | jq -c '.[]'); do
    champs=$(mongosh --quiet --eval "
    var conn = new Mongo('mongodb://mongo1:30001,mongo2:30002,mongo3:30003/data/?replicaSet=rs0');
    var db = conn.getDB('data');
    db.lumi.distinct('idChamps', { idAgri: ${idAgri}, idChamps: { \$exists: true } })
    ")

    for idChamp in $(echo "${champs}" | jq -c '.[]'); do
        ilots=$(mongosh --quiet --eval "
        var conn = new Mongo('mongodb://mongo1:30001,mongo2:30002,mongo3:30003/data/?replicaSet=rs0');
        var db = conn.getDB('data');
        db.lumi.distinct('idIlot', { idAgri: ${idAgri}, idChamps: ${idChamp}, idIlot: { \$exists: true } })
        ")

        for idIlot in $(echo "${ilots}" | jq -c '.[]'); do
            calculateAndInsertAverage "lumi" "${idAgri}" "${idChamp}" "${idIlot}" "${currentDate}"
            calculateAndInsertAverage "humi" "${idAgri}" "${idChamp}" "${idIlot}" "${currentDate}"
            calculateAndInsertAverage "temp" "${idAgri}" "${idChamp}" "${idIlot}" "${currentDate}"
        done
    done
done
