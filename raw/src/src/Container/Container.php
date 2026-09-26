<?php

namespace App\Container;

use App\Container\ContainerInterface;

class Container implements ContainerInterface
{
    protected $instances = [];

    public function get($id)
    {
        if (!$this->has($id)) {
            throw new \Exception("Service '$id' not found in container.");
        }

        return $this->instances[$id];
    }

    public function has($id)
    {
        return isset($this->instances[$id]);
    }

    public function set($id, $instance)
    {
        $this->instances[$id] = $instance;
    }
}
