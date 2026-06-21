<?php

namespace App\Entity;

class UserEntity {

    public string $name;

    public function __construct(ProfileEntity $profileEntity)
    {
        $this->name = self::class;
        dump($this);
    }
}
