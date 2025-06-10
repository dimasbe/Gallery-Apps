<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use App\Contracts\Interfaces\AplikasiInterface;
use App\Services\FotoAplikasiService;
use App\Services\LogoAplikasiService;
use Illuminate\Support\Facades\Storage;

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

    public function deleteAplikasiAndFiles(int $aplikasiId): bool
    {
        DB::beginTransaction(); // Start a database transaction

        try {
            // Fetch the application using the AplikasiInterface
            $aplikasi = $this->aplikasi->find($aplikasiId);

            if (!$aplikasi) {
                throw new Exception("Aplikasi dengan ID {$aplikasiId} tidak ditemukan.");
            }

            // Delete associated FotoAplikasi files from storage and database
            // This assumes FotoAplikasiService has a method to delete multiple photos by aplikasi ID
            $this->fotoAplikasiService->deleteMultipleByAplikasiId($aplikasi->id);


            // Delete the logo file from storage
            if ($aplikasi->logo && Storage::disk('public')->exists($aplikasi->logo)) {
                Storage::disk('public')->delete($aplikasi->logo);
            }

            // Delete the main Aplikasi record from the database
            $this->aplikasi->delete($aplikasi->id); // Assuming AplikasiInterface has a delete method by ID

            DB::commit(); // Commit the transaction if all operations are successful

            return true;
        } catch (Exception $e) {
            DB::rollBack(); // Rollback the transaction on error
            // Log the error for debugging purposes
            \Log::error("Failed to delete application with ID: {$aplikasiId}. Error: " . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            throw new Exception("Gagal menghapus aplikasi dan file terkait: " . $e->getMessage());
        }
    }
}