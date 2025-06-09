<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Penting untuk operasi file
use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface; // Tambahkan ini jika Anda menggunakannya di konstruktor FotoAplikasiService
use App\Services\FotoAplikasiService;
use App\Services\LogoAplikasiService;
use Exception; // Untuk menangani exception

class AplikasiService
{
    protected AplikasiInterface $aplikasiRepository; // Menggunakan 'aplikasiRepository' agar lebih jelas
    protected FotoAplikasiService $fotoAplikasiService;
    protected LogoAplikasiService $logoAplikasiService;

    public function __construct(
        AplikasiInterface $aplikasi,
        FotoAplikasiService $fotoAplikasiService,
        LogoAplikasiService $logoAplikasiService
    ) {
        $this->aplikasiRepository = $aplikasi; // Sesuaikan penamaan
        $this->fotoAplikasiService = $fotoAplikasiService;
        $this->logoAplikasiService = $logoAplikasiService;
    }

    /**
     * Create a new application with its logo and photos.
     * The logo path should already be in $data.
     *
     * @param array $data Validated application data, including logo path.
     * @param array|null $files Array of UploadedFile objects for path_foto.
     * @return \App\Models\Aplikasi
     * @throws \Exception
     */
    public function createWithFotos(array $data, ?array $files = null)
    {
        return DB::transaction(function () use ($data, $files) {
            // $data sudah mengandung 'logo' yang sudah di-store oleh LogoAplikasiService di controller
            $aplikasi = $this->aplikasiRepository->store($data); // Asumsi AplikasiInterface memiliki metode 'store'

            // Simpan foto lainnya jika ada
            if ($files) {
                // Asumsi FotoAplikasiService memiliki metode storeMultiple yang menerima array file dan id_aplikasi
                $this->fotoAplikasiService->storeMultiple($files, $aplikasi->id);
            }

            return $aplikasi;
        });
    }

    /**
     * Update an existing application and its logo and photos.
     *
     * @param int $id Application ID.
     * @param array $data Validated application data.
     * @param \Illuminate\Http\UploadedFile|null $logoFile New logo file to upload.
     * @param array|null $newFotoFiles New photo files to add.
     * @return bool
     * @throws \Exception
     */
    public function updateWithFotos(int $id, array $data, $logoFile = null, ?array $newFotoFiles = null): bool
    {
        return DB::transaction(function () use ($id, $data, $logoFile, $newFotoFiles) {
            $aplikasi = $this->aplikasiRepository->show($id); // Asumsi AplikasiInterface memiliki metode 'show'

            // Handle logo update if a new logo file is provided
            if ($logoFile) {
                // Hapus logo lama jika ada
                if ($aplikasi->logo) {
                    $this->logoAplikasiService->delete($aplikasi->logo); // Asumsi LogoAplikasiService memiliki metode 'delete'
                }
                // Simpan logo baru dan update path di data
                $data['logo'] = $this->logoAplikasiService->store($logoFile); // Asumsi LogoAplikasiService memiliki metode 'store'
            } else {
                // Jika tidak ada logo baru, dan tidak ada di $data (misalnya tidak diubah), jangan ikut di update
                // Jika $data['logo'] diset null dari request, itu akan meng-handle penghapusan logo (jika database nullable)
                unset($data['logo']); // Hindari overwrite jika tidak ada file baru dan tidak ada perubahan logo
            }

            // Update data aplikasi di database
            $updated = $this->aplikasiRepository->update($id, $data); // Asumsi AplikasiInterface memiliki metode 'update'

            // Tambahkan foto-foto baru jika ada
            if ($newFotoFiles) {
                // Asumsi FotoAplikasiService memiliki metode storeMultiple yang menerima array file dan id_aplikasi
                $this->fotoAplikasiService->storeMultiple($newFotoFiles, $id);
            }

            return $updated;
        });
    }

    /**
     * Delete an application and its associated files (logo and photos).
     *
     * @param int $aplikasiId
     * @return bool|null
     * @throws \Exception
     */
    public function deleteAplikasiAndFiles(int $aplikasiId): ?bool
    {
        return DB::transaction(function () use ($aplikasiId) {
            $aplikasi = $this->aplikasiRepository->show($aplikasiId); // Ambil data aplikasi

            if (!$aplikasi) {
                return false; // Aplikasi tidak ditemukan
            }

            // 1. Hapus semua foto aplikasi terkait menggunakan FotoAplikasiService
            $this->fotoAplikasiService->deleteAllByAplikasiId($aplikasiId);


            // 2. Hapus logo aplikasi menggunakan LogoAplikasiService
            if ($aplikasi->logo) {
                $this->logoAplikasiService->delete($aplikasi->logo); // Asumsi LogoAplikasiService memiliki metode 'delete'
            }

            // 3. Hapus entri aplikasi dari database
            // PENTING: Pastikan aplikasiRepository memiliki metode 'delete' (bukan 'destroy')
            // Sesuai diskusi terakhir, BaseRepository Anda memiliki 'delete'
            $result = $this->aplikasiRepository->delete($aplikasiId); // <<< PASTIKAN INI 'delete'

            return $result;
        });
    }
}