<?php

namespace App\Contracts\Interfaces\Eloquent;

interface WhereInterface
{
    public function where(string $column, $value): mixed;
}