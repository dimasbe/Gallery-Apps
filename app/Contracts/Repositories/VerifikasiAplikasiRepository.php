<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\VerifikasiAplikasiInterface;
use App\Models\Aplikasi;
use Illuminate\Contracts\Pagination\LengthAwarePaginator; // Import this for type hinting

class VerifikasiAplikasiRepository implements VerifikasiAplikasiInterface {
    protected Aplikasi $model;

    public function __construct(Aplikasi $aplikasi) {
        $this->model = $aplikasi;
    }

    /**
     * Menampilkan detail aplikasi berdasarkan ID.
     *
     * @param mixed $id ID aplikasi.
     * @return mixed Model Aplikasi yang ditemukan.
     */
    public function show(mixed $id): mixed {
        return $this->model->query()
            ->findOrFail($id);
    }

    /**
     * Memperbarui data aplikasi berdasarkan ID.
     *
     * @param mixed $id ID aplikasi.
     * @param array $data Data yang akan diperbarui.
     * @return mixed Model Aplikasi yang telah diperbarui.
     */
    public function update(mixed $id, array $data): mixed {
        $aplikasi = $this->model->query()->findOrFail($id);
        $aplikasi->update($data);
        return $aplikasi;
    }

    /**
     * Mengambil daftar aplikasi berdasarkan status.
     *
     * @param string $requeststatus Status verifikasi yang dicari.
     * @return \Illuminate\Database\Eloquent\Collection Koleksi aplikasi.
     */
    public function getByStatus(string $requeststatus) {
        return Aplikasi::where('status_verifikasi', $requeststatus)->get();
    }

    /**
     * Mengambil daftar aplikasi berdasarkan status dengan paginasi dan pencarian, diurutkan dari yang terbaru.
     *
     * @param string $status Status verifikasi yang dicari.
     * @param int $perPage Jumlah item per halaman.
     * @param string|null $keyword Kata kunci pencarian.
     * @return \Illuminate\Contracts\Pagination\LengthAwarePaginator Objek paginasi.
     */
    public function getByStatusPaginated(string $status, int $perPage, ?string $keyword = null): LengthAwarePaginator {
        $query = $this->model->where('status_verifikasi', $status);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(nama_aplikasi) LIKE ?', ['%' . strtolower($keyword) . '%'])
                    // UBAH DARI 'user' MENJADI 'users'
                    ->orWhereHas('users', function ($qUser) use ($keyword) {
                        $qUser->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    })
                    ->orWhereHas('kategori', function ($qKategori) use ($keyword) {
                        $qKategori->whereRaw('LOWER(nama_kategori) LIKE ?', ['%' . strtolower($keyword) . '%']);
                    });
            });
        }

        // UBAH DARI 'created_at' MENJADI 'tanggal_ditambahkan'
        $query->orderBy('tanggal_ditambahkan', 'desc');

        return $query->paginate($perPage);
    }
}