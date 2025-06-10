<?php

namespace App\Contracts\Interfaces\Eloquent;

interface GetByUserIdInterface
{
    public function getByUserId(int|string $userId): mixed;

}