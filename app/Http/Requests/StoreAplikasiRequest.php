<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAplikasiRequest extends FormRequest {

    public function rules(): array {
        return [
            'id_user'            => ['required', 'exists:users,id'],
            'nama_aplikasi'      => ['required', 'string', 'max:255'],
            'logo'               => ['required', 'image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
            'id_kategori'        => ['required', 'exists:kategori_aplikasi,id'],
            'nama_pemilik'       => ['required', 'string', 'max:255'],
            'tanggal_rilis'      => ['required', 'date'],
            'versi'              => ['required', 'string', 'max:50'],
            'tautan_aplikasi'    => ['required', 'url'],
            'deskripsi'          => ['required', 'string'],
            'fitur'              => ['required', 'string'],
            'status_verifikasi'  => ['nullable', 'in:pendig,diterima,ditolak'], // Sesuaikan dengan value valid
            'arsip'              => ['nullable', 'boolean'],
            'tanggal_ditambahkan' => ['required', 'date'],
            'tanggal_verifikasi'  => ['nullable', 'date'],
            'alasan_penolakan'   => ['nullable', 'string'],
        ];
    }

    public function messages(): array {
        return [
            'id_user.required' => 'ID user harus diisi.',
            'id_user.exists' => 'User tidak ditemukan.',
            'nama_aplikasi.required' => 'Nama aplikasi harus diisi.',
            'logo.required' => 'Logo harus diunggah.',
            'logo.image' => 'File logo harus berupa gambar.',
            'logo.mimes' => 'Logo harus berformat jpeg, png, jpg, gif, atau svg.',
            'logo.max' => 'Ukuran logo maksimal 2MB.',
            'id_kategori.required' => 'Kategori harus dipilih.',
            'id_kategori.exists' => 'Kategori tidak valid.',
            'nama_pemilik.required' => 'Nama pemilik harus diisi.',
            'tanggal_rilis.required' => 'Tanggal rilis harus diisi.',
            'versi.required' => 'Versi aplikasi harus diisi.',
            'tautan_aplikasi.required' => 'Tautan aplikasi harus diisi.',
            'tautan_aplikasi.url' => 'Tautan aplikasi harus berupa URL yang valid.',
            'deskripsi.required' => 'Deskripsi harus diisi.',
            'fitur.required' => 'Fitur harus diisi.',
            'status_verifikasi.in' => 'Status verifikasi harus salah satu dari: pending, diterima, ditolak.',
            'tanggal_ditambahkan.required' => 'Tanggal ditambahkan harus diisi.',
            'tanggal_verifikasi.date' => 'Tanggal verifikasi harus berupa tanggal.',
        ];
    }
}