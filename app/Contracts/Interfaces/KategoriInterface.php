<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
// use App\Contracts\Interfaces\Eloquent\FilterInterface;

interface KategoriInterface extends BaseInterface
{
    public function filterBySubKategori(string $subKategori): mixed;
    public function getByNameWithAplikasi(string $namaKategori): mixed; 
}