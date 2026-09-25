# PHP cache
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- https://www.php-cache.com/en/latest/
## install
```sh
make help
```
## notes
prod
```sh
export ENV=prod
```
enable xdebug
```sh
cat <<EOF>> .env
XDEBUG_MODE=develop,debug
EOF
```
check
- [app](http://localhost:80)
- browse apps debug
  - [phpinfo](http://localhost:80/phpinfo.php)
  - [xdebuginfo](http://localhost:80/xdebuginfo.php)
  - [opcache](http://localhost:80/opcache.php)
  - [redis stack](http://localhost:8001)
- memcached
  ```sh
  sudo apt update\
  && sudo apt install -y telnet
  ```
  ```sh
  telnet memcached1 11211
  ```