ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-apache

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apt-get update -qq\
  && apt-get install -y --no-install-recommends libzip-dev\
  && docker-php-ext-install -j"$(nproc)" zip\
  && apt-get purge -y libzip-dev\
  && apt-get autoremove -y\
  && rm -rf /var/lib/apt/lists/*

WORKDIR /app

FROM base AS dev

#Composer dependencies
RUN apt-get update -qq\
  && apt-get install -y git unzip\
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

COPY src/composer.json src/composer.lock ./
RUN composer install
COPY src .

FROM dev AS build

COPY src/composer.json src/composer.lock ./
RUN composer install --no-dev --optimize-autoloader
COPY src .

FROM base AS prod

COPY --from=build /app .
