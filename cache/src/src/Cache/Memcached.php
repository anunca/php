<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

use Symfony\Component\Cache\Adapter\MemcachedAdapter;
use InvalidArgumentException;

class Memcached
{
  private static ?Memcached $instance = null;

  private function __construct(
    private ?array $servers = [],
    private ?array $options = [],
  ) {
    $memcachedServers = getenv('MEMCACHED_SERVERS') ?: 'memcached1:11212,memcached2:11212,memcached3:11212';
    $prefixKey = getenv('MEMCACHED_PREFIX_KEY') ?: 'myCompany';

    $this->servers = preg_split('/[,\s]+/', $memcachedServers);
    foreach ($this->servers as $server) {
        if (!preg_match('/^\w+:\d+$/', $server)) {
            throw new InvalidArgumentException("Invalid server format: $server");
        }
    }

    $this->options = [
      'randomize_replica_read' => true,
      'number_of_replicas' => count($this->servers),
      'serializer' => 'php',
      'prefix_key' => $prefixKey,
    ];
  }

  public static function getInstance(): Memcached
  {
    if (self::$instance === null) {
      self::$instance = new self;
    }
    return self::$instance;
  }
  
  public function initAdapter(): MemcachedAdapter
  {
    $client = MemcachedAdapter::createConnection($this->servers, $this->options);
    return new MemcachedAdapter($client);
  }
}
