<?php

declare(strict_types=1);

namespace App\Dto;

class SqlQueryDto
{
    public array $select;
    public string $from;
    public array $where;
    public array $groupby;

    public static function fromArray(array $data): self
    {
        $dto = new self();
        $dto->select  = $data['select'] ?? [];
        $dto->from    = $data['from'] ?? '';
        $dto->where   = $data['where'] ?? [];
        $dto->groupby = $data['groupby'] ?? [];

        return $dto;
    }
}
