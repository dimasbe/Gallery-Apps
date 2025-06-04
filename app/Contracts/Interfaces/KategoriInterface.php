<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FilterInterface;

interface KategoriInterface extends BaseInterface
{
    // Anda dapat menambahkan metode spesifik untuk Kategori jika diperlukan,
    // jika tidak, antarmuka Eloquent mencakup operasi CRUD.
    // FilterInterface akan digunakan untuk metode seperti filterBySubKategori.
    public function filterBySubKategori(string $subKategori): mixed;
}
