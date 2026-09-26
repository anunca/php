#!/usr/bin/env bash

function clone {
  git clone --depth 1 -b php-${PHP_VERSION_NUMBER} https://github.com/php/php-src.git .
}

function build {
  ./buildconf --force \
    && ./configure --prefix=${PHP_DIR} --enable-fpm --with-zip --with-pdo-mysql \
    && make -j$(nproc) \
    && make install
}

clone \
&& build
