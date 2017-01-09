docker run --name postgresql -d -e 'DB_USER=username' -e 'DB_PASS=ridiculously-complex_password1' -e 'DB_NAME=my_database' php-postgresql-phpunit-composer
@pause