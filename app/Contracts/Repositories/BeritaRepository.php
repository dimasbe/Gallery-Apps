<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\BeritaInterface;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaRepository extends BaseRepository implements BeritaInterface
{
    public function __construct(Berita $berita)
    {
        $this->model = $berita;
    }

    public function get(): mixed
    {
        return $this->model->query()
            ->with('kategori', 'penulis', 'foto_berita') // sesuaikan dengan relasi di model Berita
            ->orderBy('id', 'DESC')
            ->get();
    }

    public function show(mixed $id): mixed
    {
        return $this->model->query()
            ->with('kategori', 'penulis', 'foto_berita') // sesuaikan dengan relasi di model Berita
            ->findOrFail($id);
    }

    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    public function update(mixed $id, array $data): mixed
    {
        return $this->model->query()->findOrFail($id)->update($data);
    }

    public function delete(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id)->delete();
    }

    public function search(Request $request): mixed
    {
        $keyword = $request->input('keyword');

        return $this->model->query()
            ->with('kategori', 'penulis', 'foto_berita')
            ->where('judul', 'like', "%{$keyword}%")
            ->orWhereHas('kategori', function ($query) use ($keyword) {
                $query->where('nama_kategori', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'DESC')
            ->get();
    }
}
