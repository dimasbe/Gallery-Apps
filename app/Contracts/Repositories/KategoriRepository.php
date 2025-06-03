<?php

namespace App\Repositories;

use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Kategori;

class KategoriRepository implements KategoriInterface
{
    public function all()
    {
        return Kategori::all();
    }

    public function find($id)
    {
        return Kategori::findOrFail($id);
    }

    public function create(array $data)
    {
        return Kategori::create($data);
    }

    public function update($id, array $data)
    {
        $kategori = Kategori::findOrFail($id);
        $kategori->update($data);
        return $kategori;
    }

    public function delete($id)
    {
        $kategori = Kategori::findOrFail($id);
        return $kategori->delete();
    }

    public function getBySubKategori(string $subKategori)
    {
        return Kategori::where('sub_kategori', $subKategori)->get();
    }
}
