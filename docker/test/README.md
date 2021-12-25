Docker for test
===============

Pour fonctionner, Wercker a besoin d'une "box" pour lancer les tests unitaires.
Les box sont en fait des images docker. 
On peut donc utiliser une image existante ou en créer une en fonction de nos besoins et la stocker sur docker Hub.
Voilà comment procéder pour créer notre propre box.

## Prérequis
Vous devez : 
- installer docker
- installer docker-compose
- avoir un compte sur https://hub.docker.com/
- pouvoir accéder aux repositories AMG Développement https://cloud.docker.com/u/amgdeveloppement/repository/list

## Installation & configurations

### Cloner le projet Relight 
```bash
$ git clone git@github.com:amg-dev/relight.git
```
### Create and Push images to Docker Cloud
Je vous invite à lire la documentation https://docs.docker.com/docker-hub/#step-4-build-and-push-a-container-image-to-docker-hub-from-your-computer

#### Log to docker repository :
Il faut avoir un compte docker sur https://hub.docker.com/ et se connecter à son compte avec la commande suivante :
```bash
docker login
```

#### Build docker image : 
Pour constuire l'image docker, il faut se mettre dans le dossier wercker et lancer le build de l'image en utilisant docker-compose :
```bash
$ cd <relight>/docker/wercker && docker-compose up -d
```
#### Tag existing docker image : https://docs.docker.com/engine/reference/commandline/tag/ 
Le hub docker fonctionne avec des repositories (comme github) et chaque repository peut contenir plusieurs images docker. Pour les différencier, il y a un système de tags. Le tag par défaut est latest un peu comme sur git où le nom de la branche par défaut est master.

Exemple :
- repository PHP : https://hub.docker.com/_/php 
- tags : 7.2, 7.3 etc https://hub.docker.com/_/php?tab=tags

Ici nous allons donc tagger l'image docker que nous venons de créer spécialement pour wercker.
```bash
docker tag wercker_php74:latest amgdeveloppement/relight-admin-wercker:wercker_php74_rabbitmq
```
- Image source : wercker_php avec le tag latest
- Image cible : amgdeveloppement/relight-admin-wercker avec le tag wercker_php74_rabbitmq

Pour voir liste des images présentes sur notre machine il faut utiliser la commande suivante : 
```bash
docker images
```

#### Push image :
Maintenant que l'image est créée et taggée il reste plus qu'à envoyer l'image sur docker hub. 

/!\ Attention ça peut prendre un peu temps en fonction de la taille de l'image car c'est de l'upload de données. 
```bash
docker push amgdeveloppement/relight-admin-wercker:wercker_php74_rabbitmq
```

Vous pouvez vérifier que l'image est bien dans le repository https://cloud.docker.com/u/amgdeveloppement/repository/docker/amgdeveloppement/relight-admin-wercker

### Configuration de wercker
Fichier : ```wercker.yml``` à la raçine du projet
```bash
build:
    box:
      id: guido/python (nom du repository sur docker HUB)
      username: $DOCKER_HUB_USERNAME (Variable d'env définie dans l'interface de Wercker)
      password: $DOCKER_HUB_PASSWORD (Variable d'env définie dans l'interface de Wercker)
      tag: latest (TAG de l'image docker)
    steps:
      - script:
        name: echo

```
Documentation wercker : http://devcenter.wercker.com/docs/containers/private-containers
