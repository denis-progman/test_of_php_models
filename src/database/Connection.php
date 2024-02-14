<?php

namespace App\database;

class Connection
{
    public function __construct(protected array $array)
    {
    }

    public function runQuery(string $query) : array
    {
        return $this->array;
    }

}
