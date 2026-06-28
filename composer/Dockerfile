ARG COMPOSER_IMAGE=composer:2.9.7
ARG PHP_IMAGE=php:8.3.14-cli-alpine

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apk add --no-cache libzip-dev

#PHP extensions
RUN docker-php-ext-install -j$(nproc) zip\
  && docker-php-ext-enable opcache

WORKDIR /app

FROM base AS base-builder

#Composer dependencies
RUN apk add --no-cache unzip git

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

ARG GITHUB_TOKEN
RUN composer config --global github-oauth.github.com $GITHUB_TOKEN

FROM base-builder AS dev

#php ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini

FROM base-builder AS build-prod

COPY src/composer.json .

#TODO debug error
RUN composer install --no-dev --optimize-autoloader\
  && composer dump-autoload --no-dev --classmap-authoritative

COPY src .

FROM base AS prod

#php ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini

COPY --from=build-prod /var/www/html .
