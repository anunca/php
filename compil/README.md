# PHP compil
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- https://github.com/php/php-src
- https://www.php.net/
## install
```sh
make help
```
## notes
prod
```sh
export ENV=prod
```
install
```sh
unset PHP_VERSION_NUMBER
```
default php-8.5.10
```sh
export PHP_VERSION_NUMBER='7.2.34'
export PHP_VERSION_NUMBER='7.3.27'
export PHP_VERSION_NUMBER='7.4.19'
```
```sh
make build
```
```sh
make start
```
```sh
curl localhost/index.php\
&& curl localhost/server.php\
&& curl localhost/phpinfo.php
```
```sh
docker compose exec app php -v
```
```sh
docker compose exec app php -m
```
```sh
docker compose exec app php --ini
```
