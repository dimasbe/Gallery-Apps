<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FilterInterface;

interface KategoriInterface extends BaseInterface
{
     // You can add specific methods for Kategori if needed,
    // otherwise, the Eloquent interfaces cover CRUD operations.
    // The FilterInterface would be for methods like filterBySubKategori.
    public function filterBySubKategori(string $subKategori): mixed;
}
