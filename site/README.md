# Site
## Docker
Construire et lancer l'image crée :  
`./run-site.sh`

Construire l'image Docker (optionnel):  
`docker build -t site:latest <path>`

Ouvrir un navigateur Internet et accéder à l'adresse :  
`localhost:8080`

S'attacher au container :  
`docker attach IdDuContainer`

## Manuellement
Afin de faire fonctionner le backend, il est nécessaire de lancer PHP, depuis
le dossier `site/`.

Pour cela, il faut lancer la commande :  
`php -S localhost:8080`

Puis, depuis un navigateur Internet, ouvrir `localhost:8080`.