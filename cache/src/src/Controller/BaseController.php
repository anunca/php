<?php

declare(strict_types=1);

namespace Demo\Cache\Controller;

use Demo\Cache\Cache\CacheManagerTrait;

class BaseController
{
  use CacheManagerTrait {
    __construct as private initializeCacheConfiguration;
  }

  public function __construct()
  {
    $this->initializeCacheConfiguration();
    $this->cacheManagerInit();
  }
}
