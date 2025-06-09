<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFotoAplikasiRequest extends FormRequest
{

    public function rules()
    {
        return [
            'id_aplikasi' => 'required|exists:aplikasi,id',
            'path_foto' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'id_aplikasi.required' => 'ID aplikasi wajib diisi.',
            'id_aplikasi.exists' => 'ID aplikasi tidak valid.',
            'path_foto.image' => 'File harus berupa gambar.',
            'path_foto.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau svg.',
            'path_foto.max' => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}
