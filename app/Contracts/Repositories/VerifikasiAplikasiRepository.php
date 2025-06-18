<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\VerifikasiAplikasiInterface;
use App\Models\Aplikasi;

class VerifikasiAplikasiRepository implements VerifikasiAplikasiInterface {
    protected Aplikasi $model;

    public function __construct(Aplikasi $aplikasi) {
        $this->model  = $aplikasi;
    }

    public function show(mixed $id): mixed {
        return $this->model->query()
        ->findOrFail($id);
    }

    public function update(mixed $id, array $data): mixed {
        $aplikasi = $this->model->query()->findOrFail($id);
        $aplikasi->update($data);
        return $aplikasi; 
    }

    public function getByStatus(string $requeststatus) {
        return Aplikasi::where('status_verifikasi', $requeststatus)->get();
    }

    public function getByStatusPaginated(string $status, int $perPage, ?string $keyword = null) {
        $query = $this->model->where('status_verifikasi', $status);

        if ($keyword) {
            $query->where(function ($q) use ($keyword) {
                $q->whereRaw('LOWER(nama_aplikasi) LIKE ?', ['%' . strtolower($keyword) . '%'])
                  ->orWhereHas('user', function ($qUser) use ($keyword) {
                      $qUser->whereRaw('LOWER(name) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  })
                  ->orWhereHas('kategori', function ($qKategori) use ($keyword) {
                      $qKategori->whereRaw('LOWER(nama_kategori) LIKE ?', ['%' . strtolower($keyword) . '%']);
                  });
            });
        }

        return $query->paginate($perPage);
    }
}