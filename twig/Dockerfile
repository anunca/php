ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-apache

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base
 
# Build PHP extensions and remove build-only headers in the same layer
RUN apt-get update -qq\
  && apt-get install -y --no-install-recommends libzip-dev\
  && docker-php-ext-install -j"$(nproc)" zip pdo_mysql\
  && apt-get purge -y libzip-dev\
  && rm -rf /var/lib/apt/lists/*
 
WORKDIR /var/www/html

FROM base AS dev

#Composer dependencies
RUN apt-get update -qq\
  && apt-get install -y git unzip\
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' $PHP_INI_DIR/php.ini

FROM dev AS build

ARG APP_ENV
ARG APP_DEBUG

COPY src/composer.json src/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer-cache \
    COMPOSER_CACHE_DIR=/tmp/composer-cache composer install --no-dev --no-interaction --no-progress --prefer-dist --no-autoloader --no-scripts
COPY src .
# Generate the optimized autoloader after application classes are available.
RUN composer dump-autoload --no-dev --optimize --no-interaction

FROM base AS prod
 
COPY --from=build /var/www/html .

RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s/;opcache.memory_consumption=.*/opcache.memory_consumption=256/;\
s/;opcache.max_accelerated_files=.*/opcache.max_accelerated_files=20000/;\
s/;opcache.validate_timestamps=.*/opcache.validate_timestamps=0/;\
s/;opcache.interned_strings_buffer=.*/opcache.interned_strings_buffer=16/;\
' $PHP_INI_DIR/php.ini\
&& echo 'opcache.jit_buffer_size=100M' >> $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;realpath_cache_size =.*/realpath_cache_size = 4096k/;\
s/;realpath_cache_ttl =.*/realpath_cache_ttl = 600/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
s/display_errors =.*/display_errors = Off/;\
' $PHP_INI_DIR/php.ini
