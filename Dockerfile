FROM nginx:alpine

# Allow for a HOST argument on build, but default to something sensible
ARG HOST=jende.solutions.local

RUN apk add \
    openssl \
    curl \
    less \
    mysql-client \
    php7 \
    php7-fpm \
    php7-phar \
    php7-iconv \
    php7-openssl \
    php7-mysqli \
    php7-opcache \
    php7-json \
    php7-zlib \
    php7-curl \
    shadow

# Fix iconv library with Alpine Linux
RUN apk add --no-cache --repository http://dl-cdn.alpinelinux.org/alpine/edge/community/ --allow-untrusted gnu-libiconv
ENV LD_PRELOAD /usr/lib/preloadable_libiconv.so php

RUN mkdir /app \
 && mkdir /etc/nginx/ssl

WORKDIR /app

COPY entrypoint.sh /entrypoint.sh
COPY Web/ /app/
COPY Nginx/etc/nginx/conf.d/default.conf /etc/nginx/conf.d/

# RUN sed -i -e "s/user  nginx;//g" /etc/nginx/nginx.conf

# Exposes environment variables in PHP
# Accessible within `$_SERVER` var (because why would `$_ENV` make sense?)
# RUN echo "env[MYSQL_DATABASE] = \$MYSQL_DATABASE" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[MYSQL_USERNAME] = \$MYSQL_USERNAME" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[MYSQL_PASSWORD] = \$MYSQL_PASSWORD" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[MYSQL_HOST] = \$MYSQL_HOST" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[AUTH_KEY] = \$AUTH_KEY" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[SECURE_AUTH_KEY] = \$SECURE_AUTH_KEY" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[LOGGED_IN_KEY] = \$LOGGED_IN_KEY" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[NONCE_KEY] = \$NONCE_KEY" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[AUTH_SALT] = \$AUTH_SALT" >> /etc/php7/php-fpm.d/www.conf \
#  && echo "env[SECURE_AUTH_SALT] = \$SECURE_AUTH_SALT" >> /etc/php7/php-fpm.d/www.conf

# Creates a local SSL certificate for the configured `$HOST` environment variable
RUN openssl req -new -newkey rsa:4096 -days 3650 -nodes -x509 -subj "/C=US/ST=NC/L=Local/O=Dev/CN=$HOST" -keyout /etc/nginx/ssl/ssl.key -out /etc/nginx/ssl/ssl.crt \
 && cp /etc/nginx/ssl/ssl.crt /usr/local/share/ca-certificates/ssl.crt \
 && chmod 644 /usr/local/share/ca-certificates/ssl.crt \
 && update-ca-certificates

# Installs WordPress CLI and dependencies
RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar \
 && chmod +x wp-cli.phar \
 && mv wp-cli.phar /usr/local/bin/wp

RUN mkdir -p /var/run \
 && touch /var/run/nginx.pid \
 && chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]

VOLUME /var/log /var/cache

CMD ["nginx", "-g", "daemon off;"]

# Print some setup instructions
RUN printf "\e[0;36mHow to create a WordPress admin account:\n\n" \
 && printf "Once the container is running, drop into the shell:\n" \
 && printf "\e[1;33mdocker exec -it jende_app /bin/ash\n\n" \
 && printf "\e[0;36mThen, within the container, use the WordPress CLI to create your user:\n" \
 && printf "\e[1;33mwp user create <username> <email> --role=administrator\e[0m\n"