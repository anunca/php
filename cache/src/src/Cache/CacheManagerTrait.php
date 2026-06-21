<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

use Demo\Cache\Cache\CacheAdapterEnum;
use Demo\Cache\Cache\CacheDefaultTTLEnum;
use Demo\Cache\Cache\CacheManager;
use Demo\Cache\Cache\FileSystem;
use Demo\Cache\Cache\Memcached;
use Demo\Cache\Cache\Opcache;
use Demo\Cache\Cache\Redis;
use Symfony\Component\Cache\Adapter\AdapterInterface;
use InvalidArgumentException;

trait CacheManagerTrait
{
  public function __construct(
    protected ?CacheManager $cacheManager = null,
    private ?string $cacheAdapter = null,
    private ?int $defaultTtl = 0,
  ) {
    $this->cacheAdapter = getenv('CACHE_ADAPTER') ?: CacheAdapterEnum::FileSystem->value;
    $defaultTtl = (int) getenv('CACHE_TTL') ?: CacheDefaultTTLEnum::Default->value;
  }

  public function cacheManagerInit()
  {
    $this->cacheManager = new CacheManager(
      $this->getAdapterInterface(),
      $this->defaultTtl,
      $this->cacheAdapter,
    );
  }

  private function getAdapterInterface(): AdapterInterface {
    return match ($this->cacheAdapter) {
      CacheAdapterEnum::Memcached->value => Memcached::getInstance()->initAdapter(),
      CacheAdapterEnum::Redis->value => Redis::getInstance()->initAdapter(),
      CacheAdapterEnum::Opcache->value => Opcache::getInstance()->initAdapter(),
      CacheAdapterEnum::FileSystem->value => FileSystem::getInstance()->initAdapter(),
      default => throw new InvalidArgumentException('Invalid cache adapter specified in configuration.')
    };
  }
}
