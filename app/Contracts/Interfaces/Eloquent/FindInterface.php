<?php

namespace App\Contracts\Interfaces\Eloquent;

interface FindInterface
{
    public function find(int $data): mixed;
}