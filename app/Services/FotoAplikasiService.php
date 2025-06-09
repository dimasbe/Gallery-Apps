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
            $path = $file->store('foto_aplikasi', 'public');

            FotoAplikasi::create([
                'id_aplikasi' => $idAplikasi,
                'path_foto' => $path,
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
        if (!$files || !is_array($files) || count($files) === 0) return;

        // Hapus foto lama dari storage dan database
        $fotoLama = FotoAplikasi::where('id_aplikasi', $idAplikasi)->get();
        foreach ($fotoLama as $foto) {
            Storage::disk('public')->delete($foto->path_foto);
            $foto->delete();
        }

        // Simpan foto baru
        $this->storeMultiple($files, $idAplikasi);
    }
}
