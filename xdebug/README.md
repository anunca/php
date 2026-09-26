# PHP Xdebug
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- https://xdebug.org/docs/step_debug
- [Install PHP Profiler extension for Visual Studio](https://www.devsense.com/en)
- https://kcachegrind.github.io/html/Home.html
- https://marketplace.visualstudio.com/items?itemName=felixfbecker.php-debug
## install
```sh
make help
```
## notes
prod
```sh
export ENV=prod
```
.vscode/launch.json
```sh
  "configurations": [
    {
      "name": "Listen for XDebug",
      "type": "php",
      "request": "launch",
      "port": 9003,
      "pathMappings": {
          "/var/www/html": "${workspaceRoot}/src"
      }
    }
  ]
```