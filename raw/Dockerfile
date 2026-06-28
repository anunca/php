ARG COMPOSER_IMAGE=composer:2.9.7
ARG PHP_IMAGE

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apk add --no-cache libzip-dev

#extensions
RUN docker-php-ext-install -j$(nproc) zip pdo_mysql\
  && docker-php-ext-enable opcache

WORKDIR /var/www/html

FROM base AS base-builder

#Composer dependencies
RUN apk add unzip git\
  && rm -rf /var/cache/apk/

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM base-builder AS dev

#xdebug
RUN apk add --no-cache --virtual .virtual autoconf build-base linux-headers\
  && pecl install xdebug\
  && docker-php-ext-enable xdebug\
  && apk del -f .virtual
COPY etc/php/xdebug.ini /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

#opcache
COPY etc/php/opcache.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

#php.ini
RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini\
&& sed -i '\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' /usr/local/etc/php/php.ini

FROM base-builder AS build-prod

COPY src/composer.json .

RUN composer install --no-dev --optimize-autoloader\
  && composer dump-autoload --no-dev --classmap-authoritative

COPY src .

FROM base AS prod

#opcache
COPY etc/php/opcache-prod.ini /usr/local/etc/php/conf.d/docker-php-ext-opcache.ini

#php.ini
RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini\
&& sed -i '\
s/;realpath_cache_size =.*/realpath_cache_size = 4096k/;\
s/;realpath_cache_ttl =.*/realpath_cache_ttl = 600/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
s/display_errors =.*/display_errors = Off/;\
' /usr/local/etc/php/php.ini

COPY --from=build-prod /var/www/html .
