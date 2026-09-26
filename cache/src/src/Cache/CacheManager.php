<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

use Symfony\Component\Cache\Adapter\AdapterInterface;

class CacheManager
{
  public function __construct(
    private AdapterInterface $adapterInterface,
    private int $defaultTtl,
    private string $cacheAdapter,
  ) {
  }

  public function get(string $key): mixed
  {
    $key = md5($key);
    $item = $this->adapterInterface->getItem($key);

    if (!$item->isHit()) {
      if (!headers_sent()) {
        header('X-Cache: Miss', false);
      }
      return false;
    }

    if (!headers_sent()) {
      header('X-Cache: Hit', false);
      header('X-Cache-Type: ' . $this->cacheAdapter, false);
    }

    return $item->get();
  }

  public function set(string $key, mixed $value, ?int $ttl = 0): bool
  {
    $key = md5($key);
    $item = $this->adapterInterface->getItem($key);
    $item->set($value);

    if (!$ttl) {
      $ttl = $this->defaultTtl;
    }

    $item->expiresAfter($ttl);

    return $this->adapterInterface->save($item);
  }

  public function getAll(array $keys): iterable
  {
    foreach ($this->adapterInterface->getItems($keys) as $item) {
        if ($item !== null) {
            yield $item->getKey() => $item->get();
        }
    }
  }
}
