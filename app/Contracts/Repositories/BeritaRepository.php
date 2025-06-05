<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BeritaInterface;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Collection;

class BeritaRepository extends BaseRepository implements BeritaInterface
{
    public function __construct(Berita $berita)
    {
        $this->model = $berita;
    }

    /**
     * Ambil semua berita dengan relasi.
     *
     * @return Collection
     */
    public function get(): Collection
    {
        return $this->model->with(['kategori', 'penulis', 'foto_berita'])
            ->orderByDesc('id')
            ->get();
    }

    /**
     * Ambil satu berita berdasarkan ID.
     *
     * @param mixed $id
     * @return Berita
     */
    public function show(mixed $id): Berita
    {
        return $this->model->with(['kategori', 'penulis', 'foto_berita'])
            ->findOrFail($id);
    }

    /**
     * Simpan berita baru.
     *
     * @param array $data
     * @return Berita
     */
    public function store(array $data): Berita
    {
        return $this->model->create($data);
    }

    /**
     * Perbarui berita berdasarkan ID.
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): bool
    {
        $berita = $this->model->findOrFail($id);
        return $berita->update($data);
    }

    /**
     * Hapus berita berdasarkan ID.
     *
     * @param mixed $id
     * @return bool
     */
    public function delete(mixed $id): bool
    {
        $berita = $this->model->findOrFail($id);
        return $berita->delete();
    }

    public function getAllWithKategori()
    {
        // Contoh menggunakan Eloquent relationship 'kategori'
        return Berita::with('kategori')->get();
    }

    /**
     * Cari berita berdasarkan keyword di judul atau kategori.
     *
     * @param Request $request
     * @return Collection
     */
    public function search(Request $request): Collection
    {
        $keyword = $request->input('keyword');

        return $this->model->with(['kategori', 'penulis', 'foto_berita'])
            ->where(function ($query) use ($keyword) {
                $query->where('judul', 'like', "%{$keyword}%")
                      ->orWhereHas('kategori', function ($q) use ($keyword) {
                          $q->where('nama_kategori', 'like', "%{$keyword}%");
                      });
            })
            ->orderByDesc('id')
            ->get();
    }
}
