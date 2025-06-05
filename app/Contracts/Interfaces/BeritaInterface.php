<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;

interface BeritaInterface extends BaseInterface, SearchInterface
{
    public function getAllWithKategori();

    // method khusus berita lainnya jika perlu
}
