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
     * @return string Path file yang disimpan
     */
    public function store(UploadedFile $file): string
    {
        return $file->store('logo_aplikasi', 'public');
    }

    /**
     * Update logo aplikasi: hapus logo lama, lalu simpan logo baru.
     *
     * @param UploadedFile $file
     * @param string|null $oldPath
     * @return string Path file yang disimpan
     */
    public function update(UploadedFile $file, ?string $oldPath): string
    {
        if ($oldPath) {
            Storage::disk('public')->delete($oldPath);
        }

        return $this->store($file);
    }
}
