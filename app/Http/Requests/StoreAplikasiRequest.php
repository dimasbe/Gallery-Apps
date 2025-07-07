<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreAplikasiRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'nama_aplikasi'   => 'required|string|max:255',
            'nama_pemilik'    => 'required|string|max:255',
            'id_kategori'     => 'required|exists:kategori,id',
            'tanggal_rilis'   => 'required|date',
            'versi'           => [
                'required',
                'numeric',
                'min:1',
            ],
            'rating_konten'   => 'required|string|max:50',
            'tautan_aplikasi' => 'required|url',
            'deskripsi'       => 'required|string',
            'fitur'           => 'required|string',
            'path_foto'       => 'required|array|min:1',
            'path_foto.*'     => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'nama_aplikasi.required'   => 'Nama aplikasi wajib diisi.',
            'nama_aplikasi.max'        => 'Nama aplikasi maksimal 255 karakter.',
            'nama_pemilik.required'    => 'Nama pemilik wajib diisi.',
            'nama_pemilik.max'         => 'Nama pemilik maksimal 255 karakter.',
            'id_kategori.required'     => 'Kategori aplikasi wajib dipilih.',
            'id_kategori.exists'       => 'Kategori yang dipilih tidak valid.',
            'tanggal_rilis.required'   => 'Tanggal rilis wajib diisi.',
            'tanggal_rilis.date'       => 'Tanggal rilis harus berupa tanggal yang valid.',
            'versi.required'           => 'Versi aplikasi wajib diisi.',
            'versi.numeric'            => 'Versi aplikasi harus berupa angka.',
            'versi.min'                => 'Versi aplikasi tidak boleh 0. Harap masukkan nilai lebih dari 0.',
            'versi.max'                => 'Versi maksimal 50 karakter.',
            'rating_konten.required'   => 'Rating konten wajib diisi.',
            'rating_konten.max'        => 'Rating konten maksimal 50 karakter.',
            'tautan_aplikasi.required' => 'Tautan aplikasi wajib diisi.',
            'tautan_aplikasi.url'      => 'Tautan aplikasi harus berupa URL yang valid.',
            'deskripsi.required'       => 'Deskripsi aplikasi wajib diisi.',
            'fitur.required'           => 'Fitur aplikasi wajib diisi.',
            'path_foto.required'       => 'Minimal satu foto harus diunggah.',
            'path_foto.array'          => 'Foto harus dikirim dalam bentuk array.',
            'path_foto.min'            => 'Minimal satu foto harus diunggah.',
            'path_foto.*.required'     => 'Setiap foto wajib diunggah.',
            'path_foto.*.image'        => 'File yang diunggah harus berupa gambar.',
            'path_foto.*.mimes'        => 'Format gambar yang diperbolehkan: jpeg, png, jpg, gif, svg.',
            'path_foto.*.max'          => 'Ukuran gambar maksimal 2MB.',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal. Periksa kembali input Anda.',
            'errors' => $validator->errors()
        ], 422));
    }
}
