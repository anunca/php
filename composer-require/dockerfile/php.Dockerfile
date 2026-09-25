ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-fpm-alpine

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

WORKDIR /usr/share/nginx/html

FROM base AS base-builder

#Composer dependencies
RUN apk add --no-cache unzip git

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

#add github token
ARG GITHUB_TOKEN
RUN composer config --global github-oauth.github.com $GITHUB_TOKEN

FROM base-builder AS dev

COPY src/composer.json .
RUN composer install
COPY src .

FROM base-builder AS prod-builder

COPY src/composer.json .
RUN composer install --no-dev
COPY src .

FROM base AS prod

COPY --from=prod-builder /usr/share/nginx/html .
