<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\FotoBeritaInterface;
use App\Models\FotoBerita;

class FotoBeritaRepository implements FotoBeritaInterface
{
    public function get()
    {
        return FotoBerita::all();
    }

    public function store(array $data)
    {
        return FotoBerita::create($data);
    }

    public function update(int $id, array $data)
    {
        $foto = FotoBerita::findOrFail($id);
        $foto->update($data);
        return $foto;
    }

    public function delete(int $id)
    {
        $foto = FotoBerita::findOrFail($id);
        $foto->delete();
        return true;
    }
}
