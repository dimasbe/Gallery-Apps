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
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Verifikasi</li>
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
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data Dummy untuk Tabel, diambil dari Controller --}}
                    @if(count($verifikasiData) > 0)
                        @foreach($verifikasiData as $data)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $loop->iteration }}</p>
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
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <div class="flex space-x-2 justify-center">
                                    <button class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">Diterima</button>
                                    <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200"
                                            onclick="showRejectPopup()">Ditolak</button>
                                    <button class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">Lihat</button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                Tidak ada data verifikasi.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Bagian Pagination (Statis) --}}
        <div class="flex justify-between items-center mt-6">
            <div class="text-sm text-gray-600">
                Rows per page:
                <select id="rows-per-page" class="ml-2 border border-gray-300 rounded-md py-1 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div id="pagination-info" class="text-sm text-gray-600">
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

{{-- Pop-up Tolak Ajuan --}}
<div id="reject-popup-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto">
        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Tolak Ajuan</h2>
        <div class="mb-4">
            <label for="reject-notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan</label>
            <textarea id="reject-notes"
                      rows="4"
                      class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none"
                      placeholder="Aplikasi tidak sesuai kriteria."></textarea>
        </div>
        {{-- Mengubah flex-justify-center menjadi flex justify-end untuk menempatkan tombol di kanan --}}
            <div class="flex justify-end space-x-4">
        {{-- Tombol Batal: Ubah py-2 px-4 menjadi py-1 px-2 --}}
        <button class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 font-bold py-1 px-2 rounded-md transition duration-200"
                onclick="hideRejectPopup()">Batal</button>
        {{-- Tombol Kirim: Ubah py-2 px-4 menjadi py-1 px-2 --}}
        <button class="bg-custom-primary-red hover:bg-custom-primary-red-darker text-white font-bold py-1 px-2 rounded-md shadow-sm transition duration-200"
                onclick="submitReject()">Kirim</button>
    </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan pop-up
    function showRejectPopup() {
        console.log('Tombol Ditolak diklik! Menampilkan pop-up...'); // Untuk debugging
        document.getElementById('reject-popup-overlay').classList.remove('hidden');
    }

    // Fungsi untuk menyembunyikan pop-up
    function hideRejectPopup() {
        console.log('Menyembunyikan pop-up...'); // Untuk debugging
        document.getElementById('reject-popup-overlay').classList.add('hidden');
        document.getElementById('reject-notes').value = ''; // Bersihkan textarea
    }

    // Fungsi untuk menangani saat tombol 'Kirim' diklik
    function submitReject() {
        const notes = document.getElementById('reject-notes').value;
        console.log('Catatan penolakan:', notes); // Untuk debugging
        alert('Mengirim catatan penolakan: ' + notes); // Contoh feedback
        hideRejectPopup();
    }
</script>
@endpush