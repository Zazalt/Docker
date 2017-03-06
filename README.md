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
                # Start the PostgreSQL
                - /etc/init.d/postgresql start
                
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
* PostgreSQL ( username: `zazalt`, password: `zazalt`, db: `zazaltdb`)
* Composer


| Docker Pull Command                | OS            | PHP    | MySQL  | PostgreSQL |
| ---------------------------------- |---------------| -------| ------ | ---------- |
| `docker pull zazalt/docker:alpha`  | Ubuntu 14.01  | 5.6.30 | 5.5.54 | 9.3        |
| `not available yet`                | Ubuntu 14.01  | 7.0    | 5.6    | 9.3        |
| `not available yet`                | Ubuntu 14.01  | 7.1    | 5.6    | 9.3        |