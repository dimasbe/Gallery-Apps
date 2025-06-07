<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\AplikasiInterface;
use App\Services\FotoAplikasiService;
use App\Services\LogoAplikasiService;

class AplikasiService
{
    protected AplikasiInterface $aplikasi;
    protected FotoAplikasiService $fotoAplikasiService;
    protected LogoAplikasiService $logoAplikasiService;

    public function __construct(
        AplikasiInterface $aplikasi,
        FotoAplikasiService $fotoAplikasiService,
        LogoAplikasiService $logoAplikasiService
    ) {
        $this->aplikasi = $aplikasi;
        $this->fotoAplikasiService = $fotoAplikasiService;
        $this->logoAplikasiService = $logoAplikasiService;
    }

    public function createWithFotos(array $data, ?array $files = null)
    {
        return DB::transaction(function () use ($data, $files) {
            // Simpan data aplikasi (logo sudah ada di $data dari Controller)
            $aplikasi = $this->aplikasi->store($data);

            // Simpan foto lainnya jika ada
            if ($files) {
                $this->fotoAplikasiService->storeMultiple($files, $aplikasi->id);
            }

            return $aplikasi;
        });
    }

    public function updateWithFotos(int $id, array $data, ?array $files = null)
    {
        return DB::transaction(function () use ($id, $data, $files) {
            $this->aplikasi->update($id, $data);

            if ($files) {
                $this->fotoAplikasiService->updateMultiple($files, $id);
            }
        });
    }
}
