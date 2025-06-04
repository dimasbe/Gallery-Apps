<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Kategori;
<<<<<<< HEAD
use Illuminate\Support\Facades\Storage;
=======
use Illuminate\Database\Eloquent\Model; // Import Model
>>>>>>> 91423f7eaaa252aedf9527efc3977ade08b48c3e

class KategoriRepository extends BaseRepository implements KategoriInterface
{
    protected Model $model;

    public function __construct(Kategori $kategori)
    {
        $this->model = $kategori;
    }

    /**
<<<<<<< HEAD
     * Get all kategori data ordered by tanggal_dibuat descending.
=======
     * Mengambil semua kategori dengan relasi yang diperlukan.
>>>>>>> 91423f7eaaa252aedf9527efc3977ade08b48c3e
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function get(): mixed
    {
        return $this->model->orderBy('tanggal_dibuat', 'desc')->get();
    }

    /**
<<<<<<< HEAD
     * Filter kategori berdasarkan sub_kategori.
=======
     * Menampilkan kategori berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
    }

    /**
     * Menyimpan kategori baru.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        return $this->model->create($data);
    }

    /**
     * Memperbarui kategori berdasarkan ID.
     *
     * @param mixed $id
     * @param array $data
     * @return mixed
     */
    public function update(mixed $id, array $data): mixed
    {
        $kategori = $this->show($id);
        return $kategori->update($data);
    }

    /**
     * Menghapus kategori berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        $kategori = $this->show($id);
        return $kategori->delete();
    }

    /**
     * Menemukan kategori berdasarkan ID.
     *
     * @param mixed $id
     * @return mixed
     */
    public function find(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id); // Implementasi metode find
    }

    /**
     * Memfilter kategori berdasarkan sub_kategori.
>>>>>>> 91423f7eaaa252aedf9527efc3977ade08b48c3e
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
<<<<<<< HEAD

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
    {
        $path = $file->store('public/kategori_gambar');
        return str_replace('public/', 'storage/', $path);
    }

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
=======
>>>>>>> 91423f7eaaa252aedf9527efc3977ade08b48c3e
}
