<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBeritaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul_berita' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',
            'isi_berita' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Tidak wajib diunggah
        ];
    }

    public function messages()
    {
        return [
            'judul_berita.required' => 'Judul berita wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'isi_berita.required' => 'Isi berita wajib diisi.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Thumbnail harus berformat jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
        ];
    }
}
