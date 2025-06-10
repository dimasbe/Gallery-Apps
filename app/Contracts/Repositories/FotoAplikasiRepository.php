<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\FotoAplikasiInterface;
use App\Models\FotoAplikasi;
use Illuminate\Pagination\LengthAwarePaginator;

class FotoAplikasiRepository extends BaseRepository implements FotoAplikasiInterface
{
    public function __construct(FotoAplikasi $fotoAplikasi)
    {
        $this->model = $fotoAplikasi;
    }

    public function get(): mixed
    {
        return $this->model->query()->get();
    }

    public function store(array $data): mixed
    {
        return $this->model->query()->create($data);
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    public function update(mixed $id, array $data): mixed 
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    public function delete(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id)->delete();
    }

    public function paginate(int $pagination = 4): LengthAwarePaginator
    {
        return $this->model->query()->paginate($pagination);
    }

    public function find(mixed $id): mixed
    {
        return $this->model->query()->find($id);
    }

    public function where(string $column, $value): mixed
    {
        return $this->model->query()->where($column, $value)->get();       
    }
}
