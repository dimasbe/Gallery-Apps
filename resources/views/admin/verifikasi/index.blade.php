@extends('layouts.admin') {{-- Memastikan halaman ini menggunakan layout admin Anda --}}

@section('title', 'Verifikasi') {{-- Mengatur judul halaman pada tab browser --}}

@section('content')
<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen"> {{-- Padding dan background untuk area konten utama --}}

    {{-- KARTU PUTIH UNTUK HEADER & BREADCRUMB --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6"> {{-- Card putih baru untuk header, dengan bayangan dan sudut membulat --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Verifikasi</h1> {{-- Judul utama halaman --}}
            <div class="flex mx-8">
    {{-- Form Pencarian --}}
    <form id="search-form" action="{{ route('admin.verifikasi') }}" method="GET" class="flex w-64 md:w-80">
        <input
            type="text"
            name="keyword" {{-- Ini penting! Untuk mengirim nilai ke controller --}}
            id="search-input" {{-- Tambahkan ID untuk referensi JS jika dibutuhkan --}}
            placeholder="Cari di sini..."
            class="flex-grow px-4 py-2 rounded-l-md border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
            value="{{ request('keyword') }}" {{-- Menjaga nilai input tetap ada setelah pencarian --}}
        />
        <button
            type="submit" {{-- Ini penting! Agar tombol bisa mengirim form --}}
            class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-md hover:bg-[#f5f5f5] focus:outline-none"
        >
            <i class="fas fa-search text-custom-primary-red"></i>
        </button>
    </form>
</div>
            <!-- <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Verifikasi</li>
                </ol>
            </nav> -->
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
                    @if(count($aplikasi) > 0)
                        @foreach($aplikasi as $data)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $loop->iteration }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data['nama_aplikasi'] }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data['nama_pemilik'] }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data['tanggal_ditambahkan'] }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <div class="flex space-x-2 justify-center">
                                    {{-- Tombol Diterima sekarang memicu pop-up `showAcceptPopup()` --}}
                                    <button class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-lg shadow-sm transition duration-200"
                                            data-id={{ $data['id'] }}
                                            data-url="{{ route('admin.aplikasi.terima', ['id' => $data['id']]) }}"
                                            onclick="showAcceptPopup(this)">Terima</button>
                                    <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-lg shadow-sm transition duration-200"
                                            data-id={{ $data['id'] }}
                                            data-url="{{ route('admin.aplikasi.tolak', ['id' => $data['id']]) }}"
                                            onclick="showRejectPopup(this)">Tolak</button>
                                    {{-- PERUBAHAN DI SINI: Mengubah button menjadi <a> dan menambahkan href --}}
                                    <a href="{{ route('admin.verifikasi.detail', ['id' => $data['id']]) }}" {{-- Menggunakan route helper dengan ID dummy --}}
                                       class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold py-1 px-2 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                        Lihat
                                    </a>
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
<div id="reject-popup-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto">
        <form id="reject-form" method="post">
            @csrf

            <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">Tolak Ajuan</h2>
            <div class="mb-4">
                <label for="reject-notes" class="block text-gray-700 text-sm font-bold mb-2">Catatan</label>
                <textarea id="reject-notes" rows="4" name="alasan_penolakan"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline resize-none"
                    placeholder="Aplikasi tidak sesuai kriteria..."></textarea>
            </div>
            <div class="flex justify-end space-x-4">
                {{-- Tombol Batal --}}
                <button class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 py-1 px-4 rounded-lg transition duration-200 w-20"
                        onclick="hideRejectPopup()">Batal</button>
                {{-- Tombol Kirim --}}
                <button type="submit" class="bg-custom-primary-red hover:bg-custom-primary-red-darker text-white py-1 px-4 rounded-lg transition duration-200 w-20">Kirim</button>
            </div>
        </form>
    </div>
</div>

{{-- Pop-up Terima Ajuan --}}
<div id="accept-popup-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
    <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto text-center">
        <i class="fas fa-check-circle text-green-500 text-6xl mb-4"></i>
        <h2 class="text-base font-bold text-gray-800 mb-4">Apakah Anda yakin ingin menerima aplikasi ini?</h2>
        <div class="flex justify-center space-x-4">
            {{-- Tombol Batal --}}
            <button class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 py-1 px-4 rounded-lg transition duration-200 w-20"
                    onclick="hideAcceptPopup()">Batal</button>
            {{-- Tombol Terima --}}
            <form id="accept-form" method="POST">
                @csrf
                <button class="bg-custom-primary-red hover:bg-custom-primary-red-darker text-white py-1 px-4 rounded-lg transition duration-200 w-20"
                        onclick="submitAccept()" type="submit" data-url="{{ route('admin.aplikasi.terima', ['id' => 'ID_REPLACE']) }}">Terima</button>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            // confirmButtonColor: '#ED125F'
            showConfirmshowConfirmButton: false,
            timer: 3000
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: @json(session('error')),
            // confirmButtonColor: '#ED125F'
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    @error('alasan_penolakan')
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            text: @json($message),
            confirmButtonColor: '#ED125F'
        });
    @enderror

    let selectedId = null;
    let linkAction = '';

    // --- Fungsi untuk Pop-up Tolak Ajuan ---
    function showRejectPopup(button) {
        selectedId = button.getAttribute('data-id') || null;
        linkAction = button.getAttribute('data-url') || null;
        
        const form = document.getElementById('reject-form');
        form.action = linkAction

        console.log('Tombol Ditolak diklik! Menampilkan pop-up...');
        document.getElementById('reject-popup-overlay').classList.remove('hidden');
    }

    function hideRejectPopup() {
        console.log('Menyembunyikan pop-up Ditolak...');
        document.getElementById('reject-popup-overlay').classList.add('hidden');
        document.getElementById('reject-notes').value = ''; // Bersihkan textarea
    }

    // --- Fungsi untuk Pop-up Terima Ajuan ---
    function showAcceptPopup(button) {
        selectedId = button.getAttribute('data-id') || null;
        linkAction = button.getAttribute('data-url') || null;
        
        const form = document.getElementById('accept-form');
        form.action = linkAction
        
        console.log('Tombol Diterima diklik! Menampilkan pop-up...');
        document.getElementById('accept-popup-overlay').classList.remove('hidden');
    }

    function hideAcceptPopup() {
        console.log('Menyembunyikan pop-up Diterima...');
        document.getElementById('accept-popup-overlay').classList.add('hidden');
    }

    // --- Opsional: Menutup pop-up saat mengklik di luar area modal ---
    document.addEventListener('DOMContentLoaded', function() {
        const rejectPopupOverlay = document.getElementById('reject-popup-overlay');
        const acceptPopupOverlay = document.getElementById('accept-popup-overlay');

        if (rejectPopupOverlay) {
            rejectPopupOverlay.addEventListener('click', function(event) {
                if (event.target === rejectPopupOverlay) {
                    hideRejectPopup();
                }
            });
        }

        if (acceptPopupOverlay) {
            acceptPopupOverlay.addEventListener('click', function(event) {
                if (event.target === acceptPopupOverlay) {
                    hideAcceptPopup();
                }
            });
        }
    });
</script>
@endpush