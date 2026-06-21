<?php

declare(strict_types=1);

namespace App\Query;

class SqlQueryBuilder
{
    public function build(SqlQuery $query): string
    {
        $sql = 'SELECT ' . implode(', ', $query->select);
        $sql .= ' FROM ' . $query->from;

        if (!empty($query->where)) {
            $conditions = [];
            foreach ($query->where as $column => $value) {
                $safeValue = is_numeric($value) ? $value : "'" . addslashes($value) . "'";
                $conditions[] = "$column = $safeValue";
            }
            $sql .= ' WHERE ' . implode(' AND ', $conditions);
        }

        if (!empty($query->groupBy)) {
            $sql .= ' GROUP BY ' . implode(', ', $query->groupBy);
        }

        return $sql;
    }
}
