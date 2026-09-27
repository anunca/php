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

#opcache
COPY etc/php/opcache.ini $PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini

#redis
RUN pecl install redis\
  && rm -rf /tmp/pear\
  && docker-php-ext-enable redis

#memcached
# hadolint ignore=DL4006
RUN apt-get update -qq\
  && apt-get install -y --no-install-recommends libmemcached-dev libssl-dev\
  && yes '' | pecl install -f memcached\
  && docker-php-ext-enable memcached\
  && apt-get purge -y libmemcached-dev libssl-dev\
  && apt-get autoremove -y\
  && rm -rf /tmp/pear /var/lib/apt/lists/*

RUN a2enmod rewrite

WORKDIR /var/www/html

FROM base AS base-builder

#Composer dependencies
RUN apt-get update -qq\
  && apt-get install -y git unzip\
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

COPY src/composer.json src/composer.lock ./
RUN composer install
COPY src .

FROM base-builder AS build-prod

COPY src/composer.json src/composer.lock ./
RUN composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --no-autoloader
COPY src .
RUN composer dump-autoload \
    --no-dev \
    --optimize \
    --classmap-authoritative

FROM base AS prod

#php ini
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=build-prod /var/www/html .
