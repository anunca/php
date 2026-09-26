<?php

require __DIR__ . '/../vendor/autoload.php';

use App\Controller\TodoController;
use App\Controller\RandomController;
use App\Controller\PhpinfoController;
use App\Router\Router;

try {
  $requestUri = $_SERVER['REQUEST_URI'];
  $controllers = [
    new TodoController(),
    new RandomController(),
    new PhpinfoController(),
  ];

  $router = new Router($requestUri, $controllers);
  $router->handleRequest();
} catch (\Throwable $th) {
  throw $th;
}
