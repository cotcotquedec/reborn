# Reborn

backoffice mec.


# Installation



## Accès à Github
Il faut évidemment au préalable que vous ayez accès au code
La page github du projet est : https://github.com/cotcotquedec/reborn
Envoyer un mail a cotcotquedec@gmail.com pour avoir un accès si vous pensez le mériter.

De plus, il est préférable d'intéragir avec github en SSH
Vous trouverez le necessaire ici : https://help.github.com/articles/generating-an-ssh-key/

## Récupérer les fichiers

On suppose que les fichiers seront dans /var/www

```
git clone git@github.com:cotcotquedec/reborn.git
```

## Installer Docker

Suivre les instructions officelles : https://docs.docker.com/engine/installation/linux/debian/

Ou alors : 
```
curl -fsSL https://get.docker.com/ | sh
```

## Installer composer

En root sur la machine
```
curl -s https://getcomposer.org/installer | php
mv composer.phar /usr/local/bin/composer
```

## Fichier de configuration

Pour un environnement local, le fichier est prêt

```
cp .env.local .env
```

## Installation des dépendances
Avec l'utilisateur du projet (www-data ou reborn etc...)
```
composer install
```

## Gestion des droits d'accès aux fichiers
```
sudo chmod -R 777 storage bootstrap/cache
```


## Lancer la construction du docker

A lancer en root ou avec sudo
```
docker build -t reborn .
```


## Lancer le docker

Lancer maintenant la machine (toujours en root ou avec sudo)
```
docker run -d -P -v /var/www/reborn:/var/www/reborn reborn
```


Vous pouvez aussi choisir le port d'ecoute (ici 32800)
```
docker run -d -p 32800:80 -v /var/www/reborn:/var/www/reborn reborn
```
