<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreKategoriAplikasiRequest extends FormRequest {
    
    public function rules(): array {
        return [
            'nama_kategori' => 'required|string|max:255',
        ];
    }

    public function messages(): array {
        return [
            'nama_kategori.required' => 'Nama Kategori tidak boleh kosong',
        ];
    }
}