<?php

namespace App\Router;

use App\Router\Route;

class Router
{
  public function __construct(private ?string $requestUri = null, private array $controllers = [], private bool $routeFound = false)
  {
    $this->requestUri = strtok($this->requestUri, '?');
  }

  public function handleRequest(): void
  {
    foreach ($this->controllers as $controller) {
      $reflectionClass = new \ReflectionClass($controller);
      $methods = $reflectionClass->getMethods();

      foreach ($methods as $method) {
        // Check if the method has the Route attribute
        $attributes = $method->getAttributes(Route::class);
        if (!empty($attributes)) {
          $attribute = $attributes[0]->newInstance();
          $path = $attribute->path;

          // Match the route path with the request URI
          if ($path === $this->requestUri && $method->isPublic()) {
            // Call the method
            $controller->{$method->getName()}();
            $this->routeFound = true;
            exit;
          }
        }
      }
    }

    $this->handle404();
  }

  private function handle404(): void
  {
    if (!$this->routeFound) {
      http_response_code(404);
      echo "404 Not Found";
    }
  }
}
