<?php

declare(strict_types=1);

require __DIR__ . '/../vendor/autoload.php';

use App\Entity\UserEntity;
use App\Query\SqlQuery;
use App\Service\SearchService;

$container = require __DIR__ . '/../config/container.php';

$request = <<<EOF
{
  "sqlquery": {
    "select": ["id", "name"],
    "from": "users",
    "where": {
      "active": 1,
      "country": "FR"
    },
    "groupby": ["country"]
  }
}
EOF;

$user = $container->get(UserEntity::class);
// dd($container);

$data = json_decode($request, true);
// dump($data);

try {
    $query = SqlQuery::fromArray($data['sqlquery']);
    dump($query);

    /** @var SearchService $service */
    $service = $container->get(SearchService::class);
    dump($service);

    $results = $service->search($query);
    dump($results);

    dump(['results' => $results]);
} catch (Throwable $e) {
    dump($e);
}
