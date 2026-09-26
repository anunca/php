<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;

enum CacheAdapterEnum: string
{
    case Memcached = 'memcached';
    case Redis = 'redis';
    case Opcache = 'opcache';
    case FileSystem = 'filesystem';
}
