<?php

namespace App\Controller;

use App\Router\Route;
use App\Repository\TodoRepository;

class RandomController extends BaseController
{
  #[Route('/random')]
  public function index()
  {
    $r = $this->container->get(TodoRepository::class);
    $message = $r->setRandomName();

    $data = ['message' => $message];
    echo $this->twig->render('random.html.twig', $data);
  }
}
