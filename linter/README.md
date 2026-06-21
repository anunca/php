# PHP linter
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- https://code.visualstudio.com/docs/languages/php
## install
```sh
make help
```
## notes
```sh
cat <<EOF | sudo tee /usr/local/bin/php > /dev/null
docker run -it --rm -v$(pwd):/app registry.app.internal/php-linter $@
EOF
```
```sh
chmod +x /usr/local/bin/php
```
VS Code
```sh
cat <<EOF >> .vscode/settings.json
{
  "php.validate.enable": true,
  "php.validate.executablePath": "/usr/local/bin/php"
}
EOF
```