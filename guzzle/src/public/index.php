<?php

require_once dirname(__FILE__) .'/../vendor/autoload.php';

use \Demo\Guzzle\Kernel;
use \Demo\Guzzle\Cache;

$Kernel = new Kernel();

echo 'asyncRequestWithPromise<br>';
$Kernel->asyncRequestWithPromise();

echo '<br>';

echo 'asyncRequestWithConcurrencyPromise<br>';
$Kernel->asyncRequestWithConcurrencyPromise();

echo '<br>';

echo 'asyncRequestWithConcurrencyPromisePool<br>';
$Kernel->asyncRequestWithConcurrencyPromisePool();

$Cache = Cache::getInstance();
$Cache->set('foo', 'bar');
dump($Cache->get('foo'));
// $Cache->delete('foo');
