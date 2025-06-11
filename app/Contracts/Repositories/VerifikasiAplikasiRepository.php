<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\VerifikasiAplikasiInterface;
use App\Models\Aplikasi;
use App\Enums\StatusTypeEnum;

class VerifikasiAplikasiRepository implements VerifikasiAplikasiInterface {
    protected Aplikasi $model;

    public function __construct(Aplikasi $aplikasi) {
        $this->model = $aplikasi;
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
        // This method can remain as is if it's always intended to return a collection
        return Aplikasi::where('status_verifikasi', $requeststatus)->get();
    }

    // --- MODIFIED METHOD ---
    public function getAcceptedOrRejected() {
        return $this->model->query() // Return the query builder
            ->whereIn('status_verifikasi', [
                StatusTypeEnum::DITERIMA->value,
                StatusTypeEnum::DITOLAK->value
            ]);
    }
}