# PHP beta
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
config
```sh
cat <<EOF | sudo tee -a /etc/hosts > /dev/null
127.0.0.1 php-beta.appdemo.name
EOF
```
browse apps
- http://php-beta.appdemo.name/index.php
- http://php-beta.appdemo.name/server.php
- http://php-beta.appdemo.name/phpinfo.php