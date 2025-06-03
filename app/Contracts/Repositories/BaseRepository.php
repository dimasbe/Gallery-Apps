<?php

namespace App\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class BaseRepository
{
    protected Model $model;

    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->all();
    }

    /**
     * Handle the Store data event from models.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Handle the Show data event from models.
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Handle the Update data event from models.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $model = $this->model->findOrFail($id);
        $model->update($data);
        return $model;
    }

    /**
     * Handle the Delete data event from models.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        return $this->model->findOrFail($id)->delete();
    }
}