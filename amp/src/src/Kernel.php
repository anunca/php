<?php

namespace Demo\Amp;

use Amp\Future;
use Amp\Parallel\Worker;

class Kernel
{
  const URI = 'http://httpbin.org';

  public function __construct(private $urls = [])
  {
    $this->urls = [
      'image' => self::URI . '/image',
      'png' => self::URI . '/image/png',
      'jpeg' => self::URI . '/image/jpeg',
      'webp' => self::URI . '/image/webp',
      'fatal' => self::URI . '/image/fatal',
    ];
  }

  public function init(): void
  {
    $start = microtime(true);

    $executions = [];
    foreach ($this->urls as $key => $url) {
      $executions[$key] = Worker\submit(new MyTask($url));
    }

    $responses = Future\await(array_map(
      fn (Worker\Execution $e) => $e->getFuture(),
      $executions,
    ));

    foreach ($responses as $url => $response) {
      echo "Url key: $url <br>";
      echo '<pre>' . print_r($response, true) . '</pre>';
    }

    $end = microtime(true);

    echo "Tasks Finished in " . round($end - $start, 2) . " seconds<br>";
  }
}
