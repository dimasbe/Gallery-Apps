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
            // Ambil data lama untuk mengetahui path logo sebelumnya
            $aplikasi = $this->aplikasi->find($id);
            $oldLogoPath = $aplikasi->path_logo ?? null;

            // Jika ada file logo baru dikirim
            if (isset($data['path_logo']) && $data['path_logo'] instanceof \Illuminate\Http\UploadedFile) {
                $data['path_logo'] = $this->logoAplikasiService->update($data['path_logo'], $oldLogoPath);
            } else {
                unset($data['path_logo']); // jangan update path_logo kalau tidak dikirim
            }

            // Set status_verifikasi ke pending setiap kali ada update
            $data['status_verifikasi'] = 'pending';

            // Update data aplikasi
            $this->aplikasi->update($id, $data);

            // Update foto aplikasi jika dikirim
            if ($files) {
                $this->fotoAplikasiService->updateMultiple($files, $id);
            }

            return $this->aplikasi->find($id); // kembalikan data terbaru jika perlu
        });
    }
}
