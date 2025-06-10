<?php

namespace App\Contracts\Interfaces;

use App\Contracts\Interfaces\Eloquent\BaseInterface;
use App\Contracts\Interfaces\Eloquent\FindInterface;
use App\Contracts\Interfaces\Eloquent\GetByUserIdInterface;
use App\Contracts\Interfaces\Eloquent\SearchInterface;

interface AplikasiInterface extends BaseInterface, SearchInterface, FindInterface, GetByUserIdInterface
{
    /**
     * Ambil sejumlah aplikasi paling populer berdasarkan jumlah kunjungan.
     *
     * @param int $limit Jumlah aplikasi yang ingin diambil.
     * @return \Illuminate\Support\Collection
     */
    public function getPopularApps(int $limit);
}