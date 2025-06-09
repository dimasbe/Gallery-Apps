<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;
use Illuminate\Support\Collection; // Pastikan ini di-import

interface AplikasiInterface extends BaseInterface, SearchInterface
{
    /**
     * Ambil sejumlah aplikasi paling populer berdasarkan jumlah kunjungan.
     *
     * @param int $limit Jumlah aplikasi yang ingin diambil.
     * @return \Illuminate\Support\Collection
     */
    public function getPopularApps(int $limit);
}