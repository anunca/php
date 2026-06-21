<?php

namespace App\Controller;

use App\Router\Route;

class PhpinfoController extends BaseController
{
  #[Route('/phpinfo')]
  public function index()
  {
    phpinfo();
  }
}
