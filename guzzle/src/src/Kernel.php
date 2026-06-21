<?php

namespace Demo\Guzzle;

use Demo\Guzzle\Api;

class Kernel
{
  const URI = 'http://httpbin.org';
  private $images = [];
  private Api $api;

  function __construct()
  {
    $this->api = new Api(self::URI);

    $this->images = [
      'image' => '/image',
      'png' => '/image/png',
      'jpeg' => '/image/jpeg',
      'webp' => '/image/webp',
      // 'fatal' => '/image/fatal',
    ];
  }

  public function asyncRequestWithPromise()
  {
    $results = $this->api->asyncRequestWithPromise($this->images);

    foreach ($results as $result) {

      if (isset($result['value'])) {
        $headers = $result['value']->getHeaders();

        dump($headers['Content-Type']);
        dump($headers['Content-Length']);
      }
    }

    foreach ($this->api->getResponseErrors() as $reponseError) {
      dump($reponseError);
    }
  }

  public function asyncRequestWithConcurrencyPromise()
  {
    $results = $this->api->asyncRequestWithConcurrencyPromise($this->images, 4);

    foreach ($results as $result) {

      $headers = $result->getHeaders();

      dump($headers['Content-Type']);
      dump($headers['Content-Length']);
    }

    foreach ($this->api->getResponseErrors() as $reponseError) {
      dump($reponseError);
    }
  }

  public function asyncRequestWithConcurrencyPromisePool()
  {
    $results = $this->api->asyncRequestWithConcurrencyPool($this->images, 4);

    foreach ($results as $result) {

      $headers = $result->getHeaders();

      dump($headers['Content-Type']);
      dump($headers['Content-Length']);
    }

    foreach ($this->api->getResponseErrors() as $reponseError) {
      dump($reponseError);
    }
  }
}
