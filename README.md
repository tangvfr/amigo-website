# Environement docker
## Paramétrage de votre environement
- copier et renommer le fichier '.env.example' en '.env' 
- puis changer les valeurs des variables pour corespondre a votre profil/github
## Setup de l'environement
- *effectuer la commande `docker-compose config` afin de vérifier que les variables d'environement on bien été prise en compte dans la configuration*
- effecuter la commande `docker-compsoe build` pour construire les contianers et l'image
## Démarage de l'environement
- effecuter la commande `docker-compsoe up -d` pour démarer l'environement
- effecuter la commande `docker exec -ti amigows_web bash` pour se connecter au container avec symfony et angular
- accèdé au site symfony par [localhost:8000](http://localhost:8000)
- accèdé au site angular par [localhost:8020](http://localhost:8020)
## Accedé à la base de données
- render vous dans votre navigateur sur l'url [localhost:18080](http://localhost:18080) pour accèdé à adminer
- puis saisir les champs de la manière suivante pour vous connecter:

|Nom du champ|Valeur|
|------------|------|
|System|PostgreSQL|
|Server|amigows.db|
|Username|{DB_USERNAME du fichier `.env`}|
|Password|{DB_PASSWORD du fichier `.env`}|
|Database|{DB_NAME du fichier `.env`}|
## Arrêt de l'environement
- effecuter la commande `docker-compsoe down` pour démarer l'environement


