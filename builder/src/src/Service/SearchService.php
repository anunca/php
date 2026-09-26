<?php

declare(strict_types=1);

namespace App\Service;

use App\Api\ApiClient;
use App\Query\SqlQuery;
use App\Query\SqlQueryBuilder;
use App\Dto\SearchResultDto;
use DI\Attribute\Inject;

class SearchService
{
    #[Inject]
    private SqlQueryBuilder $builder;

    #[Inject]
    private ApiClient $api;

    public function search(SqlQuery $query): array
    {
        $sql = $this->builder->build($query);
        $searchResults = $this->api->searchBySql($sql);
        dump($searchResults);

        $finalResults = [];
        foreach ($searchResults['ids'] as $id) {
            $detail = $this->api->getDetailsById($id);
            dump($detail);
            $finalResults[] = new SearchResultDto($id, $detail['name'], $detail);
        }

        return $finalResults;
    }
}
