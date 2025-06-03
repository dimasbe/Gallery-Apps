<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;

interface KategoriInterface extends BaseInterface
{
    /**
     * Ambil semua kategori berdasarkan sub_kategori (aplikasi atau berita).
     *
     * @param string $subKategori
     * @return mixed
     */
    public function getBySubKategori(string $subKategori);
}
