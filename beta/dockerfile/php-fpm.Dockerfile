ARG PHP_IMAGE=php:8.5.10-fpm-alpine

FROM $PHP_IMAGE AS base

ARG PHP_REDIS_VERSION=6.3.0

#redis
RUN apk add --no-cache --virtual .virtual autoconf build-base\
  && pecl install redis-$PHP_REDIS_VERSION\
  && docker-php-ext-enable redis\
  && apk del .virtual

COPY ./etc/php-fpm/www.conf $PHP_INI_DIR-fpm.d/zz-docker.conf

WORKDIR /var/www/html

FROM base AS builder-dev

#xdebug
# RUN apk add --no-cache --virtual .virtual autoconf build-base linux-headers\
#   && pecl install xdebug\
#   && docker-php-ext-enable xdebug\
#   && apk del .virtual
RUN apk add --no-cache --virtual .virtual autoconf build-base linux-headers\
  && wget https://xdebug.org/files/xdebug-3.5.3.tgz\
  && tar -xzf xdebug-3.5.3.tgz\
  && cd xdebug-3.5.3\
  && phpize\
  && ./configure --enable-xdebug\
  && make\
  && make install\
  && cd ..\
  && rm -rf xdebug*\
  && docker-php-ext-enable xdebug\
  && apk del .virtual

FROM builder-dev AS dev

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

FROM base AS builder-prod

COPY ./src /var/www/html

FROM builder-prod AS prod

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=builder-prod /var/www/html .
