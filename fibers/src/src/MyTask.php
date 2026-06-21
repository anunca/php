<?php

namespace Demo\Fiber;

use DateTime;
use Fiber;

class MyTask
{
  public function __construct(
    private readonly array $urls,
  ) {
  }

  public function run()
  {
    return function() {
      $results = [];
      foreach ($this->urls as $url) {
        echo "Hello from the Fiber...\n";
        Fiber::suspend();
        sleep(1);
        $date = (new DateTime())->format('Y-m-d H:i:s.u');
        $results[] = [
          'date' => $date,
          'headers' => get_headers($url),
        ];
      }
      return $results;
    };
  }
}
