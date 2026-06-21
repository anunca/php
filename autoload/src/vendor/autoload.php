<?php

function autoload($className){

  $filename = dirname(__FILE__) . '/../src/' . $className . '.php';
  
  if(!file_exists($filename)){
    return false;
  }

  require_once($filename);
}

spl_autoload_register('autoload');
