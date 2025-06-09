<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Pagination\LengthAwarePaginator;

interface BeritaPaginateInterface
{
    /**
     * Ambil berita dengan paginasi dan filter kategori.
     *
     * @param int|null $perPage
     * @param int|null $kategoriId
     * @return LengthAwarePaginator
     */
    public function getAllPaginated(?int $perPage = null, ?int $kategoriId = null): LengthAwarePaginator;
}
