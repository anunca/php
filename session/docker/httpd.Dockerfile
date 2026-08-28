ARG HTTPD_VERSION=httpd:2.4.68-alpine

#base
FROM $HTTPD_VERSION AS base

RUN apk --no-cache add apache-mod-fcgid

#apache conf
RUN sed -i '\
  s|#LoadModule proxy_module modules/mod_proxy.so|LoadModule proxy_module modules/mod_proxy.so|;\
  s|#LoadModule proxy_fcgi_module modules/mod_proxy_fcgi.so|LoadModule proxy_fcgi_module modules/mod_proxy_fcgi.so|;\
  s|#Include conf/extra/httpd-vhosts.conf|Include conf/extra/httpd-vhosts.conf|;\
  ' /usr/local/apache2/conf/httpd.conf

WORKDIR /app
