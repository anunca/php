<?php

require_once dirname(__FILE__) .'/../vendor/autoload.php';

$Kernel = new Kernel();
var_dump($Kernel);

$UserController = new UserController();
var_dump($UserController);

$UserEntity = new UserEntity();
var_dump($UserEntity);
