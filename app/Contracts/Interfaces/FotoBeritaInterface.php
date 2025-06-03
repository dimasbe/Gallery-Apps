<?php

namespace App\Contracts\Interfaces;

interface FotoBeritaInterface
{
    public function get();
    public function store(array $data);
    public function update(int $id, array $data);
    public function delete(int $id);
    // Tambah method sesuai kebutuhan
}
