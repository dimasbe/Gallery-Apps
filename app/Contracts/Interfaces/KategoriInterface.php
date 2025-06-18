<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\GetAplikasiGroupedByKategoriInterface;
use Illuminate\Database\Eloquent\Builder;
// use App\Contracts\Interfaces\Eloquent\FilterInterface;

interface KategoriInterface extends BaseInterface, GetAplikasiGroupedByKategoriInterface
{
    public function filterBySubKategori(string $subKategori): mixed;
    public function getByNameWithAplikasi(string $namaKategori): mixed; 
    public function query(): Builder;
}