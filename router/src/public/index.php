<?php

require_once '../vendor/autoload.php';

$var = [];
// dump($var)??null;
if (function_exists('dump')) {
  dump($var);
}

print getenv('PHP_VERSION').PHP_EOL;
print getenv('APP_ENV');
