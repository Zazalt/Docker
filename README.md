# Zazalt Docker

[![Docker HUB Repository](http://dockeri.co/image/zazalt/docker)](https://hub.docker.com/r/zazalt/docker/)

[![Travis CI](https://travis-ci.org/Zazalt/Docker.svg?branch=master)](https://travis-ci.org/Zazalt/Docker)

Those Docker images are specially designed to work with [Bitbucket Pipeline](https://bitbucket.org/product/features/pipelines)

`bitbucket-pipelines.yml` example:

```ymp
image: zazalt/docker:alpha

pipelines:
    default:
        - step:
            script:
                # PostgreSQL - start it. You can use - username: zazalt, password: zazalt, db: zazaltdb
                - /etc/init.d/postgresql start
                
                # MySQL - start it and create a new user and database
                - /etc/init.d/mysql start
                - mysql -uroot -e "CREATE DATABASE zazalt COLLATE 'utf8_unicode_ci'"
                - mysql -uroot -e "CREATE USER 'zazalt'@'localhost'"
                - mysql -uroot -e "GRANT ALL PRIVILEGES ON *.* TO 'zazalt'@'localhost' WITH GRANT OPTION"
                
                # Run (php) composer install
                - composer install
                
                # Run phpunit
                - phpunit
```

# Zazalt Docker image tags (versions)

| Docker Build            | Size    | OS            | PHP    | PHPUnit | MySQL  | PostgreSQL* | Hub Build |
| ----------------------- |-------- | --------------| -------| ------- | ------ | ----------- | ----- |
| `zazalt/docker:alpha`   | ~190 MB | Ubuntu 14.04  | 5.6.30 | 5.7.19  | 5.5.54 | 9.3         | [![Hub Docker Build](https://img.shields.io/badge/build-success-brightgreen.svg)](https://hub.docker.com/r/zazalt/docker/builds/) |
| `zazalt/docker:bravo`   | ~195 MB | Ubuntu 14.04  | 7.0.18 | 6.1.1   | 5.5.54 | 9.3         | [![Hub Docker Build](https://img.shields.io/badge/build-success-brightgreen.svg)](https://hub.docker.com/r/zazalt/docker/builds/) |
| `zazalt/docker:charlie` | ~195 MB | Ubuntu 14.04  | 7.1.4  | 6.1.1   | 5.5.54 | 9.3         | [![Hub Docker Build](https://img.shields.io/badge/build-success-brightgreen.svg)](https://hub.docker.com/r/zazalt/docker/builds/) |

###### All Zazalt Docker images will install:
* wget 1.15
* curl 7.35.0
* unzip 6.00
* screen 4.01
* git 1.9.1
* supervisor 3.0b2
* Composer 1.4.1

** PostgreSQL is having default credentials: username: `zazalt`, password: `zazalt`, db: `zazaltdb`