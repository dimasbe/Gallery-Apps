<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Kategori;
use Illuminate\Database\Eloquent\Model; // Import Model

class KategoriRepository extends BaseRepository implements KategoriInterface
{
    protected Model $model;

    public function __construct(Kategori $kategori)
    {
        $this->model = $kategori;
    }

    /**
     * Mengambil semua kategori dengan relasi yang diperlukan.
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->orderBy('tanggal_dibuat', 'desc')->get();
    }

    /**
     * Menampilkan kategori berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * Menyimpan kategori baru.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Memperbarui kategori berdasarkan ID.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $kategori = $this->show($id);
        return $kategori->update($data);
    }

    /**
     * Menghapus kategori berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        $kategori = $this->show($id);
        return $kategori->delete();
    }

    /**
     * Menemukan kategori berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id); // Implementasi metode find
    }

    /**
     * Memfilter kategori berdasarkan sub_kategori.
     *
     * @param string $subKategori
     * @return mixed
     */
    public function filterBySubKategori(string $subKategori): mixed
    {
        return $this->model->query()
            ->where('sub_kategori', $subKategori)
            ->orderBy('tanggal_dibuat', 'desc')
            ->get();
    }
}
