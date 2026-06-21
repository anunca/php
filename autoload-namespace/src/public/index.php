<?php

require_once dirname(__FILE__) .'/../vendor/autoload.php';

use \Demo\App\Kernel;
use \Demo\App\Controller\User;
use \Demo\App\Entity\User as EntityUser;

$Kernel = new Kernel();
var_dump($Kernel);

$User = new User();
var_dump($User);

$EntityUser = new EntityUser();
var_dump($EntityUser);
