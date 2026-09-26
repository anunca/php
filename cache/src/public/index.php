<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use Demo\Cache\Controller\DefaultController;

(new DefaultController)->indexAction();
