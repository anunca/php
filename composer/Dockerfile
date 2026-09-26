ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-fpm-alpine

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apk add --no-cache libzip-dev

#PHP extensions
RUN docker-php-ext-install -j$(nproc) zip

WORKDIR /usr/share/nginx/html

FROM base AS base-builder

#Composer dependencies
RUN apk add --no-cache unzip git

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM base-builder AS dev

COPY src/composer.json src/composer.lock ./
RUN --mount=type=secret,id=github_token \
    COMPOSER_AUTH="{\"github-oauth\":{\"github.com\":\"$(cat /run/secrets/github_token)\"}}" \
    composer install \
        --no-interaction \
        --no-progress \
        --prefer-dist
COPY src .

#php ini
RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' $PHP_INI_DIR/php.ini

FROM base-builder AS build-prod

COPY src/composer.json src/composer.lock ./
RUN --mount=type=secret,id=github_token \
    COMPOSER_AUTH="{\"github-oauth\":{\"github.com\":\"$(cat /run/secrets/github_token)\"}}" \
    composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --optimize-autoloader
COPY src .

FROM base AS prod

#php ini
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=build-prod /usr/share/nginx/html .
