# Composer
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- https://getcomposer.org/doc/05-repositories.md
- https://hub.docker.com/_/composer
## install
```sh
make help
```
## notes
prod
```sh
export ENV=prod
```sh
export GITHUB_TOKEN=YOUR_GITHUB_TOKEN
```
config
```sh
cat <<EOF>> .env
GITHUB_TOKEN=$GITHUB_TOKEN
EOF
```
