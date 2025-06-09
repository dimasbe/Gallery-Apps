<?php

namespace App\Services;

use App\Models\FotoAplikasi;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class FotoAplikasiService
{
    /**
     * Simpan banyak foto ke storage dan database.
     *
     * @param UploadedFile[] $files
     * @param int $idAplikasi
     * @return void
     */
    public function storeMultiple(array $files, int $idAplikasi): void
    {
        foreach ($files as $file) {
            $path = $file->store('foto_aplikasi', 'public'); // Path sudah relatif ke root disk 'public'

            FotoAplikasi::create([
                'id_aplikasi' => $idAplikasi,
                'path_foto' => $path, // Simpan path ini langsung
            ]);
        }
    }

    /**
     * Update foto aplikasi: hapus semua foto lama, lalu simpan foto baru.
     *
     * @param UploadedFile[]|null $files
     * @param int $idAplikasi
     * @return void
     */
    public function updateMultiple(?array $files, int $idAplikasi): void
    {
        // Hapus foto lama dari storage dan database
        $fotoLama = FotoAplikasi::where('id_aplikasi', $idAplikasi)->get();
        foreach ($fotoLama as $foto) {
            $this->delete($foto->path_foto); // Panggil metode delete internal
            $foto->delete(); // Hapus entri dari database
        }

        // Simpan foto baru
        if ($files) { // Pastikan ada file baru sebelum memanggil storeMultiple
            $this->storeMultiple($files, $idAplikasi);
        }
    }

    /**
     * Hapus satu file foto dari storage.
     *
     * @param string $path Path file foto relatif dari disk 'public'.
     * @return bool True jika berhasil dihapus, false jika file tidak ditemukan atau gagal.
     */
    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    /**
     * Hapus semua foto (file dan entri DB) berdasarkan ID Aplikasi.
     * Metode ini akan dipanggil oleh AplikasiService.
     *
     * @param int $idAplikasi
     * @return void
     */
    public function deleteAllByAplikasiId(int $idAplikasi): void
    {
        $fotos = FotoAplikasi::where('id_aplikasi', $idAplikasi)->get();
        foreach ($fotos as $foto) {
            $this->delete($foto->path_foto); // Hapus file
            $foto->delete(); // Hapus entri database
        }
    }
}