<?php

require_once '../vendor/autoload.php';

define('APP_ENV', getenv('APP_ENV'));

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

$loader = new FilesystemLoader('../templates/');
$option = [
  // 'debug' => false,
  // 'cache' => '../var/templates',
  'debug' => APP_ENV !== 'prod' ?? false,
  'cache' => APP_ENV == 'prod' ? '../var/templates' : false,
];
// var_dump($option);exit;
$twig = new Environment($loader, $option);
$twig->addExtension(new \Twig\Extension\DebugExtension());

echo $twig->render('home/index.html.twig', [
  'template' => 'twig',
  'templates' => [
    'smarty',
    'twig',
    'blade',
  ]
]);
