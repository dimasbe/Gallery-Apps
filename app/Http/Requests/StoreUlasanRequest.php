<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreUlasanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'id_aplikasi' => 'required|exists:aplikasi,id_aplikasi',
            'id_user'     => 'required|exists:users,id',
            'ulasan'      => 'required|string|min:5|max:1000',
        ];
    }

    public function messages(): array
    {
        return [
            'id_aplikasi.required' => 'Aplikasi harus dipilih.',
            'id_aplikasi.exists'   => 'Aplikasi yang dipilih tidak valid.',
            'id_user.required'     => 'Pengguna harus dipilih.',
            'id_user.exists'       => 'Pengguna tidak ditemukan.',
            'ulasan.required'      => 'Ulasan tidak boleh kosong.',
            'ulasan.string'        => 'Ulasan harus berupa teks.',
            'ulasan.min'           => 'Ulasan minimal 5 karakter.',
            'ulasan.max'           => 'Ulasan maksimal 1000 karakter.',
        ];
    }

    protected function prepareForValidation(): void
    {
        // Secara opsional, jika Anda mengirim aplikasi_id melalui URL,
        // Anda bisa menyuntikkannya ke request data di sini.
        // Pastikan nama parameter di route Anda sesuai (misal: {aplikasi}).
        if ($this->route('aplikasi')) {
            $this->merge([
                'id_aplikasi' => $this->route('aplikasi')->id_aplikasi,
            ]);
        }
    }
}