<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\AplikasiInterface;
use App\Models\Aplikasi;
use Illuminate\Http\Request;

class AplikasiRepository extends BaseRepository implements AplikasiInterface {

    public function __construct(Aplikasi $aplikasi) {
        $this->model = $aplikasi;
    }

    public function get(): mixed {
        return $this->model->query()->with('kategori', 'fotoAplikasi', 'users')->orderBy('id','DESC')->get();
    }

    public function show(mixed $id): mixed {
        return $this->model->query()->with('kategori.fotoAplikasi', 'foto_aplikasi', 'users')->findOrFail($id);
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

    public function search(Request $request): mixed {
        $keyword = $request->input('keyword');

        return $this->model->query()
            ->with('kategori', 'foto_aplikasi', 'users')
            ->where('nama_aplikasi', 'like', "%{$keyword}%")
            ->orWhereHas('kategori', function ($query) use ($keyword) {
                $query->where('nama_kategori', 'like', "%{$keyword}%");
            })
            ->orderBy('id', 'DESC')
            ->get();
    }
}