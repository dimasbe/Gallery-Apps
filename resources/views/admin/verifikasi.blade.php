@extends('layouts.admin') {{-- Memastikan halaman ini menggunakan layout admin Anda --}}

@section('title', 'Verifikasi') {{-- Mengatur judul halaman pada tab browser --}}

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen"> {{-- Padding dan background untuk area konten utama --}}

    {{-- KARTU PUTIH UNTUK HEADER & BREADCRUMB --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6"> {{-- Card putih baru untuk header, dengan bayangan dan sudut membulat --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Verifikasi</h1> {{-- Judul utama halaman --}}
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        {{-- Menggunakan titik (&bull;) sebagai pemisah breadcrumb, dengan warna merah dari CSS kustom Anda --}}
                        {{-- PENYESUAIAN UKURAN TITIK MERAH DI SINI UNTUK ALIGNMENT --}}
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span> {{-- Menggunakan text-base agar sejajar --}}
                    </li>
                    {{-- BARIS INI AKAN MENJADIKAN TEKS "Verifikasi" MERAH --}}
                    <li class="text-custom-primary-red" aria-current="page">Verifikasi</li> {{-- Teks "Verifikasi" dengan warna merah --}}
                </ol>
            </nav>
        </div>
    </div>

    {{-- Kartu (Card) yang Membungkus Tabel Verifikasi --}}
    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="overflow-x-auto"> {{-- Membuat tabel responsif terhadap ukuran layar kecil --}}
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            No.
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Nama Aplikasi
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Pemilik
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Kategori
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Dummy untuk Tabel --}}
                    @php
                        $verifikasiData = [
                            ['no' => 1, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 2, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 3, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 4, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 5, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 6, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 7, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 8, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 9, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                            ['no' => 10, 'nama_aplikasi' => 'Mobile Legend', 'pemilik' => 'Stevia Magdalena', 'kategori' => 'Permainan', 'tanggal' => '06 - 05 - 2025'],
                        ];
                    @endphp

                    @foreach($verifikasiData as $data)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $data['no'] }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $data['nama_aplikasi'] }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $data['pemilik'] }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $data['kategori'] }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <p class="text-gray-900 whitespace-no-wrap">{{ $data['tanggal'] }}</p>
                        </td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                            <div class="flex space-x-2">
                                {{-- Tombol Aksi dengan warna yang disesuaikan --}}
                                <button class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">Diterima</button>
                                <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">Ditolak</button>
                                <button class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">Lihat</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- Bagian Pagination --}}
        <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600">
                Rows per page:
                <select class="ml-2 border border-gray-300 rounded-md py-1 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red">
                    <option>10</option>
                    <option>20</option>
                    <option>30</option>
                </select>
            </div>
            <div class="text-sm text-gray-600">
                1-10 of 30
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>
@endsection