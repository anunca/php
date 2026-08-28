ARG PHP_IMAGE=php:8.5.9-fpm-alpine

FROM $PHP_IMAGE AS base

#php memcached
RUN apk --no-cache add autoconf g++ make zlib-dev libmemcached-dev libmemcached\
  && yes '' | pecl install --force memcached\
  && docker-php-ext-enable memcached\
  && apk del --purge autoconf g++ make zlib-dev libmemcached-dev

#php redis
RUN apk --no-cache add autoconf g++ make\
  && yes '' | pecl install --force redis\
  && docker-php-ext-enable redis\
  && apk del --purge autoconf g++ make

USER www-data:www-data

WORKDIR /tmp/session
RUN chmod 777 /tmp/session\
  && chown www-data:www-data /tmp/session

WORKDIR /run/php
RUN touch /run/php/php-fpm.sock

WORKDIR /app
