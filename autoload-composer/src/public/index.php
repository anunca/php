<?php

require_once dirname(__FILE__) .'/../vendor/autoload.php';

use \GuzzleHttp\Client;

$client = new Client();
var_dump($client);

use \Demo\App\Controller\User;
use \Demo\App\Entity\User as EntityUser;

$Kernel = new \Demo\App\Kernel();
var_dump($Kernel);

$User = new User();
var_dump($User);

$EntityUser = new EntityUser();
var_dump($EntityUser);
