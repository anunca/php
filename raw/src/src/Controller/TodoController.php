<?php

namespace App\Controller;

use App\Router\Route;
use App\Repository\TodoRepository;

class TodoController extends BaseController
{
  #[Route('/')]
  public function index()
  {
    $r = $this->container->get(TodoRepository::class);
    $todos = $r->getList();

    $data = ['count' => $todos->rowCount(), 'todos' => $todos];
    echo $this->twig->render('list.html.twig', $data);
  }
}
