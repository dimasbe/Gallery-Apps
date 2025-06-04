<?php

namespace App\Repositories;

use App\Contracts\Interfaces\KategoriInterface;
use App\Contracts\Repositories\BaseRepository;
use App\Models\Kategori;
<<<<<<< HEAD
<<<<<<< HEAD
=======
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;
=======
use Illuminate\Database\Eloquent\Model; // Import Model
>>>>>>> 91423f7eaaa252aedf9527efc3977ade08b48c3e
>>>>>>> 4843355f112b0d9509923708636ccbd06a4bee32
=======
use Illuminate\Support\Facades\Storage;
>>>>>>> 4b724a089016ff2e5e624444ee13ed01328f82fb

class KategoriRepository implements KategoriInterface
{
<<<<<<< HEAD
<<<<<<< HEAD
    public function all()
=======
    protected Model $model;
=======
>>>>>>> 4b724a089016ff2e5e624444ee13ed01328f82fb

    public function __construct(Kategori $kategori)
>>>>>>> 4843355f112b0d9509923708636ccbd06a4bee32
    {
        return Kategori::all();
    }

<<<<<<< HEAD
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
=======
    /**
     * Get all kategori data ordered by tanggal_dibuat descending.
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(): mixed
    {
        return $this->model->orderBy('tanggal_dibuat', 'desc')->get();
    }

    /**
     * Filter kategori berdasarkan sub_kategori.
     *
     * @param string $subKategori
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function filterBySubKategori(string $subKategori): mixed
    {
        return $this->model
            ->where('sub_kategori', $subKategori)
            ->orderBy('tanggal_dibuat', 'desc')
            ->get();
    }

    /**
     * Simpan data kategori baru, termasuk upload gambar jika ada.
     *
     * @param array $data
     * @return Kategori
     */
    public function store(array $data): mixed
    {
        if (isset($data['gambar'])) {
            $data['gambar'] = $this->uploadImage($data['gambar']);
        }
        return $this->model->create($data);
    }

    /**
     * Ambil data kategori berdasarkan id.
     *
     * @param mixed $id
     * @return Kategori
     */
    public function show(mixed $id): mixed
    {
        return $this->model->findOrFail($id);
    }

    /**
     * Update data kategori, termasuk mengelola gambar lama dan baru.
     *
     * @param mixed $id
     * @param array $data
     * @return bool
     */
    public function update(mixed $id, array $data): mixed
    {
        $kategori = $this->show($id);

        if (isset($data['gambar'])) {
            $this->deleteImage($kategori->gambar);
            $data['gambar'] = $this->uploadImage($data['gambar']);
        } elseif (!empty($data['remove_gambar']) && $data['remove_gambar'] === 'true') {
            $this->deleteImage($kategori->gambar);
            $data['gambar'] = null;
        } else {
            unset($data['gambar']);
        }

        return $kategori->update($data);
    }

    /**
     * Hapus data kategori dan gambar terkait.
     *
     * @param mixed $id
     * @return bool|null
     */
    public function delete(mixed $id): mixed
    {
        $kategori = $this->show($id);
        $this->deleteImage($kategori->gambar);
        return $kategori->delete();
    }

    /**
     * Upload gambar ke storage dan kembalikan path publik.
     *
     * @param \Illuminate\Http\UploadedFile $file
     * @return string
     */
    protected function uploadImage($file): string
>>>>>>> 4843355f112b0d9509923708636ccbd06a4bee32
    {
        return Kategori::where('sub_kategori', $subKategori)->get();
    }
<<<<<<< HEAD
=======

    /**
     * Hapus gambar dari storage.
     *
     * @param string|null $path
     * @return void
     */
    protected function deleteImage(?string $path): void
    {
        if ($path) {
            Storage::delete(str_replace('storage/', 'public/', $path));
        }
    }
<<<<<<< HEAD
=======
>>>>>>> 91423f7eaaa252aedf9527efc3977ade08b48c3e
>>>>>>> 4843355f112b0d9509923708636ccbd06a4bee32
=======
>>>>>>> 4b724a089016ff2e5e624444ee13ed01328f82fb
}
