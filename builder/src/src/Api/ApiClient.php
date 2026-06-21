<?php

declare(strict_types=1);

namespace App\Api;

class ApiClient
{
    public function __construct(string $baseUrl)
    {
        dump($baseUrl);
    }

    public function searchBySql(string $sql): array
    {
        $response = <<<EOF
        {
          "ids": [1,2]
        }
        EOF;

        return json_decode($response, true);
    }

    public function getDetailsById(int $id): array
    {
        $response = '';

        if($id == 1 ) {
          $response = <<<EOF
          {
              "id": 1,
              "name": "Alice",
              "email": "alice@example.com"
          }
          EOF;
        }

        if($id == 2) {
          $response = <<<EOF
          {
              "id": 2,
              "name": "Bob",
              "email": "bob@example.com"
          }
          EOF;
        }

        return json_decode($response, true);
    }
}
