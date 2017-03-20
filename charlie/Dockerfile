FROM ubuntu:14.04

MAINTAINER Zazalt <https://github.com/Zazalt>

ENV DEBIAN_FRONTEND noninteractive

#RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nStarting...\n"

# Set correct environment variables.
#ENV HOME /root
#ENV DEBIAN_FRONTEND noninteractive
#ENV INITRD No

# Our user in the container
USER root

#WORKDIR /root

# ----------------------------------------------------------------------------------------------------------------------
# Update
# ----------------------------------------------------------------------------------------------------------------------

#RUN sudo apt-get update && apt-get -f install

# ----------------------------------------------------------------------------------------------------------------------
# Install wget (1.15)
# ----------------------------------------------------------------------------------------------------------------------

RUN  apt-get update \
    && apt-get install -y wget \
    && rm -rf /var/lib/apt/lists/*

# ----------------------------------------------------------------------------------------------------------------------
# Install CURL
# ----------------------------------------------------------------------------------------------------------------------

RUN apt-get update \
    && apt-get -y install curl

# ----------------------------------------------------------------------------------------------------------------------
# Install UNZIP
# ----------------------------------------------------------------------------------------------------------------------

RUN apt-get update && \
    apt-get install -y \
        unzip

# ----------------------------------------------------------------------------------------------------------------------
# Install screen
# ----------------------------------------------------------------------------------------------------------------------

RUN apt-get update \
    && apt-get -y install screen

# ----------------------------------------------------------------------------------------------------------------------
# Install GIT (1.9.1)
# ----------------------------------------------------------------------------------------------------------------------

RUN apt-get update \
    && apt-get install -y git

# ----------------------------------------------------------------------------------------------------------------------
# Install Supervisor
# ----------------------------------------------------------------------------------------------------------------------

RUN apt-get update \
    && apt-get install -y supervisor

# ----------------------------------------------------------------------------------------------------------------------
# Install PHP (7.1.3)
# ----------------------------------------------------------------------------------------------------------------------

RUN apt-get -y install \
    python-software-properties \
    software-properties-common

RUN LC_ALL=C.UTF-8 add-apt-repository ppa:ondrej/php

RUN apt-get update

RUN apt-get -y install \
    php7.0 \
    php7.1-bcmath \
    php7.1-gd \
    php7.1-ldap \
    php7.1-sqlite \
    php7.1-pgsql \
    php7.1-mysql \
    php7.1-mcrypt \
    php7.1-xmlrpc \
    php7.1-fpm \
    php7.1-mbstring \
    php7.1-dom \
    php7.1-xmlwriter \
    php7.1-zip \
    php7.1-xdebug

RUN sed -i \
    -e 's/^short_open_tag = Off/short_open_tag = On/g' \
    -e 's/;date.timezone =/date.timezone = UTC/g' \
    -e 's/expose_php = On/expose_php = Off/g' \
    /etc/php/7.1/cli/php.ini

RUN sed -i \
	-e 's/^short_open_tag = Off/short_open_tag = On/g' \
	-e 's/;date.timezone =/date.timezone = UTC/g' \
	-e 's/expose_php = On/expose_php = Off/g' \
	/etc/php/7.1/fpm/php.ini

# ----------------------------------------------------------------------------------------------------------------------
# Install PostgreSQL (9.3.16)
# ----------------------------------------------------------------------------------------------------------------------
# https://www.andreagrandi.it/2015/02/21/how-to-create-a-docker-image-for-postgresql-and-persist-data/
# Create user [zazalt] with password [zazalt], and a database [zazaltdb]

RUN apt-key adv --keyserver keyserver.ubuntu.com --recv-keys B97B0AFCAA1A47F044F244A07FCC7D46ACCC4CF8
RUN echo "deb http://apt.postgresql.org/pub/repos/apt/ precise-pgdg main" > /etc/apt/sources.list.d/pgdg.list

RUN apt-get update && apt-get -y -q install python-software-properties software-properties-common \
    && apt-get -y -q install postgresql-9.3 postgresql-client-9.3 postgresql-contrib-9.3

USER postgres
RUN /etc/init.d/postgresql start \
    && psql --command "CREATE USER zazalt WITH SUPERUSER PASSWORD 'zazalt';" \
    && createdb -O zazalt zazaltdb

USER root
RUN echo "host all  all    0.0.0.0/0  md5" >> /etc/postgresql/9.3/main/pg_hba.conf
RUN echo "listen_addresses='*'" >> /etc/postgresql/9.3/main/postgresql.conf

EXPOSE 5432

RUN mkdir -p /var/run/postgresql && chown -R postgres /var/run/postgresql
VOLUME  ["/etc/postgresql", "/var/log/postgresql", "/var/lib/postgresql"]

USER postgres
CMD ["/usr/lib/postgresql/9.3/bin/postgres", "-D", "/var/lib/postgresql/9.3/main", "-c", "config_file=/etc/postgresql/9.3/main/postgresql.conf"]

# ----------------------------------------------------------------------------------------------------------------------
# Install MySQL (5.6.33)
# ----------------------------------------------------------------------------------------------------------------------

USER root

#RUN debconf-set-selections <<< 'mysql-server mysql-server/root_password password zazalt'
#RUN debconf-set-selections <<< 'mysql-server mysql-server/root_password_again password zazalt'

RUN apt-get update
RUN apt-get -y install mysql-server

#RUN echo "mysql-server-5.6 mysql-server/root_password password root" | sudo debconf-set-selections
#RUN echo "mysql-server-5.6 mysql-server/root_password_again password root" | sudo debconf-set-selections
#RUN apt-get -y install mysql-server-5.6

#RUN /etc/init.d/mysql restart

# Run the MySQL Secure Installation wizard
#RUN mysql_secure_installation

#RUN sed -i 's/127\.0\.0\.1/0\.0\.0\.0/g' /etc/mysql/my.cnf
RUN sed -i -e"s/^bind-address\s*=\s*127.0.0.1/bind-address = 0.0.0.0/" /etc/mysql/my.cnf

#RUN mysql -uroot -p -e 'USE mysql; UPDATE `user` SET `Host`="%" WHERE `User`="root" AND `Host`="localhost"; DELETE FROM `user` WHERE `Host` != "%" AND `User`="root"; FLUSH PRIVILEGES;'

EXPOSE 3306

# ----------------------------------------------------------------------------------------------------------------------
# Install composer
# ----------------------------------------------------------------------------------------------------------------------

USER root
RUN apt-get -y autoremove && apt-get clean && apt-get autoclean && \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN curl https://getcomposer.org/installer | php -- && mv composer.phar /usr/local/bin/composer && chmod +x /usr/local/bin/composer

# ----------------------------------------------------------------------------------------------------------------------
# Install PHPUnit (6.0.10)
# ----------------------------------------------------------------------------------------------------------------------

RUN wget https://phar.phpunit.de/phpunit-6.0.10.phar
RUN chmod +x phpunit-6.0.10.phar
RUN mv phpunit-6.0.10.phar /usr/local/bin/phpunit

# ----------------------------------------------------------------------------------------------------------------------
# Checkpoints
# ----------------------------------------------------------------------------------------------------------------------

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ OS ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN cat /etc/*-release

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ WGET ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN wget --version

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ CURL ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN curl --version

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ UNZIP ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN unzip -v

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ GIT ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN git --version

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ SUPERVISOR ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN supervisord --version

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ PHP ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN php --version
RUN php -r 'echo date_default_timezone_get();'

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ MYSQL ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN mysql --version

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ COMPOSER ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN composer --version

RUN echo -e "\n\n\t\t\t\t\t~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ PHPUnit ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~ ~\n\n"
RUN phpunit --version

RUN echo -e "\n\n\n\n\n"

# Cleanup
RUN  apt-get clean && \
    rm -rf \
    /var/lib/apt/lists/* \
    /tmp/* \
    /var/tmp/*

RUN echo -e "\n\n\n\n\n"