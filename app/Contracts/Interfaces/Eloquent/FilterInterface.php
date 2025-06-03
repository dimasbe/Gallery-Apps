<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FilterInterface
{
    /**
     * Handle filtering data based on a given criteria.
     *
     * @param array $criteria
     * @return mixed
     */
    public function filter(array $criteria): mixed;
}