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

##### All the Zazalt Docker images will install
* wget 1.15
* curl 7.35.0
* unzip 6.00
* screen 4.01
* git 1.9.1
* supervisor 3.0b2
* PostgreSQL ( username: `zazalt`, password: `zazalt`, db: `zazaltdb`)
* Composer 1.4.1


| Docker Build            | OS            | PHP    | PHPUnit | MySQL  | PostgreSQL | Build |
| ----------------------- |---------------| -------| ------- | ------ | ---------- | ----- |
| `zazalt/docker:alpha`   | Ubuntu 14.01  | 5.6.30 | 5.7.19  | 5.5.54 | 9.3        | [![Hub Docker Build](https://img.shields.io/badge/build-success-brightgreen.svg)](https://hub.docker.com/r/zazalt/docker/builds/) |
| `zazalt/docker:bravo`   | Ubuntu 14.01  | 7.0.17 | 6.1.1   | 5.5.54 | 9.3        | [![Hub Docker Build](https://img.shields.io/badge/build-success-brightgreen.svg)](https://hub.docker.com/r/zazalt/docker/builds/) |
| `zazalt/docker:charlie` | Ubuntu 14.01  | 7.1.3  | 6.1.1   | 5.5.54 | 9.3        | [![Hub Docker Build](https://img.shields.io/badge/build-success-brightgreen.svg)](https://hub.docker.com/r/zazalt/docker/builds/) |