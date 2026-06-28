ARG PHP_IMAGE

FROM $PHP_IMAGE AS base
  
#PHP extensions
RUN docker-php-ext-enable opcache

WORKDIR /var/www/html

FROM base AS dev

RUN cp /usr/local/etc/php/php.ini-development /usr/local/etc/php/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=0/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
' /usr/local/etc/php/php.ini\
&& echo 'error_log = /dev/stderr' >> /usr/local/etc/php/php.ini\
&& echo 'auto_prepend_file = /usr/local/etc/php/auto_prepend_file.php' >> /usr/local/etc/php/php.ini

CMD php-fpm

FROM dev AS build

COPY src .

FROM base AS prod

COPY --from=build /var/www/html .

RUN chown -R nobody:nogroup var

RUN cp /usr/local/etc/php/php.ini-production /usr/local/etc/php/php.ini\
&& sed -i '\
s/;opcache.enable=.*/opcache.enable=1/;\
s/;opcache.enable_cli=.*/opcache.enable_cli=0/;\
s/;opcache.memory_consumption=.*/opcache.memory_consumption=256/;\
s/;opcache.max_accelerated_files=.*/opcache.max_accelerated_files=20000/;\
s/;opcache.validate_timestamps=.*/opcache.validate_timestamps=0/;\
s/;opcache.interned_strings_buffer=.*/opcache.interned_strings_buffer=16/;\
' /usr/local/etc/php/php.ini\
&& echo 'opcache.jit_buffer_size=100M' >> /usr/local/etc/php/php.ini\
&& echo 'error_log = /dev/stderr' >> /usr/local/etc/php/php.ini\
&& echo 'auto_prepend_file = /usr/local/etc/php/auto_prepend_file.php' >> /usr/local/etc/php/php.ini\
&& sed -i '\
s/;realpath_cache_size =.*/realpath_cache_size = 4096k/;\
s/;realpath_cache_ttl =.*/realpath_cache_ttl = 600/;\
s|;date.timezone =.*|date.timezone = Europe/Paris|;\
s/memory_limit =.*/memory_limit = 128M/;\
s/display_errors =.*/display_errors = Off/;\
' /usr/local/etc/php/php.ini
