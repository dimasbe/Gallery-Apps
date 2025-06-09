<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\NotifikasiInterface;
use App\Models\Notifikasi;
use Illuminate\Database\Eloquent\Collection;

class NotifikasiRepository implements NotifikasiInterface
{
    protected Notifikasi $model;

    public function __construct(Notifikasi $notifikasi)
    {
        $this->model = $notifikasi;
    }

    /**
     * Ambil semua notifikasi.
     * 
     * @return Collection|Notifikasi[]
     */
    public function get(): Collection
    {
        return $this->model->all();
    }

    /**
     * Simpan notifikasi baru.
     *
     * @param array $data
     * @return Notifikasi
     */
    public function store(array $data): Notifikasi
    {
        return $this->model->create($data);
    }

    /**
     * Tampilkan notifikasi berdasarkan ID.
     *
     * @param $id
     * @return Notifikasi|null
     */
    public function show($id): ?Notifikasi
    {
        return $this->model->find($id);
    }

    /**
     * Update notifikasi berdasarkan ID.
     *
     * @param $id
     * @param array $data
     * @return Notifikasi|null
     */
    public function update($id, array $data): ?Notifikasi
    {
        $notifikasi = $this->model->firstOrFail($id);
        $notifikasi->update($data);
        return $notifikasi;
    }

    /**
     * Hapus notifikasi berdasarkan ID.
     *
     * @param $id
     * @return bool
     */
    public function delete($id): bool
    {
        $notifikasi = $this->model->firstOrFail($id);
        return $notifikasi->delete();
    }
}
