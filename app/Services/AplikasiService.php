<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\AplikasiInterface;
use App\Services\FotoAplikasiService;
use App\Services\LogoAplikasiService;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

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
            $aplikasi = $this->aplikasi->store($data);

            if ($files) {
                $this->fotoAplikasiService->storeMultiple($files, $aplikasi->id);
            }

            return $aplikasi;
        });
    }

    public function updateWithFotos(int $id, array $data, ?array $files = null, array $existingPhotoIds = [], array $deletedPhotoIds = [])
    {
        return DB::transaction(function () use ($id, $data, $files, $existingPhotoIds, $deletedPhotoIds) {
            $aplikasi = $this->aplikasi->find($id);
            $oldLogoPath = $aplikasi->path_logo ?? null;

            // Update logo jika ada file baru
            if (isset($data['path_logo']) && $data['path_logo'] instanceof \Illuminate\Http\UploadedFile) {
                $data['path_logo'] = $this->logoAplikasiService->update($data['path_logo'], $oldLogoPath);
            } else {
                unset($data['path_logo']);
            }

            $data['status_verifikasi'] = 'pending';
            $this->aplikasi->update($id, $data);

            // 🔴 HAPUS FOTO-FOTO YANG DISETUJUI USER
            foreach ($deletedPhotoIds as $fotoId) {
                $this->fotoAplikasiService->deleteById($fotoId);
            }

            // Tambahkan foto baru dan pertahankan yang lama
            $this->fotoAplikasiService->updateMultiple($files, $id, $existingPhotoIds);

            return $this->aplikasi->find($id);
        });
    }

    public function deleteAplikasiAndFiles(int $aplikasiId): bool
    {
        DB::beginTransaction();

        try {
            $aplikasi = $this->aplikasi->find($aplikasiId);

            if (!$aplikasi) {
                throw new Exception("Aplikasi dengan ID {$aplikasiId} tidak ditemukan.");
            }

            $this->fotoAplikasiService->deleteMultipleByAplikasiId($aplikasi->id);

            if ($aplikasi->logo && Storage::disk('public')->exists($aplikasi->logo)) {
                Storage::disk('public')->delete($aplikasi->logo);
            }

            $this->aplikasi->delete($aplikasi->id);

            DB::commit();

            return true;
        } catch (Exception $e) {
            DB::rollBack();
            Log::error("Failed to delete application with ID: {$aplikasiId}. Error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw new Exception("Gagal menghapus aplikasi dan file terkait: " . $e->getMessage());
        }
    }
}
