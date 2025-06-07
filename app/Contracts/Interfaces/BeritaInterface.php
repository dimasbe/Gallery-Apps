<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface; // Asumsi ini berisi metode dasar seperti store, update, delete, findById
use App\Contracts\Interfaces\Eloquent\SearchInterface; // Asumsi ini berisi metode search
use Illuminate\Database\Eloquent\Collection; // Tambahkan ini

interface BeritaInterface extends BaseInterface, SearchInterface
{
    public function getAllWithKategori();

    /**
     * Mendapatkan sejumlah berita terbaru.
     * Metode ini akan menjadi bagian dari BeritaInterface.
     *
     * @param int $limit Batasan jumlah berita yang diambil.
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getLatest(int $limit = 3): Collection; // <-- Tambahkan baris ini
}