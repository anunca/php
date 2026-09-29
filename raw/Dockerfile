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

FROM base AS base-builder

#Composer dependencies
RUN apk add --no-cache unzip git

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM base-builder AS dev

#xdebug
RUN apk add --no-cache --virtual .build-deps autoconf build-base linux-headers\
  && pecl install xdebug\
  && docker-php-ext-enable xdebug\
  && apk del .build-deps
COPY etc/php/xdebug.ini $PHP_INI_DIR/conf.d/docker-php-ext-xdebug.ini

#opcache
COPY etc/php/opcache.ini $PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini

#php.ini
RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini\
&& sed -i '\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' $PHP_INI_DIR/php.ini

COPY src/composer.json src/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer-cache \
  XDEBUG_MODE=off  COMPOSER_CACHE_DIR=/tmp/composer-cache composer install
COPY src .

FROM base-builder AS prod-builder

COPY src/composer.json src/composer.lock ./
# Cache dependency downloads independently of application source changes.
RUN --mount=type=cache,target=/tmp/composer-cache \
  COMPOSER_CACHE_DIR=/tmp/composer-cache composer install \
    --no-dev \
    --no-interaction \
    --no-progress \
    --prefer-dist \
    --no-autoloader \
    --no-scripts
COPY src .
# Include application classes in the optimized production autoloader.
RUN composer dump-autoload --no-dev --optimize --no-interaction

FROM base AS prod

#opcache
COPY etc/php/opcache-prod.ini $PHP_INI_DIR/conf.d/docker-php-ext-opcache.ini

#php.ini
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;realpath_cache_size =.*/realpath_cache_size = 4096k/;\
s/;realpath_cache_ttl =.*/realpath_cache_ttl = 600/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
s/display_errors =.*/display_errors = Off/;\
' $PHP_INI_DIR/php.ini

COPY --from=prod-builder /var/www/html .
