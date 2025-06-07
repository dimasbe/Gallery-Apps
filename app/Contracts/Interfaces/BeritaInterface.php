<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\{
    BaseInterface,
    SearchInterface,
    FindByIdInterface,
    PaginateInterface,
    BeritaPaginateInterface
};

use Illuminate\Database\Eloquent\Collection;

interface BeritaInterface extends
    BaseInterface,
    SearchInterface,
    FindByIdInterface,
    PaginateInterface, // Umum
    BeritaPaginateInterface // Khusus berita
{
    public function getAllWithKategori();

    public function getLatest(int $limit = 3): Collection;
}
