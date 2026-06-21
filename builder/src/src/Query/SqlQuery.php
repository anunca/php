<?php

declare(strict_types=1);

namespace App\Query;

class SqlQuery
{
    public array $select;
    public string $from;
    public array $where;
    public array $groupBy;

    public function __construct(array $select, string $from, array $where = [], array $groupBy = [])
    {
        $this->select  = $select;
        $this->from    = $from;
        $this->where   = $where;
        $this->groupBy = $groupBy;
    }

    public static function fromArray(array $data): self
    {
        if (!isset($data['select'], $data['from'])) {
            throw new \InvalidArgumentException('Missing select or from');
        }

        return new self(
            $data['select'],
            $data['from'],
            $data['where']   ?? [],
            $data['groupby'] ?? []
        );
    }
}
