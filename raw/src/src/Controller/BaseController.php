<?php

namespace App\Controller;

use App\Container\ContainerInterface;
use App\Container\Container;
use App\Repository\TodoRepository;
use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BaseController
{
  public function __construct(protected ?ContainerInterface $container = null, protected ?Environment $twig = null)
  {
    $this->container = new Container();
    $todo = TodoRepository::getInstance();
    $this->container->set(TodoRepository::class, $todo);

    // Specify the directory where your Twig templates are located
    $loader = new FilesystemLoader(__DIR__ . '/../../templates');

    // Create a Twig environment
    $this->twig = new Environment($loader);
  }
}
