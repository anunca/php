# session
## overview
- [doc](#doc)
- [install](#install)
- [notes](#notes)
## doc
- [Fylesystem](doc/fylesystem.md)
- [Memcached](doc/memcached.md)
- [Redis](doc/redis.md)
- [Dragonfly](doc/dragonfly.md)
- Benchmark
    - [simple](doc/benchmark/simple.md)
    - [blocking session](doc/benchmark/blocking-session.md)
## install
```sh
make help
```
## notes
### simple
```sh
ab -n 10000 -c 10 'http://localhost/'
```
- check redis values
```sh
docker exec -it test-redis-1 redis-cli --scan
```
- check dragonfly values
```sh
docker exec -it test-dragonfly-1 redis-cli --scan
```
### blocking session
```sh
ab -n 10 -c 5 -C "PHPSESSID=$PHPSESSID" http://localhost/benchmark/blocking.php
```
- set you own session id to test blocking I/O
```sh
PHPSESSID=4cgiulmff9ome6fd3bio168km7
ab -n 10 -c 5 -C "PHPSESSID=$PHPSESSID" http://localhost/benchmark/blocking.php
```
##
- **Filesystem**: Simple, but not suitable for large-scale applications.
- **Memcached**: Fast and scalable, but data is volatile.
- **Redis**: Fast, persistent, and highly scalable. Ideal for large applications.
- **Dragonfly**: Modern and efficient, compatible with Redis and Memcached APIs. Excellent for high-performance needs.
##
For large loads and performance, Redis and Dragonfly are the most robust solutions, with Redis being more established and Dragonfly offering newer optimizations.