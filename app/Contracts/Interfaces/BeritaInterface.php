<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\{
    BaseInterface,
    //SearchInterface,
    FindByIdInterface,
    PaginateInterface,
    BeritaPaginateInterface 
};

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

interface BeritaInterface extends
    BaseInterface,
    //SearchInterface,
    FindByIdInterface,
    PaginateInterface,
    BeritaPaginateInterface 
{
    public function getAllWithKategori(int $perPage = 10, string $keyword = null): LengthAwarePaginator;

    public function getLatest(int $limit = 3): Collection;
}
