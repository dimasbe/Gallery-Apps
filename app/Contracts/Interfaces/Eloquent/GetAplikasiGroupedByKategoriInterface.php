<?php

namespace App\Contracts\Interfaces\Eloquent;

use Illuminate\Support\Collection;

interface GetAplikasiGroupedByKategoriInterface
{
    public function getAplikasiGroupedByKategori(int $month, int $year): Collection;
}
