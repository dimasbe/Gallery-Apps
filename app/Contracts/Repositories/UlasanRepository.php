<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\UlasanInterface;
use App\Models\Ulasan;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class UlasanRepository extends BaseRepository implements UlasanInterface
{
    protected Model $model;

    public function __construct(Ulasan $ulasan)
    {
        $this->model = $ulasan;
    }

    public function get(): mixed
    {
        return $this->model->query()->orderBy('id_ulasan','DESC')->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    public function store(array $data): Ulasan 
    {
        $ulasan = $this->model->create($data);
        $ulasan->load('users');
        return $ulasan;
    }

    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    public function delete(mixed $id): mixed 
    {
        return $this->model->query()->findOrFail($id)->delete();
    }

    public function getAllByAplikasiId(int $aplikasiId): Collection
    {
        return $this->model->with('user')
                           ->where('id_aplikasi', $aplikasiId)
                           ->latest()
                           ->get();
    }
}
