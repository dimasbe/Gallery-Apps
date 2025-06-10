<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Models\Aplikasi;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection; // Pastikan ini di-import

class AplikasiRepository extends BaseRepository implements AplikasiInterface
{
    protected Model $model;

    public function __construct(Aplikasi $aplikasi)
    {
        $this->model = $aplikasi;
    }

    public function get(): mixed {
        return $this->model->query()->with('kategori', 'fotoAplikasi', 'users')->orderBy('id','DESC')->get();
    }

    /**
     * Mengambil semua aplikasi dengan relasi yang diperlukan.
     *
     * @return mixed
     */
    public function show(mixed $id): mixed {
        return $this->model->query()->with('kategori.fotoAplikasi', 'foto_aplikasi', 'users')->findOrFail($id);
    }

    /**
     * Menyimpan aplikasi baru.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Memperbarui aplikasi berdasarkan ID.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $aplikasi = $this->model->query()->findOrFail($id);
        $aplikasi->update($data);
        return $aplikasi; // Mengembalikan aplikasi yang diperbarui
    }

    /**
     * Menghapus aplikasi berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        $aplikasi = $this->model->query()->findOrFail($id);
        return $aplikasi->delete(); // Mengembalikan hasil penghapusan
    }

    /**
     * Mencari aplikasi berdasarkan kata kunci.
     *
     * @param Request $request
     * @return mixed
     */
    public function search(Request $request): mixed
    {
        $keyword = $request->input('q');

        return $this->model->query()
            ->with('kategori', 'fotoAplikasi', 'user')
            ->where('nama_aplikasi', 'like', "%{$keyword}%")
            ->orWhere('nama_pemilik', 'like', "%{$keyword}%")
            ->orWhereHas('kategori', function ($query) use ($keyword) {
                $query->where('nama_kategori', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * Menemukan aplikasi berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id); // Implementasi metode find
    }

    public function getByUserId(int|string $userId): mixed
    {
        return $this->model->query()
            ->with('kategori', 'fotoAplikasi', 'users')
            ->where('id_user', $userId)
            ->orderBy('id', 'DESC')
            ->get();
    }

    /**
     * Implementasi dari getPopularApps.
     *
     * @param int $limit
     * @return \Illuminate\Support\Collection
     */
    public function getPopularApps(int $limit): Collection
    {
        return Aplikasi::orderBy('jumlah_kunjungan', 'desc')
                       ->take($limit)
                       ->get();
    }
}
