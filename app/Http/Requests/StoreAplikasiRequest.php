<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException; // <<< PENTING: Import ini!

class StoreAplikasiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Sesuaikan dengan logika otorisasi Anda. Contoh: return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'nama_aplikasi' => 'required|string|max:255',
            'nama_pemilik' => 'required|string|max:255',
            'id_kategori' => 'required|exists:kategori,id', // <<< PENTING: Gunakan 'kategoris' (jamak) jika itu nama tabel Anda
            'tanggal_rilis' => 'required|date',
            'versi' => 'required|string|max:50',
            'rating_konten' => 'required|string|max:50',
            'tautan_aplikasi' => 'required|url',
            'deskripsi' => 'required|string',
            'fitur' => 'required|string',
            'path_foto' => 'required|array|min:1',
            'path_foto.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  \Illuminate\Contracts\Validation\Validator  $validator
     * @return void
     *
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        // <<< PENTING: Ini akan mengembalikan JSON response saat validasi gagal
        throw new HttpResponseException(response()->json([
            'success' => false,
            'message' => 'Validasi gagal. Periksa kembali input Anda.',
            'errors' => $validator->errors() // Objek error validasi dari Laravel
        ], 422)); // HTTP Status 422 (Unprocessable Entity)
    }
}