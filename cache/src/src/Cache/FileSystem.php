<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

use Symfony\Component\Cache\Adapter\FilesystemAdapter;

class FileSystem
{
  private static ?FileSystem $instance = null;

  private function __construct()
  {
  }

  public static function getInstance(): FileSystem
  {
    if (self::$instance === null) {
      self::$instance = new self;
    }
    return self::$instance;
  }

  public function initAdapter(): FilesystemAdapter
  {
    $cacheDirectory = getenv('FILE_SYSTEM_CACHE_DIRECTORY') ?: '/tmp/var/cache/file.system';
    return new FilesystemAdapter('', 0, $cacheDirectory);
  }
}
