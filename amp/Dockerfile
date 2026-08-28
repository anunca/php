ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.9-apache

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apt update -qq\
  && apt install -y libzip-dev\
  && rm -rf /var/lib/apt/lists/*
  
#PHP extensions
RUN docker-php-ext-install -j$(nproc) zip

#redis
RUN pecl install redis\
  && rm -rf /tmp/pear\
  && docker-php-ext-enable redis

WORKDIR /var/www/html

FROM base AS base-builder

#Composer dependencies
RUN apt update -qq\
  && apt install -y git unzip\
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM base-builder AS dev

#xdebug
RUN pecl install xdebug\
  && docker-php-ext-enable xdebug
COPY etc/php/xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

FROM base-builder AS build-prod

COPY src/composer.json .

RUN composer install --no-dev --optimize-autoloader\
  && composer dump-autoload --no-dev --classmap-authoritative

COPY src .

FROM base AS prod

COPY --from=build-prod /var/www/html .
