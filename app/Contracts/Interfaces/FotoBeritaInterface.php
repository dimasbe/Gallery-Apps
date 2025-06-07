<?php

namespace App\Contracts\Interfaces;

use Illuminate\Database\Eloquent\Collection;

/**
 * Interface untuk manajemen Foto Berita.
 */
interface FotoBeritaInterface
{
    /**
     * Ambil semua data foto berita.
     *
     * @return Collection
     */
    public function get(): Collection;

    /**
     * Simpan data foto berita baru.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data);

    /**
     * Perbarui data foto berita berdasarkan ID.
     *
     * @param int $id
     * @param array $data
     * @return mixed
     */
    public function update(int $id, array $data);

    /**
     * Hapus data foto berita berdasarkan ID.
     *
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * Tambahkan method tambahan jika dibutuhkan,
     * contoh: ambil semua foto berdasarkan ID berita tertentu.
     *
     * public function getByBeritaId(int $beritaId): Collection;
     */
}
