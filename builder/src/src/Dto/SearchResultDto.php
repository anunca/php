<?php

declare(strict_types=1);

namespace App\Dto;

class SearchResultDto
{
    public int $id;
    public string $name;
    public array $details;

    public function __construct(int $id, string $name, array $details)
    {
        $this->id = $id;
        $this->name = $name;
        $this->details = $details;
    }
}
