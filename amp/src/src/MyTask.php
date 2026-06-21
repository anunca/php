<?php

namespace Demo\Amp;

use Amp\Parallel\Worker\Task;
use Amp\Sync\Channel;
use Amp\Cancellation;
use DateTime;

class MyTask implements Task
{
  public function __construct(
    private readonly string $url,
  ) {
  }

  public function run(Channel $channel, Cancellation $cancellation): array
  {
    return [
      'date' => (new DateTime())->format('Y-m-d H:i:s.u'),
      'headers' => get_headers($this->url),
    ];
  }
}
