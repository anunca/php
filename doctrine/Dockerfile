ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

#base dependencies
RUN apk add --no-cache libzip-dev
  
#PHP extensions
RUN docker-php-ext-install -j$(nproc) zip pdo_mysql\
  && docker-php-ext-enable opcache

WORKDIR /var/www/html

FROM base AS dev

#Composer dependencies
RUN apk add unzip git\
  && rm -rf /var/cache/apk/

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM dev AS build

COPY src .

RUN composer install --no-dev --optimize-autoloader\
  && composer dump-autoload --no-dev --classmap-authoritative

FROM base AS prod

COPY --from=build /var/www/html .
