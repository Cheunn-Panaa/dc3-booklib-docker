# Docker Symfony4 (PHP7.2-FPM - NGINX - MySQL - PHPMYADMIN)



Docker-symfony gives you everything you need for developing Symfony application. This complete stack run with docker and [docker-compose (1.7 or higher)](https://docs.docker.com/compose/).

## Installation

1. Creer `.env` à partir de `.env.dist` . Faite en sorte qu'il corresponde a votre environnement symfony

    ```bash
    cp .env.dist .env
    ```


2. Pour lancer le container docker.

    ```bash
    $ docker-compose build
    $ docker-compose up -d
    ```

3. Modifier votre fichier "hosts" de votre système, pour accèder à "symfony.local" qui sera notre url du projet

    ```bash
    # UNIX only: get containers IP address and update host (replace IP according to your configuration) (on Windows, edit C:\Windows\System32\drivers\etc\hosts)
    $ sudo echo $(docker network inspect bridge | grep Gateway | grep -o -E '[0-9\.]+') "symfony.local" >> /etc/hosts
    ```

    **Note:** For **OS X**, please take a look [here](https://docs.docker.com/docker-for-mac/networking/) and for **Windows** read [this](https://docs.docker.com/docker-for-windows/#/step-4-explore-the-application-and-run-examples) (4th step).

4. Prepare Symfony app
    1. Modifier votre .env (si ce n'est pas déjà fait)

        ```yml
        # This file is a "template" of which env vars need to be defined for your application
        # Copy this file to .env file for development, create environment variables when deploying to production
        # https://symfony.com/doc/current/best_practices/configuration.html#infrastructure-related-configuration
        
        ###> symfony/framework-bundle ###
        APP_ENV=dev
        APP_SECRET=79362ed5f90d17ece6d83c8202456303
        #TRUSTED_PROXIES=127.0.0.1,127.0.0.2,172.18.0.1 ##Les proxy que vous souhaitez##
        #TRUSTED_HOSTS=localhost,example.com,symfony.local ##Les hosts que vous souhaitez##
        ###< symfony/framework-bundle ###
        
        ###> doctrine/doctrine-bundle ###
        # Format described at http://docs.doctrine-project.org/projects/doctrine-dbal/en/latest/reference/configuration.html#connecting-using-a-url
        # For an SQLite database, use: "sqlite:///%kernel.project_dir%/var/data.db"
        # Configure your db driver and server_version in config/packages/doctrine.yaml
        DATABASE_URL=mysql://USERNAME:MDP@NOM_DU_CONTAINER_DOCKER:3306/booklib ##ATTENTION A BIEN RENSEIGNEZ VOS IDENTIFIANT##
        ###< doctrine/doctrine-bundle ###
        ```

    2. Composer install & create database

        ```bash
        $ docker-compose exec php bash
        $ composer install
        $ php bin/console doctrine:database:create
        $ php bin/console doctrine:schema:update --force
        $ php bin/console doctrine:fixtures:load --no-interaction
        ```

5. Enjoy :-)

## Utilisation

Run `docker-compose up -d` pour mettre a jour vos container:

* Symfony app: visit [symfony.local](http://symfony.local)  
* PhpMyAdmin: visit [symfony.local](http://symfony.local:8080)
Si aucun de ces liens ne fonctionne essayez [localhost](http://localhost/)
Ou en dernier recours l'ip donnez par `docker network inspect bridge | grep Gateway | grep -o -E '[0-9\.]+'`


## Comment ça marche?

Check `docker-compose.yml` :

* `db`: MySQL db container,
* `php`: PHP-FPM container
* `nginx`: WebServer NGINX,
* `phpmyadmin`: container PhpMyAdmin


Voir les container actifs:

```bash
$ docker-compose ps
           Name                          Command               State              Ports            
--------------------------------------------------------------------------------------------------
dockersymfony_db_1            /entrypoint.sh mysqld            Up      0.0.0.0:3306->3306/tcp      
dockersymfony_nginx_1         nginx                            Up      443/tcp, 0.0.0.0:80->80/tcp
dockersymfony_php_1           php-fpm                          Up      0.0.0.0:9000->9000/tcp      
```

## Useful commands

```bash
# bash commands
$ docker-compose exec php bash

# Composer (e.g. composer update)
$ docker-compose exec php composer update

# SF commands (Tips: there is an alias inside php container)  
$ docker-compose exec php bash
$ php bin/console cache:clear

# Retrieve an IP Address (here for the nginx container)
$ docker inspect --format '{{ .NetworkSettings.Networks.dockersymfony_default.IPAddress }}' $(docker ps -f name=nginx -q)
$ docker inspect $(docker ps -f name=nginx -q) | grep IPAddress

# MySQL commands
$ docker-compose exec db mysql -uroot -p"root"

# F***ing cache/logs folder
$ sudo chmod -R 777 var/cache var/logs var/sessions

# Check CPU consumption
$ docker stats $(docker inspect -f "{{ .Name }}" $(docker ps -q))

# Delete all containers
$ docker rm $(docker ps -aq)

# Delete all images
$ docker rmi $(docker images -q)
```

## FAQ

* Got this error: `ERROR: Couldn't connect to Docker daemon at http+docker://localunixsocket - is it running?
If it's at a non-standard location, specify the URL with the DOCKER_HOST environment variable.` ?  
Run `docker-compose up -d` instead.
Ou Run `sudo docker-compose up -d`

* Permission problem? See [this doc (Setting up Permission)](http://symfony.com/doc/current/book/installation.html#checking-symfony-application-configuration-and-setup)
