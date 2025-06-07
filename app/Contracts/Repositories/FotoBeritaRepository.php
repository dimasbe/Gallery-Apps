<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Models\FotoBerita;
use Illuminate\Database\Eloquent\Collection;

class FotoBeritaRepository implements FotoBeritaInterface
{
    /**
     * Ambil semua data foto berita.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return FotoBerita::all();
    }

    /**
     * Simpan data foto berita baru.
     *
     * @param array $data
     * @return FotoBerita
     */
    public function store(array $data): FotoBerita
    {
        return FotoBerita::create($data);
    }

    /**
     * Perbarui data foto berita berdasarkan ID.
     *
     * @param int $id
     * @param array $data
     * @return FotoBerita
     */
    public function update(int $id, array $data): FotoBerita
    {
        $foto = FotoBerita::findOrFail($id);
        $foto->update($data);
        return $foto;
    }

    /**
     * Hapus data foto berita berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $foto = FotoBerita::findOrFail($id);
        return $foto->delete();
    }
}
