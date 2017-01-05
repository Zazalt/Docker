FROM centos:latest

MAINTAINER Zazalt <https://github.com/Zazalt>

RUN echo -e "\033[1;34m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\t Starting...\n\033[0m"

# -----------------------------------------------------------------------------
# Install Extra Packages for Enterprise Linux (epel)
# -----------------------------------------------------------------------------

RUN yum -y install epel-release; yum clean all

# -----------------------------------------------------------------------------
# Update yum
# -----------------------------------------------------------------------------

RUN yum -y update; yum clean all

# -----------------------------------------------------------------------------
# Install wget
# -----------------------------------------------------------------------------

RUN yum -y install wget

# -----------------------------------------------------------------------------
# Install GIT
# -----------------------------------------------------------------------------

RUN yum -y install git

# -----------------------------------------------------------------------------
# Install PHP 5.6
# -----------------------------------------------------------------------------
# https://webtatic.com/packages/php56/

RUN rpm -Uvh https://mirror.webtatic.com/yum/el7/webtatic-release.rpm
RUN yum -y install \
    php56w \
    php56w-common \
    php56w-mysqli \
    php56w-curl \
    php56w-opcache \
    php56w-gd \
    php56w-mbstring \
    php56w-mcrypt \
    php56w-pgsql \
    php56w-soap \
    php56w-mcrypt \
    php56w-pecl-memcache
RUN sed -i \
	-e 's/^short_open_tag = Off/short_open_tag = On/g' \
	-e 's/;date.timezone =/date.timezone = UTC/g' \
	-e 's/expose_php = On/expose_php = Off/g' \
	/etc/php.ini

# -----------------------------------------------------------------------------
# Install PostgreSQL
# -----------------------------------------------------------------------------
# https://github.com/CentOS/CentOS-Dockerfiles/blob/master/postgres/centos6/Dockerfile

ENV PG_MAJOR 9.6
ENV PG_VERSION 9.6.1-2.pgdg80+1

RUN yum -y install postgresql-server postgresql postgresql-contrib; yum clean all

# -----------------------------------------------------------------------------
# Install composer
# -----------------------------------------------------------------------------

RUN cd /tmp
RUN curl -sS https://getcomposer.org/installer | php
RUN mv composer.phar /usr/local/bin/composer
#RUN composer --version

# Install PHPUnit
RUN wget https://phar.phpunit.de/phpunit.phar
RUN chmod +x phpunit.phar
RUN mv phpunit.phar /usr/local/bin/phpunit
#RUN phpunit --version

RUN echo -e "\033[1;34m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\t OS:\n\033[0m"
RUN cat /etc/*-release

RUN echo -e "\033[1;34m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\t PHP:\n\033[0m"
RUN php --version
RUN php -r 'echo date_default_timezone_get();'

RUN echo -e "\033[1;34m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\t Composer:\n\033[0m"
RUN composer --version

RUN echo -e "\033[1;34m- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -\n\t PHPUnit:\n\033[0m"
RUN phpunit --version