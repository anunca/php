# PHP opcache
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- https://www.php.net/manual/en/book.opcache.php
- https://www.php.net/manual/en/opcache.preloading.php
## install
```sh
make help
```
## notes
prod
```sh
export ENV=prod
```
get opcache script
```sh
wget https://raw.github.com/rlerdorf/opcache-status/master/opcache.php
```
```sh
curl https://raw.github.com/rlerdorf/opcache-status/master/opcache.php --output opcache.php -L
```