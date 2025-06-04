<?php

namespace App\Contracts\Interfaces\Eloquent;

interface BaseInterface
{
    public function get(): mixed;
    public function find(mixed $id): mixed;
    public function store(array $data): mixed;
    public function update($id, array $data): mixed;
    public function delete($id): mixed;
}
