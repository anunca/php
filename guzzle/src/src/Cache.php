<?php

namespace Demo\Guzzle;

use Symfony\Component\Cache\Adapter\RedisAdapter;

class Cache {

  private static $instance = null;
  
  private $redisClient = null;
  private $redisCache = null;
  const TTL = 3600;

  private function __construct(){
    
    $this->redisClient = RedisAdapter::createConnection(
      'redis://redis:6379',
      [
        'lazy' => false,
        'persistent' => 0,
        'persistent_id' => null,
        'tcp_keepalive' => 0,
        'timeout' => 1,
        'read_timeout' => 0,
        'retry_interval' => 0,
        ]
    );

    $this->redisCache = new RedisAdapter($this->redisClient);
  }

  public static function getInstance(): self{

    if(null === self::$instance){
      self::$instance = new Cache();
    }

    return self::$instance;
  }

  public function set($key, $value): void{

    $item = $this->redisCache->getItem($key);
    $item->expiresAfter(self::TTL);
    $item->set($value);
    $this->redisCache->save($item);
  }

  public function get($key): ?string{

    $item = $this->redisCache->getItem($key);
    if (!$item->isHit()) {

    }
    $value = $item->get();
    
    return $value;
  }

  public function delete($key): void{
    $this->redisCache->deleteItem($key);
  }

  function __destruct(){

  }
}
