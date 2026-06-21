#!/usr/bin/env bash

function clone {
  git clone --depth 1 -b php-${PHP_VERSION_NUMBER} https://github.com/php/php-src.git .
}

function build {
  ./buildconf --force \
    && ./configure --prefix=${PHP_DIRECTORY} --enable-fpm --enable-opcache --with-zip --with-pdo-mysql \
    && make -j$(nproc) \
    && make install
}

function conf {
  test ${APP_ENV} = 'dev' && cp php.ini-development ${PHP_DIRECTORY}/lib/php.ini || cp php.ini-production ${PHP_DIRECTORY}/lib/php.ini \
  && sed -i 's/\[opcache\]/[opcache]\nzend_extension=opcache.so/;\
    s/;opcache.enable=.*/opcache.enable=1/;\
    s/;opcache.enable_cli=.*/opcache.enable_cli=1/;\
    s/;opcache.memory_consumption=.*/opcache.memory_consumption=256/;\
    s/;opcache.max_accelerated_files=.*/opcache.max_accelerated_files=20000/;\
    s/;opcache.validate_timestamps=.*/opcache.validate_timestamps=0/;\
    s/;realpath_cache_size =.*/realpath_cache_size = 4096k/;\
    s/;realpath_cache_ttl =.*/realpath_cache_ttl = 600/;\
    s|;date.timezone =.*|date.timezone = Europe/Paris|;\
    s|memory_limit =.*|memory_limit = 128M|' ${PHP_DIRECTORY}/lib/php.ini \
    && cp ${PHP_DIRECTORY}/etc/php-fpm.conf.default ${PHP_DIRECTORY}/etc/php-fpm.conf \
    && cp ${PHP_DIRECTORY}/etc/php-fpm.d/www.conf.default ${PHP_DIRECTORY}/etc/php-fpm.d/www.conf
}

clone \
&& build \
&& conf
