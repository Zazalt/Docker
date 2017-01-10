FROM centos:centos7

MAINTAINER Zazalt <https://github.com/Zazalt>

#RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nStarting...\n"

# -----------------------------------------------------------------------------
# Install Extra Packages for Enterprise Linux (epel)
# -----------------------------------------------------------------------------

RUN yum -y install epel-release; yum clean all

# -----------------------------------------------------------------------------
# Update yum
# -----------------------------------------------------------------------------

RUN yum -y update; yum clean all

# -----------------------------------------------------------------------------
# The centos:centos7 image doesn't have "service" command
# -----------------------------------------------------------------------------

RUN yum -y install initscripts && yum clean all

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
# https://github.com/CentOS/CentOS-Dockerfiles/blob/master/postgres/centos7/Dockerfile

RUN yum -y install sudo epel-release; yum clean all
RUN yum -y install postgresql-server postgresql postgresql-contrib supervisor pwgen; yum clean all

ADD ./postgresql-setup /usr/bin/postgresql-setup
ADD ./supervisord.conf /etc/supervisord.conf
ADD ./start_postgres.sh /start_postgres.sh

#Sudo requires a tty. fix that.
RUN sed -i 's/.*requiretty$/#Defaults requiretty/' /etc/sudoers
RUN chmod +x /usr/bin/postgresql-setup
RUN chmod +x /start_postgres.sh

RUN /usr/bin/postgresql-setup initdb

ADD ./postgresql.conf /var/lib/pgsql/data/postgresql.conf

RUN chown -v postgres.postgres /var/lib/pgsql/data/postgresql.conf

RUN echo "host    all             all             0.0.0.0/0               md5" >> /var/lib/pgsql/data/pg_hba.conf

VOLUME ["/var/lib/pgsql"]

EXPOSE 5432

CMD ["/bin/bash", "/start_postgres.sh"]

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

RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nOS\n"

RUN cat /etc/*-release

RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nPHP\n"

RUN php --version
RUN php -r 'echo date_default_timezone_get();'

RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nComposer:\n"

RUN composer --version

RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nPHPUnit:\n"

RUN phpunit --version