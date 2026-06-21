<?php

namespace App\Entity;

class ProfileEntity {

    public string $name;
    
    public function __construct()
    {
        $this->name = self::class;
        dump($this);
    }
}
