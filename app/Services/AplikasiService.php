<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage; // Penting untuk operasi file
use App\Contracts\Interfaces\AplikasiInterface;
use App\Contracts\Interfaces\FotoAplikasiInterface; // Tambahkan ini jika Anda menggunakannya di konstruktor FotoAplikasiService
use App\Services\FotoAplikasiService;
use App\Services\LogoAplikasiService;

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