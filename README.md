# PHP labs

Hands-on PHP examples covering runtime features, dependency management, frameworks, performance, observability, and development tooling.

| Lab | Purpose |
| --- | --- |
| [AMP](./amp/README.md) | Build an asynchronous PHP application with AMPHP |
| [Auto prepend file](./auto-prepend-file/README.md) | Load shared PHP code automatically before each request |
| [Autoload Composer](./autoload-composer/README.md) | Configure class autoloading with Composer |
| [Autoload namespace](./autoload-namespace/README.md) | Explore namespace-based PHP class autoloading |
| [Autoload](./autoload/README.md) | Implement native PHP class autoloading |
| [Beta](./beta/README.md) | Build and run a PHP beta release from source |
| [Builder](./builder/README.md) | Implement the Builder design pattern in PHP |
| [Cache](./cache/README.md) | Compare PHP caching with Redis and Memcached |
| [Compil](./compil/README.md) | Compile and test different PHP versions from source |
| [Composer require](./composer-require/README.md) | Install Composer packages with authenticated GitHub access |
| [Composer](./composer/README.md) | Work with Composer repositories and Docker |
| [DI](./di/README.md) | Build an application with PHP-DI dependency injection |
| [Doctrine](./doctrine/README.md) | Use Doctrine for database persistence |
| [EFK](./efk/README.md) | Collect and inspect PHP logs with Fluentd and Kibana |
| [Fibers](./fibers/README.md) | Explore cooperative concurrency with PHP Fibers |
| [FrankenPHP](./frankenphp/README.md) | Run a PHP application with FrankenPHP, Caddy, and Redis |
| [Guzzle](./guzzle/README.md) | Make synchronous and asynchronous HTTP requests with Guzzle |
| [OPcache](./opcache/README.md) | Configure and inspect PHP OPcache and preloading |
| [Raw](./raw/README.md) | Build a framework-free PHP application using PSR conventions |
| [Rector](./rector/README.md) | Refactor and upgrade PHP code automatically with Rector |
| [Router](./router/README.md) | Implement a lightweight PHP router using PSR conventions |
| [Session](./session/README.md) | Compare filesystem, Memcached, Redis, and Dragonfly sessions |
| [Twig](./twig/README.md) | Render PHP applications with Twig templates |
| [VSCode PHP](./vscode-php/README.md) | Configure containerized PHP validation in Visual Studio Code |
| [Xdebug](./xdebug/README.md) | Debug and profile PHP applications with Xdebug |

## Requirements

- Docker with Compose v2
- GNU Make

Each lab has its own README and Makefile. Run `make help` inside a lab to see its commands.
