#!/bin/bash

echo "Run php.sh file"

sed -i \
	-e 's/^short_open_tag = Off/short_open_tag = On/g' \
	-e 's/;date.timezone =/date.timezone = UTC/g' \
	-e 's/expose_php = On/expose_php = Off/g' \
	/etc/php.ini

php -r 'echo date_default_timezone_get();'