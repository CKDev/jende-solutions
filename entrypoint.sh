#!/bin/sh
set -e

# Copy the template file that we will find/replace strings in
cp /app/wp-config.template.php /app/wp-config.php

# Inject environment variable values from .env into the wp-config.php file
sed -i -e "s/@MYSQL_DATABASE/'$MYSQL_DATABASE'/g" /app/wp-config.php
sed -i -e "s/@MYSQL_USERNAME/'$MYSQL_USERNAME'/g" /app/wp-config.php
sed -i -e "s/@MYSQL_PASSWORD/'$MYSQL_PASSWORD'/g" /app/wp-config.php
sed -i -e "s/@MYSQL_HOST/'$MYSQL_HOST'/g" /app/wp-config.php
sed -i -e "s/@AUTH_KEY/'$AUTH_KEY'/g" /app/wp-config.php
sed -i -e "s/@SECURE_AUTH_KEY/'$SECURE_AUTH_KEY'/g" /app/wp-config.php
sed -i -e "s/@LOGGED_IN_KEY/'$LOGGED_IN_KEY'/g" /app/wp-config.php
sed -i -e "s/@NONCE_KEY/'$NONCE_KEY'/g" /app/wp-config.php
sed -i -e "s/@AUTH_SALT/'$AUTH_SALT'/g" /app/wp-config.php
sed -i -e "s/@SECURE_AUTH_SALT/'$SECURE_AUTH_SALT'/g" /app/wp-config.php

php-fpm7

exec "$@"
