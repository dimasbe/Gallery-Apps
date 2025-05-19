<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\KategoriAplikasiInterface;
use App\Models\KategoriAplikasi;

class KategoriAplikasiRepository extends BaseRepository implements KategoriAplikasiInterface {

    public function __construct(KategoriAplikasi $kategori) {
        $this->model = $kategori;
    }

    public function get(): mixed {
        return $this->model->query()->orderBy('id','DESC')->get();
    }

    public function show(mixed $id): mixed {
        return $this->model->query()->findOrFail($id);
    }

    public function store(array $data): mixed {
        return $this->model->create($data);
    }

    public function update(mixed $id, array $data): mixed {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    public function delete(mixed $id): mixed {
        return $this->model->query()->findOrFail($id)->delete();
    }
}