ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-apache

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apt update -qq\
  && apt install -y libzip-dev\
  && rm -rf /var/lib/apt/lists/*

#PHP extensions
RUN docker-php-ext-install -j$(nproc) zip

#opcache
COPY etc/php/opcache.ini $PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini

#redis
RUN pecl install redis\
  && rm -rf /tmp/pear\
  && docker-php-ext-enable redis

#memcached
RUN apt update -qq\
  && apt install -y libmemcached-dev libssl-dev\
  && rm -rf /var/lib/apt/lists/*
RUN yes '' | pecl install -f memcached\
  && rm -rf /tmp/pear\
  && docker-php-ext-enable memcached

RUN a2enmod rewrite

WORKDIR /var/www/html

FROM base AS base-builder

#Composer dependencies
RUN apt update -qq\
  && apt install -y git unzip\
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM base-builder AS dev

#php ini
RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini\
&& sed -i '\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' $PHP_INI_DIR/php.ini

#xdebug
RUN pecl install xdebug\
  && docker-php-ext-enable xdebug
COPY etc/php/xdebug/xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

COPY src/composer.json .
RUN composer install
COPY src .

FROM base-builder AS build-prod

COPY src/composer.json .

#TODO debug error
RUN composer install --no-dev --optimize-autoloader\
  && composer dump-autoload --no-dev --classmap-authoritative

COPY src .

FROM base AS prod

#php ini
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=build-prod /var/www/html .
