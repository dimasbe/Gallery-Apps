<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;

interface PaginateInterface
{
    public function paginate(int $pagination = 10): LengthAwarePaginator;
}