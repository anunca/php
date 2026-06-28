ARG COMPOSER_IMAGE=composer:2.9.7
ARG PHP_IMAGE

FROM $COMPOSER_IMAGE AS composer

FROM $PHP_IMAGE AS base
 
#base dependencies
RUN apt update -qq\
  && apt install -y libzip-dev\
  && rm -rf /var/lib/apt/lists/*

#extensions
RUN docker-php-ext-install -j$(nproc) zip pdo_mysql\
  && docker-php-ext-enable opcache
 
WORKDIR /var/www/html

FROM base AS dev

#Composer dependencies
RUN apt update -qq\
  && apt install -y git unzip\
  && rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_ALLOW_SUPERUSER=1

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' /usr/local/etc/php/php.ini

FROM dev AS build
 
COPY src .

ARG APP_ENV
ARG APP_DEBUG

RUN composer install --no-dev --optimize-autoloader\
  && composer dump-autoload --no-dev --classmap-authoritative

FROM base AS prod
 
COPY --from=build /var/www/html .

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
s/;opcache.memory_consumption=.*/opcache.memory_consumption=256/;\
s/;opcache.max_accelerated_files=.*/opcache.max_accelerated_files=20000/;\
s/;opcache.validate_timestamps=.*/opcache.validate_timestamps=0/;\
s/;opcache.interned_strings_buffer=.*/opcache.interned_strings_buffer=16/;\
s|;opcache.preload=.*|opcache.preload=/var/www/html/vendor/preload.php|;\
s/;opcache.preload_user=.*/opcache.preload_user=www-data/;\
' /usr/local/etc/php/php.ini\
&& echo 'opcache.jit_buffer_size=100M' >> /usr/local/etc/php/php.ini\
&& sed -i '\
s/;realpath_cache_size =.*/realpath_cache_size = 4096k/;\
s/;realpath_cache_ttl =.*/realpath_cache_ttl = 600/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
s/display_errors =.*/display_errors = Off/;\
' /usr/local/etc/php/php.ini
