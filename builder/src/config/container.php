<?php

use DI\ContainerBuilder;
use App\Api\ApiClient;

require __DIR__ . '/../vendor/autoload.php';

$builder = new ContainerBuilder();

$builder->addDefinitions([
    ApiClient::class => DI\create()->constructor('https://remote-api.example.com'),
]);

// Enable PHP 8 Attributes support
// $builder->useAutowiring(true);
$builder->useAttributes(true);

return $builder->build();
