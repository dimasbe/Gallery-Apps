<?php

namespace App\Services;

use App\Contracts\Interfaces\KategoriInterface;

class DashboardService
{
    protected KategoriInterface $kategoriRepository;

    public function __construct(KategoriInterface $kategoriRepository)
    {
        $this->kategoriRepository = $kategoriRepository;
    }

    public function getChartData(int $month, int $year): array
    {
        $data = $this->kategoriRepository->getAplikasiGroupedByKategori($month, $year);

        return [
            'labels' => $data->pluck('nama')->toArray(),
            'data' => $data->pluck('aplikasi_count')->toArray(),
        ];
    }
}
