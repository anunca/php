ARG NGINX_IMAGE=nginx:1.31.4-alpine

FROM $NGINX_IMAGE AS base

COPY ./etc/nginx/fastcgi_params /etc/nginx/fastcgi_params
COPY ./etc/nginx/nginx.default.conf /etc/nginx/conf.d/default.conf

FROM base AS dev

COPY ./src/ /var/www/html

FROM base AS prod

COPY ./src/ /var/www/html
