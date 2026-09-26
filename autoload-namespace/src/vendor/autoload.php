<?php

spl_autoload_register(function ($className){

  $filename = dirname(__FILE__) . '/../src/' . str_replace(['Demo\\App\\', '\\'], ['', '/'], $className) . '.php';

  if(!file_exists($filename)){
    return false;
  }

  require_once($filename);
});
