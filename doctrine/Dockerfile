ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-fpm-alpine

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

# Keep the runtime library, but remove build-only headers after compiling extensions
RUN apk add --no-cache libzip\
  && apk add --no-cache --virtual .build-deps libzip-dev\
  && docker-php-ext-install -j"$(nproc)" zip pdo_mysql\
  && apk del .build-deps

WORKDIR /var/www/html

FROM base AS dev

#Composer dependencies
RUN apk add --no-cache unzip git

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

COPY --from=build /var/www/html .
