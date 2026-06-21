<?php

declare(strict_types=1);

namespace Demo\Fiber;

use Fiber;
use Fiber\FiberScheduler;

class Kernel
{
  const URI = 'http://httpbin.org';

  public function __construct(private ?Fiber $fiber = null, private $urls = [])
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

    // $fiber = new Fiber(fn () => (new MyTask($this->urls))->run());
    $fiber = new Fiber(function () {
      echo "Hello from the Fiber<br>";
      Fiber::suspend(['yes']);
    });
    // $fiber->resume();
    while (!$fiber->isTerminated()) {
      $fiber->start();
      // $response = $fiber->getReturn();
      // echo '<pre>' . print_r($response, true) . '</pre>';
      $fiber->resume();
      // $response = $fiber->getReturn();
      // echo '<pre>' . print_r($response, true) . '</pre>';
    }

    $end = microtime(true);

    echo "Tasks Finished in " . round($end - $start, 2) . " seconds<br>";
  }

  public function test(): void
  {
    $start = microtime(true);

    $fibers = [];
    $fibers[] = new Fiber(function(){
      sleep(1);
    });
    $fibers[] = new Fiber(function(){
      sleep(4);
    });
    
    do{
      foreach($fibers as $key => $fiber){
        if ($fiber->isSuspended() && $fiber->isTerminated() === false){
          $fiber->resume();
        }else{
          // Remove it from the fibers array
          $fiber->start();
          unset($fibers[$key]);
        }
      }
    }while(!empty($fibers));

    $end = microtime(true);

    echo "Tasks Finished in " . round($end - $start, 2) . " seconds<br>";
  }
}
