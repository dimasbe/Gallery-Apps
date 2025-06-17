@extends('layouts.admin') {{-- Memastikan halaman ini menggunakan layout admin Anda --}}

@section('title', 'Verifikasi') {{-- Mengatur judul halaman pada tab browser --}}

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen"> {{-- Padding dan background untuk area konten utama --}}

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
                    {{-- Data untuk Tabel, diambil dari Controller --}}
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
                                    <button class="bg-green-500 hover:bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-lg shadow-sm transition duration-200"
                                            data-id="{{ $data['id'] }}"
                                            data-url="{{ route('admin.aplikasi.terima', ['id' => $data['id']]) }}"
                                            onclick="showAcceptPopup(this)">Terima</button>
                                    <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-lg shadow-sm transition duration-200"
                                            data-id="{{ $data['id'] }}"
                                            data-url="{{ route('admin.aplikasi.tolak', ['id' => $data['id']]) }}"
                                            onclick="showRejectPopup(this)">Tolak</button>
                                    <a href="{{ route('admin.verifikasi.detail', ['id' => $data['id']]) }}"
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

        {{-- Bagian Pagination (Statis - Anda mungkin perlu membuatnya dinamis jika menggunakan paginasi Laravel) --}}
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
                {{-- Contoh: 1-10 of 30 (Ini perlu diisi secara dinamis jika ada paginasi) --}}
                @if(count($aplikasi) > 0)
                    Menampilkan 1 - {{ count($aplikasi) }} dari {{ count($aplikasi) }} data
                @else
                    Tidak ada data
                @endif
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

{{-- Form tersembunyi untuk aksi Tolak, akan digunakan oleh SweetAlert --}}
<form id="reject-form" method="POST" style="display: none;">
    @csrf
    {{-- Input tersembunyi untuk alasan penolakan, akan diisi oleh SweetAlert --}}
    <input type="hidden" name="alasan_penolakan" id="hidden-reject-reason">
</form>

{{-- Form tersembunyi untuk aksi Terima, akan digunakan oleh SweetAlert --}}
<form id="accept-form" method="POST" style="display: none;">
    @csrf
</form>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    @if (session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: @json(session('success')),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500
        });
    @elseif (session('error'))
        Swal.fire({
            icon: 'error',
            title: 'Gagal!',
            text: @json(session('error')),
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500
        });
    @endif

    @error('alasan_penolakan')
        Swal.fire({
            icon: 'error',
            title: 'Validasi Gagal!',
            text: @json($message),
            confirmButtonColor: '#ED125F' // Atau warna lain yang sesuai
        });
    @enderror

    // --- Fungsi untuk Pop-up Tolak Ajuan menggunakan SweetAlert ---
    function showRejectPopup(button) {
        const linkAction = button.getAttribute('data-url');
        const aplikasiNama = button.closest('tr').querySelector('td:nth-child(2) p').textContent;

        Swal.fire({
            title: `Tolak Aplikasi "${aplikasiNama}"?`,
            input: 'textarea',
            inputLabel: 'Alasan Penolakan',
            inputPlaceholder: 'Masukkan alasan penolakan di sini...',
            inputAttributes: {
                'aria-label': 'Masukkan alasan penolakan di sini',
                'rows': 4
            },
            showCancelButton: true,
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            confirmButtonColor: '#d33', // Warna merah untuk konfirmasi tolak
            cancelButtonColor: '#3085d6', // Warna biru untuk batal
            showLoaderOnConfirm: true,
            preConfirm: (reason) => {
                if (!reason || reason.trim() === '') {
                    Swal.showValidationMessage(`Alasan penolakan wajib diisi`);
                }
                return reason;
            },
            allowOutsideClick: () => !Swal.isLoading()
        }).then((result) => {
            if (result.isConfirmed) {
                const reason = result.value;
                const form = document.getElementById('reject-form');
                const hiddenReasonInput = document.getElementById('hidden-reject-reason');

                if (form && hiddenReasonInput) {
                    form.action = linkAction;
                    hiddenReasonInput.value = reason;
                    form.submit();
                } else {
                    console.error('Form atau input alasan penolakan tidak ditemukan.');
                    Swal.fire('Error!', 'Terjadi kesalahan internal.', 'error');
                }
            }
        });
    }

    // --- Fungsi untuk Pop-up Terima Ajuan menggunakan SweetAlert ---
    function showAcceptPopup(button) {
        const linkAction = button.getAttribute('data-url');
        const aplikasiNama = button.closest('tr').querySelector('td:nth-child(2) p').textContent;

        Swal.fire({
            title: 'Konfirmasi Penerimaan',
            text: `Apakah Anda yakin ingin menerima aplikasi "${aplikasiNama}"?`,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#16a34a', // Warna hijau untuk konfirmasi
            cancelButtonColor: '#d33',    // Warna merah untuk batal
            confirmButtonText: 'Ya, Terima!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                const form = document.getElementById('accept-form');
                if (form) {
                    form.action = linkAction; // Set action URL untuk form
                    form.submit();          // Submit form
                } else {
                    console.error('Form dengan ID "accept-form" tidak ditemukan.');
                    Swal.fire('Error!', 'Terjadi kesalahan internal.', 'error');
                }
            }
        });
    }

    // Event listener untuk DOMContentLoaded (jika ada inisialisasi lain yang diperlukan)
    document.addEventListener('DOMContentLoaded', function() {
        // Tidak ada lagi event listener untuk pop-up HTML karena sudah diganti SweetAlert
    });
</script>
@endpush
