@extends('layouts.admin') {{-- Memastikan halaman ini menggunakan layout admin Anda --}}

@section('title', 'Arsip') {{-- INI YANG HARUS ANDA UBAH/TAMBAHKAN --}}

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen"> {{-- Padding dan background untuk area konten utama --}}

    {{-- KARTU PUTIH UNTUK HEADER & BREADCRUMB --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6"> {{-- Card putih baru untuk header, dengan bayangan dan sudut membulat --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Arsip</h1> {{-- Judul utama halaman --}}
            <div class="flex mx-8">
            <div class="flex w-64 md:w-80">
                <input
                    type="text"
                    placeholder="Cari di sini..."
                    class="flex-grow px-4 py-2 rounded-l-md border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
                />
                <button
                    class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-md hover:bg-[#f5f5f5] focus:outline-none"
                >
                    <i class="fas fa-search text-custom-primary-red"></i>
                </button>
            </div>
        </div>
            <!-- <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Arsip</li>
                </ol>
            </nav> -->
        </div>
    </div>

    {{-- Kartu (Card) yang Membungkus Tabel Arsip --}}
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
                    @if(count($arsip) > 0)
                        @foreach($arsip as $data)
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
                                    <a href="{{ route('admin.arsip.show', $data['id']) }}"
                                    class="bg-blue-700 hover:bg-blue-800 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">
                                        Lihat
                                    </a>
                                    <button class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200">Tampilkan</button>
                                    <button class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm transition duration-200"
                                            onclick="showDeletePopup()">
                                            Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                Tidak ada data arsip.
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

{{-- Pop-up Hapus --}}
{{-- Ubah ID overlay untuk konsistensi --}}
<div id="delete-popup-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
  <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto text-center">
    <div class="text-red-600 mb-4">
      <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M10 11V17M14 11V17M6 7L6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7M9 7V4H15V7" />
      </svg>
    </div>

    <p class="text-gray-800 text-lg font-semibold mb-6">Apakah Anda yakin ingin menghapus aplikasi ini?</p>

    <div class="flex justify-center space-x-4">
      <button class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 font-medium py-1.5 px-4 rounded-md transition duration-200"
              onclick="hideDeletePopup()">Batal</button>
      <button class="bg-red-700 hover:bg-red-800 text-white font-medium py-1.5 px-4 rounded-md transition duration-200"
              onclick="submitDelete()">Hapus</button>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan pop-up Delete
    function showDeletePopup() {
        console.log('Tombol Hapus diklik! Menampilkan pop-up...'); // Untuk debugging
        document.getElementById('delete-popup-overlay').classList.remove('hidden');
    }

    // Fungsi untuk menyembunyikan pop-up Delete
    function hideDeletePopup() {
        console.log('Menyembunyikan pop-up...'); // Untuk debugging
        document.getElementById('delete-popup-overlay').classList.add('hidden');
        // Tidak perlu membersihkan reject-notes karena tidak ada di pop-up ini
    }

    // Fungsi untuk menangani saat tombol 'Hapus' di pop-up diklik
    function submitDelete() {
        // Di sini Anda akan menambahkan logika untuk mengirim permintaan DELETE ke server
        // Misalnya menggunakan fetch API atau form submit tersembunyi
        console.log('Mengirim permintaan hapus...'); // Untuk debugging
        alert('Aplikasi akan dihapus!'); // Contoh feedback
        hideDeletePopup(); // Sembunyikan pop-up setelah aksi
    }
</script>
@endpush