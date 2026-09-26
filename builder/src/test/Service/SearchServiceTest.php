<?php

use PHPUnit\Framework\TestCase;
use App\Service\SearchService;
use App\Query\SqlQuery;
use App\Query\SqlQueryBuilder;
use App\Api\ApiClient;

class SearchServiceTest extends TestCase
{
    public function testSearch()
    {
        $builder = new SqlQueryBuilder();

        $apiMock = $this->createMock(ApiClient::class);
        $apiMock->method('searchBySql')->willReturn(['ids' => [1]]);
        $apiMock->method('getDetailsById')->willReturn(['name' => 'Test Name']);

        $service = new SearchService();
        $reflection = new ReflectionClass($service);
        $reflection->getProperty('builder')->setValue($service, $builder);
        $reflection->getProperty('api')->setValue($service, $apiMock);

        $query = new SqlQuery(['id', 'name'], 'users');

        $results = $service->search($query);

        $this->assertCount(1, $results);
        $this->assertEquals('Test Name', $results[0]->name);
    }
}
