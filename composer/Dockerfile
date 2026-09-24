ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-fpm-alpine

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apk add --no-cache libzip-dev

#PHP extensions
RUN docker-php-ext-install -j$(nproc) zip

WORKDIR /app

FROM base AS base-builder

#Composer dependencies
RUN apk add --no-cache unzip git

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

ARG GITHUB_TOKEN
RUN if [ -n "$GITHUB_TOKEN" ]; then composer config --global github-oauth.github.com "$GITHUB_TOKEN"; fi

FROM base-builder AS dev

#php ini
RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' $PHP_INI_DIR/php.ini

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
