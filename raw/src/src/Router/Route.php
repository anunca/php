<?php

namespace App\Router;

use Attribute;

#[Attribute]
class Route
{
  public function __construct(public string $path)
  {
  }
}
