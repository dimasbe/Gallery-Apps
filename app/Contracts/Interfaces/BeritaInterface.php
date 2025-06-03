<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;

interface BeritaInterface extends BaseInterface, SearchInterface
{
    // Jika ada fungsi khusus di berita, bisa ditambahkan di sini.
}
