<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Component\Cache\Adapter\PhpArrayAdapter;

class Opcache
{
  private static ?Opcache $instance = null;

  private function __construct()
  {
  }

  public static function getInstance(): Opcache
  {
    if (self::$instance === null) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  public function initAdapter(): PhpArrayAdapter
  {
    $cacheDirectory = getenv('OPCACHE_CACHE_DIRECTORY') ?: '/tmp/var/cache/op.cache';
    return new PhpArrayAdapter($cacheDirectory, new FilesystemAdapter());
  }
}
