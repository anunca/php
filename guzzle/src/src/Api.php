<?php

namespace Demo\Guzzle;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\Utils;
use GuzzleHttp\Promise\EachPromise;
use GuzzleHttp\Pool;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Response;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Exception\RequestException;

class Api
{
  private string $baseUri;
  private Client $client;
  private array $responses = [];
  private array $responseErrors = [];

  function __construct(string $baseUri)
  {
    $this->baseUri = $baseUri;

    $options = [
      'base_uri' => $this->baseUri,
      'timeout' => 1,
      'allow_redirects' => true,
    ];

    $this->client = new Client($options);
  }

  public function getResponseErrors(): array
  {
    return $this->responseErrors;
  }

  private function getAsync(?string $endpoint = null, array $options = []): PromiseInterface
  {
    $uri = $endpoint ? $endpoint : $this->baseUri;

    $response = $this->client->getAsync($uri, $options);

    return $response;
  }

  public function asyncRequestWithPromise(array $endpoints): array
  {
    $this->responses = [];
    $this->responseErrors = [];

    foreach ($endpoints as $key => $value) {
      $promises[$key] = $this->getAsync($value);
    }

    try {
      $this->responses = Utils::unwrap($promises);
    } catch (\Throwable $th) {
      dump($th);
      //throw $th;
      array_push($this->responseErrors, $th);
    }

    $this->responses = Utils::settle($promises)->wait();

    return $this->responses;
  }

  public function asyncRequestWithConcurrencyPromise(array $endpoints, int $concurrency): array
  {
    $this->responses = [];
    $this->responseErrors = [];

    $promises = (function () use ($endpoints) {
      foreach ($endpoints as $value) {
        yield $this->getAsync($value);
      }
    })();

    $eachPromise = new EachPromise($promises, [
      'concurrency' => $concurrency,
      'fulfilled' => function (Response $response) {
        if ($response->getStatusCode() == 200) {
          array_push($this->responses, $response);
        }
      },
      'rejected' => function ($reason) {
        array_push($this->responseErrors, $reason);
      }
    ]);

    $eachPromise->promise()->wait();

    return $this->responses;
  }

  public function asyncRequestWithConcurrencyPool(array $endpoints, int $concurrency): array
  {
    $this->responses = [];
    $this->responseErrors = [];

    $promises = function ($endpoints) {
      foreach ($endpoints as $endpoint) {
        yield new Request('GET', $endpoint);
      }
    };

    $pool = new Pool($this->client, $promises($endpoints), [
      'concurrency' => $concurrency,
      'fulfilled' => function (Response $response, $index) {
        if ($response->getStatusCode() == 200) {
          array_push($this->responses, $response);
        }
      },
      'rejected' => function (RequestException $reason, $index) {
        array_push($this->responseErrors, $reason);
      },
    ]);

    $pool->promise()->wait();

    return $this->responses;
  }
}
