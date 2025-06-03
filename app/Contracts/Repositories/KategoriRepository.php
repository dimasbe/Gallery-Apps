<?php

namespace App\Contracts\Repositories;

use App\Contracts\Interfaces\KategoriInterface;
use App\Models\Kategori;
use Illuminate\Support\Facades\Storage; // For file storage operations

class KategoriRepository extends BaseRepository implements KategoriInterface
{
    public function __construct(Kategori $kategori)
    {
        $this->model = $kategori;
    }

    /**
     * Handle the Get all data event from models.
     *
     * @return mixed
     */
    public function get(): mixed
    {
        return $this->model->query()->orderBy('tanggal_dibuat', 'desc')->get();
    }

    /**
     * Handle filtering data based on sub_kategori.
     *
     * @param string $subKategori
     * @return mixed
     */
    public function filterBySubKategori(string $subKategori): mixed
    {
        return $this->model->query()
            ->where('sub_kategori', $subKategori)
            ->orderBy('tanggal_dibuat', 'desc')
            ->get();
    }

    /**
     * Handle the Store data event from models.
     *
     * @param array $data
     * @return mixed
     */
    public function store(array $data): mixed
    {
        if (isset($data['gambar'])) {
            $data['gambar'] = $this->uploadImage($data['gambar']);
        }
        return $this->model->query()->create($data);
    }

    /**
     * Handle the Show data event from models.
     *
     * @param mixed $id
     * @return mixed
     */
    public function show(mixed $id): mixed
    {
        return $this->model->query()->findOrFail($id);
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
        $kategori = $this->show($id); // Find the Kategori first

        if (isset($data['gambar'])) {
            $this->deleteImage($kategori->gambar); // Delete old image
            $data['gambar'] = $this->uploadImage($data['gambar']); // Upload new image
        } elseif (isset($data['remove_gambar']) && $data['remove_gambar'] === 'true') {
            $this->deleteImage($kategori->gambar);
            $data['gambar'] = null;
        } else {
            unset($data['gambar']); // Ensure image isn't set to null if not changing/removing
        }

        return $kategori->update($data);
    }

    /**
     * Handle the Delete data event from models.
     *
     * @param mixed $id
     * @return mixed
     */
    public function delete(mixed $id): mixed
    {
        $kategori = $this->show($id); // Find the Kategori first
        $this->deleteImage($kategori->gambar); // Delete associated image
        return $kategori->delete();
    }

    /**
     * Upload the image to storage.
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
     * Delete the image from storage.
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
}