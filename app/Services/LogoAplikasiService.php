<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class LogoAplikasiService
{
    /**
     * Simpan logo aplikasi ke storage.
     *
     * @param UploadedFile $file
     * @return string Path file yang disimpan (relatif ke disk 'public')
     */
    public function store(UploadedFile $file): string
    {
        return $file->store('logo_aplikasi', 'public');
    }

    /**
     * Update logo aplikasi: hapus logo lama, lalu simpan logo baru.
     *
     * @param UploadedFile $file
     * @param string|null $oldPath Path logo lama (relatif ke disk 'public')
     * @return string Path file yang disimpan
     */
    public function update(UploadedFile $file, ?string $oldPath): string
    {
        if ($oldPath) {
            $this->delete($oldPath); // Panggil metode delete internal
        }

        return $this->store($file);
    }

    /**
     * Hapus satu file logo dari storage.
     *
     * @param string $path Path file logo relatif dari disk 'public'.
     * @return bool True jika berhasil dihapus, false jika file tidak ditemukan atau gagal.
     */
    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }
}