ARG PHP_IMAGE=php:8.5.10-apache

FROM $PHP_IMAGE AS base

#base dependencies
RUN apt-get update -qq\
  && apt-get install -y --no-install-recommends libzip-dev\
  && docker-php-ext-install -j"$(nproc)" zip\
  && apt-get purge -y libzip-dev\
  && rm -rf /var/lib/apt/lists/*

WORKDIR /var/www/html

FROM base AS dev

COPY src .

FROM base AS prod

COPY src .
