<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

use Symfony\Component\Cache\Adapter\RedisAdapter;

class Redis
{
  private static ?Redis $instance = null;

  private function __construct(
    private ?string $dsn = null,
    private ?array $options = [],
  ) {
    $redisHost = getenv('REDIS_HOST') ?: 'redis';
    $redisPort = getenv('REDIS_PORT') ?: '6379';

    $this->dsn = "redis://$redisHost:$redisPort";
    $this->options = [
      'lazy' => false,
      'persistent' => 0,
      'persistent_id' => null,
      'tcp_keepalive' => 0,
      'timeout' => 1,
      'read_timeout' => 0,
      'retry_interval' => 0,
    ];
  }

  public static function getInstance(): Redis
  {
    if (self::$instance === null) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  public function initAdapter(): RedisAdapter
  {
    $redisConnection = RedisAdapter::createConnection($this->dsn, $this->options);
    return new RedisAdapter($redisConnection);
  }
}
