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
        return $aplikasi; // Mengembalikan aplikasi yang diperbarui
    }

    public function getByStatus(string $requeststatus) {
        return Aplikasi::where('status_verifikasi', $requeststatus)->get();
    }
}