<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FilterInterface
{
    public function filterBy(string $criteria): mixed;
}
