<?php

declare(strict_types=1);

namespace Demo\Cache\Controller;

class DefaultController extends BaseController
{
    public function __construct()
    {
        parent::__construct();
    }

    public function indexAction()
    {
        $stringKey = 'foo';
        $string = $this->cacheManager->get($stringKey);
        if ($string === false) {
            $string = 'bar';
            $this->cacheManager->set($stringKey, $string);
        }

        $stdClassKey = 'stdClass';
        $stdClass = $this->cacheManager->get($stdClassKey);
        if ($stdClass === false) {
            $stdClass = new \stdClass;
            $stdClass->foo = 'bar';
            $this->cacheManager->set($stdClassKey, $stdClass);
        }

        $arrayKey = 'array';
        $array = $this->cacheManager->get($arrayKey);
        if ($array === false) {
            $array = ['foo'=> 'bar'];
            $this->cacheManager->set($arrayKey, $array);
        }

        echo($string);
        echo("<br>");
        var_dump($stdClass);
        echo("<br>");
        var_dump($array);
        echo("<br>");
        echo('get all by keys');
        echo("<br>");
        foreach($this->cacheManager->getAll([$stringKey, $stdClassKey, $arrayKey]) as $key => $value) {
            echo($key);
            echo("<br>");
            var_dump($value);
            echo("<br>");
        }
    }
}
