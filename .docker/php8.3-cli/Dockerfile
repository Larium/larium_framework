FROM php:8.3-cli
WORKDIR "/opt/php"

ENV DEBIAN_FRONTEND noninteractive

RUN apt-get update && \
    apt-get install -y zip libzip-dev git && \
    pecl channel-update pecl.php.net && \
    pecl install xdebug && \
    docker-php-ext-install bcmath zip mysqli && \
    docker-php-source delete && \
    rm -r /tmp/* /var/cache/*

COPY ./.docker/php8.3-cli/php-ini-overrides.ini /usr/local/etc/php/conf.d/99-overrides.ini

RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
     && php composer-setup.php \
     && php -r "unlink('composer-setup.php');" \
     && chmod +x composer.phar \
     && mv composer.phar /usr/local/bin/composer
