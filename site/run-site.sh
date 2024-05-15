# arreter conteneur existant
echo "arret du conteneur . . ."
docker stop site_web

# créé le réseau si pas encore fait par mongo
docker network create -d bridge mongo-net

# build le conteneur si besoin
DIR="$(dirname "${0}")"
docker build -t site:latest $DIR

# run le conteneur
## pour utiliser le volume au lieu d'une copie des fichiers (pour le dev)
## >>> il faut commenter la ligne "COPY . /var/www/html" dans le Dockerfile
# docker run --rm -p 8080:80 -d --name site_web \
# 	-e MONGODB_URL=mongodb://mongo1:30001 \
# 	--network=mongo-net \
# 	-v ./:/var/www/html \
# 	site:latest

docker run --rm -p 8080:80 -d --name site_web \
	-e MONGODB_URL=mongodb://mongo1:30001 \
	--network=mongo-net \
	site:latest