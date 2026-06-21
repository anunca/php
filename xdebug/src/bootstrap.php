<?php

require_once __DIR__."/vendor/autoload.php";

use Doctrine\ORM\Tools\Setup;
use Doctrine\ORM\EntityManager;

$paths = array(__DIR__."/src/Entity");

// $isDevMode = false;
$isDevMode = true;
$proxyDir = null;
$cache = null;
$useSimpleAnnotationReader = false;

// the connection configuration
$dbParams = array(
  'driver'   => 'pdo_mysql',
  'host'   => 'db',
  'charset'   => 'utf8',
  'user'     => getEnv('MYSQL_USER'),
  'password' => getEnv('MYSQL_ROOT_PASSWORD'),
  'dbname'   => getEnv('MYSQL_DATABASE'),
);
// $dbParams = array(
//   'driver' => 'pdo_sqlite',
//   'path' => __DIR__ . '/db/db.sqlite',
// );

$config = Setup::createAnnotationMetadataConfiguration($paths, $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);
$entityManager = EntityManager::create($dbParams, $config);
