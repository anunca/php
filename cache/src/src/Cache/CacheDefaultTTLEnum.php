<?php

declare(strict_types=1);

namespace Demo\Cache\Cache;
enum CacheDefaultTTLEnum: int
{
    case Min = 60;
    case Max = 86400;
    case Default = 3600;
}
