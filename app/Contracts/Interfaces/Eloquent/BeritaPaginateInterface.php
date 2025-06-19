<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;

interface BeritaPaginateInterface
{
    public function getAllPaginated(?int $perPage = 10, ?int $kategoriId = null, ?string $search = null): LengthAwarePaginator;
}
