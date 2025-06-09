<?php

namespace App\Contracts\Interfaces\Eloquent;

interface GetByStatusInterface
{
    public function getByStatus(string $requeststatus);
}