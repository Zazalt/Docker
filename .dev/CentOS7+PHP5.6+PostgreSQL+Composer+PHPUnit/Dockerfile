FROM centos:latest

MAINTAINER Zazalt <https://github.com/Zazalt>

#RUN echo -e "\n- - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -"
RUN echo -e "\nStarting...\n"

# -----------------------------------------------------------------------------
# Install Extra Packages for Enterprise Linux (epel)
# -----------------------------------------------------------------------------

RUN yum -y install epel-release && yum clean all

# -----------------------------------------------------------------------------
# Update yum
# -----------------------------------------------------------------------------

RUN yum -y update && yum clean all

# -----------------------------------------------------------------------------
# The centos:centos7 image doesn't have "service" command
# -----------------------------------------------------------------------------

RUN yum -y install initscripts && yum clean all

# -----------------------------------------------------------------------------
# Install wget
# -----------------------------------------------------------------------------

RUN yum -y install wget && yum clean all

# -----------------------------------------------------------------------------
# Install GIT
# -----------------------------------------------------------------------------

RUN yum -y install git && yum clean all

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

RUN yum clean all

ADD ./php.sh /php.sh
RUN chmod +x /php.sh
RUN sh ./php.sh

# -----------------------------------------------------------------------------
# Install PostgreSQL
# -----------------------------------------------------------------------------
# https://github.com/CentOS/CentOS-Dockerfiles/blob/master/postgres/centos7/Dockerfile

RUN yum -y install sudo epel-release && yum clean all
RUN yum -y install postgresql-server postgresql postgresql-contrib supervisor pwgen && yum clean all

ADD ./postgresql-setup /usr/bin/postgresql-setup
ADD ./supervisord.conf /etc/supervisord.conf
ADD ./start_postgres.sh /start_postgres.sh

#Sudo requires a tty. fix that.
RUN sed -i 's/.*requiretty$/#Defaults requiretty/' /etc/sudoers
RUN chmod +x /usr/bin/postgresql-setup
RUN chmod +x /start_postgres.sh

RUN /usr/bin/postgresql-setup initdb

#RUN find / -name 'postgresql.conf'

ADD ./postgresql.conf /var/lib/pgsql/data/postgresql.conf

RUN chown -v postgres.postgres /var/lib/pgsql/data/postgresql.conf

RUN echo "host    all             all             0.0.0.0/0               md5" >> /var/lib/pgsql/data/pg_hba.conf
#RUN echo "host    all             all             127.0.0.1/0               md5" >> /var/lib/pgsql/data/pg_hba.conf

VOLUME ["/var/lib/pgsql"]

EXPOSE 5432

RUN sh /start_postgres.sh

#RUN /etc/init.d/postgresql start
#RUN netstat -nlp | grep 5432
#RUN service postgres status
#RUN grep listen_addresses /var/lib/pgsql/data/postgresql.conf
#RUN psql -U test -h 127.0.0.1

# -----------------------------------------------------------------------------

#RUN service postgresql restart

# -----------------------------------------------------------------------------

#ADD ./test.php /test.php
#RUN chmod +x /test.php
#RUN php ./test.php

#CMD ["/bin/bash", "/start_postgres.sh"]