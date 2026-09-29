ARG COMPOSER_IMAGE=composer:2.10.2
ARG PHP_IMAGE=php:8.5.10-fpm-alpine

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base

# Keep the runtime library, but remove build-only headers after compiling extensions
RUN apk add --no-cache libzip\
  && apk add --no-cache --virtual .build-deps libzip-dev\
  && docker-php-ext-install -j"$(nproc)" zip\
  && apk del .build-deps

WORKDIR /usr/share/nginx/html

FROM base AS base-builder

#Composer dependencies
RUN apk add --no-cache unzip git

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

FROM base-builder AS dev

#php ini
RUN cp $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' $PHP_INI_DIR/php.ini

COPY src/composer.json src/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer-cache \
    --mount=type=secret,id=github_token \
    COMPOSER_CACHE_DIR=/tmp/composer-cache \
    COMPOSER_AUTH="{\"github-oauth\":{\"github.com\":\"$(cat /run/secrets/github_token)\"}}" \
    composer install \
        --no-interaction \
        --no-progress \
        --prefer-dist
COPY src .

FROM base-builder AS prod-builder

COPY src/composer.json src/composer.lock ./
RUN --mount=type=cache,target=/tmp/composer-cache \
    --mount=type=secret,id=github_token \
    COMPOSER_CACHE_DIR=/tmp/composer-cache \
    COMPOSER_AUTH="{\"github-oauth\":{\"github.com\":\"$(cat /run/secrets/github_token)\"}}" \
    composer install \
        --no-dev \
        --no-interaction \
        --no-progress \
        --prefer-dist \
        --no-autoloader \
        --no-scripts
COPY src .
# Generate the optimized autoloader after application classes are available.
RUN composer dump-autoload --no-dev --optimize --no-interaction

FROM base AS prod

#php ini
RUN cp $PHP_INI_DIR/php.ini-production $PHP_INI_DIR/php.ini

COPY --from=prod-builder /usr/share/nginx/html .
