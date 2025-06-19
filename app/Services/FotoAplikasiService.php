<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use App\Contracts\Interfaces\FotoAplikasiInterface;

class FotoAplikasiService
{
    protected FotoAplikasiInterface $fotoAplikasi;

    public function __construct(FotoAplikasiInterface $fotoAplikasi)
    {
        $this->fotoAplikasi = $fotoAplikasi;
    }

    public function storeMultiple(array $files, int $idAplikasi): void
    {
        foreach ($files as $file) {
            $path = $file->store('foto_aplikasi', 'public');

            $this->fotoAplikasi->store([
                'id_aplikasi' => $idAplikasi,
                'path_foto' => $path,
            ]);
        }
    }

    public function updateMultiple(?array $files, int $idAplikasi, array $existingPhotoIds = []): void
    {
        $fotoLama = $this->fotoAplikasi->where('id_aplikasi', $idAplikasi);

        foreach ($fotoLama as $foto) {
            if (!in_array($foto->id, $existingPhotoIds)) {
                $this->delete($foto->path_foto);
                $this->fotoAplikasi->delete($foto->id);
            }
        }

        if ($files && is_array($files) && count($files) > 0) {
            $this->storeMultiple($files, $idAplikasi);
        }
    }

    public function deleteMultipleByAplikasiId(int $idAplikasi): void
    {
        $fotoLama = $this->fotoAplikasi->where('id_aplikasi', $idAplikasi);
        foreach ($fotoLama as $foto) {
            $this->delete($foto->path_foto);
            $this->fotoAplikasi->delete($foto->id);
        }
    }

    public function delete(string $path): bool
    {
        if (Storage::disk('public')->exists($path)) {
            return Storage::disk('public')->delete($path);
        }
        return false;
    }

    public function deleteAllByAplikasiId(int $idAplikasi): void
    {
        $fotos = $this->fotoAplikasi->where('id_aplikasi', $idAplikasi);
        foreach ($fotos as $foto) {
            $this->delete($foto->path_foto);
            $this->fotoAplikasi->delete($foto->id);
        }
    }

    public function deleteById(int $id): void
    {
        $foto = $this->fotoAplikasi->find($id);
        if ($foto) {
            $this->delete($foto->path_foto);
            $this->fotoAplikasi->delete($id);
        }
    }
}