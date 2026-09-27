ARG PHP_IMAGE=php:8.5.10-apache

FROM $PHP_IMAGE AS base

#base dependencies
RUN apt-get update -qq\
  && apt-get install -y libzip-dev\
  && rm -rf /var/lib/apt/lists/*
  
#PHP extensions
RUN docker-php-ext-install -j"$(nproc)" zip

WORKDIR /var/www/html

FROM base AS dev

COPY src .

FROM dev AS build

COPY src .

FROM base AS prod

COPY --from=build /var/www/html .
