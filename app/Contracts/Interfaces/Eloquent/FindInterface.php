<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FindInterface
{
    /**
     * Find a model by its primary key.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find(mixed $id): mixed;
}