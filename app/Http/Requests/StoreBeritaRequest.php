<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBeritaRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'judul_berita' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori,id',  // pastikan tabel kategori sesuai
            'isi_berita' => 'required|string',
            'thumbnail' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',  // maksimal 2MB
        ];
    }
    
    public function messages()
    {
        return [
            'judul_berita.required' => 'Judul berita wajib diisi.',
            'penulis.required' => 'Nama penulis wajib diisi.',
            'kategori_id.required' => 'Kategori wajib dipilih.',
            'kategori_id.exists' => 'Kategori tidak valid.',
            'thumbnail.required' => 'Thumbnail wajib diunggah.',
            'thumbnail.image' => 'File thumbnail harus berupa gambar.',
            'thumbnail.mimes' => 'Thumbnail harus berformat jpeg, png, jpg, atau gif.',
            'thumbnail.max' => 'Ukuran thumbnail maksimal 2MB.',
            'paragrafs.required' => 'Paragraf tidak boleh kosong.',
            'paragrafs.*.content.required' => 'Setiap paragraf harus memiliki isi.',
        ];
    }
}
