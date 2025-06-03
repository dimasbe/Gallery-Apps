@extends('layouts.admin')

@section('content')
    <!-- Wrapper Konten Utama -->
    <div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
        <!-- Navbar Riwayat + Breadcrumbs -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-red-700">Riwayat</h1>
                <nav aria-label="breadcrumb">
                    <ol class="flex items-center text-sm text-gray-600">
                        <li class="flex items-center">
                            <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                            <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                        </li>
                        <li class="flex items-center">
                            <a href="#" class="hover:text-custom-primary-red">Riwayat</a>
                            <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                        </li>
                        <li class="text-custom-primary-red capitalize" aria-current="page">
                            {{ request('status', 'semua') }}
                        </li>
                    </ol>
                </nav>
            </div>
        </div>

        <!-- Card Riwayat -->
        <div class="bg-white shadow-md rounded-xl p-6">
            <!-- Header dengan judul di kiri dan tombol filter di kanan -->
            <div class="flex justify-between items-center mb-4">
                <!-- Judul -->
                <h1 class="text-2xl font-bold text-custom-primary-red">Manajemen Riwayat</h1>

                <!-- Tombol Switch Status -->
                <div class="flex items-center space-x-3">
                    <a href="?status=semua">
                        <button
                            class="px-5 py-2 rounded-2xl font-semibold 
                    {{ request('status', 'semua') == 'semua' ? 'bg-red-700 text-white' : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                            Semua
                        </button>
                    </a>
                    <a href="?status=diterima">
                        <button
                            class="px-5 py-2 rounded-2xl font-semibold 
                    {{ request('status') == 'diterima' ? 'bg-red-700 text-white' : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                            Terima
                        </button>
                    </a>
                    <a href="?status=ditolak">
                        <button
                            class="px-5 py-2 rounded-2xl font-semibold 
                    {{ request('status') == 'ditolak' ? 'bg-red-700 text-white' : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                            Tolak
                        </button>
                    </a>
                    <a href="?status=arsip">
                        <button
                            class="px-5 py-2 rounded-2xl font-semibold 
                    {{ request('status') == 'arsip' ? 'bg-red-700 text-white' : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                            Arsip
                        </button>
                    </a>
                </div>
            </div>

            <!-- Tabel Riwayat -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                No.
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Nama Aplikasi
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Pemilik
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Kategori
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Tanggal
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Status
                            </th>
                            <th
                                class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @php
                            $statuses = ['diterima', 'ditolak'];
                            $currentStatus = request('status', 'diterima');
                            $loopStatuses = $currentStatus == 'semua' ? $statuses : [$currentStatus];
                        @endphp

                        @php $no = 1; @endphp
                        @foreach ($loopStatuses as $status)
                            @for ($i = 1; $i <= 3; $i++)
                                {{-- Ubah 3 jika ingin banyak data dummy per status --}}
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition duration-150">
                                    <td class="px-5 py-4 text-center">{{ $no++ }}</td>
                                    <td class="px-5 py-4">Mobile Legend</td>
                                    <td class="px-5 py-4">Stevia Magdalena</td>
                                    <td class="px-5 py-4">Permainan</td>
                                    <td class="px-5 py-4">06 - 05 - 2025</td>
                                    <td class="px-5 py-4">
                                        <span
                                            class="text-xs font-medium px-3 py-1 rounded-full
                        {{ $status == 'diterima' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                                            {{ ucfirst($status) }}
                                        </span>
                                    </td>
                                    <td class="px-5 py-4">
                                        <div class="flex justify-center gap-2">
                                            @if ($status == 'diterima')
                                                <button onclick="showArsipPopup()"
                                                    class="bg-yellow-300 hover:bg-yellow-400 text-yellow-900 text-xs font-semibold px-3 py-1 rounded-lg transition">
                                                    Arsipkan
                                                </button>
                                            @else
                                                <button onclick="showHapusPopup()" 
                                                    class="bg-red-600 hover:bg-red-700 text-white text-xs font-semibold px-3 py-1 rounded-lg transition">
                                                    Hapus
                                                </button>
                                            @endif
                                            <button
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-semibold px-3 py-1 rounded-lg transition">
                                                Lihat
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                            @endfor
                        @endforeach
                    </tbody>

                </table>
            </div>

            <!-- Pagination Statis (Sekarang di dalam card) -->
            <div class="flex justify-between items-center mt-6">
                <div class="text-sm text-gray-600">
                    Rows per page:
                    <select id="rows-per-page"
                        class="ml-2 border border-gray-300 rounded-md py-1 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="30">30</option>
                    </select>
                </div>
                <div id="pagination-info" class="text-sm text-gray-600">
                    1-10 of 30
                </div>
                <div class="flex space-x-2">
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <button
                        class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div id="arsip-popup-overlay"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto text-center">
            <i class="fas fa-archive text-yellow-500 text-6xl mb-4"></i>
            <h2 class="text-base font-bold text-gray-800 mb-4">Apakah Anda yakin ingin mengarsipkan data ini?</h2>
            <div class="flex justify-center space-x-4">
                {{-- Tombol Batal --}}
                <button
                    class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 py-1 px-4 rounded-lg transition duration-200 w-20"
                    onclick="hideArsipPopup()">Batal</button>
                {{-- Tombol Arsipkan --}}
                <button
                    class="bg-yellow-500 hover:bg-yellow-600 text-white py-1 px-4 rounded-lg transition duration-200 w-24"
                    onclick="submitArsip()">Arsipkan</button>
            </div>
        </div>
    </div>
    <div id="hapus-popup-overlay"
        class="fixed inset-0 bg-gray-800 bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto text-center">
            <i class="fas fa-trash-alt text-red-500 text-6xl mb-4"></i>
            <h2 class="text-base font-bold text-gray-800 mb-4">Apakah Anda yakin ingin menghapus data ini?</h2>
            <p class="text-sm text-gray-500 mb-4">Data yang dihapus tidak dapat dikembalikan.</p>
            <div class="flex justify-center space-x-4">
                <!-- Tombol Batal -->
                <button
                    class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 py-1 px-4 rounded-lg transition duration-200 w-20"
                    onclick="hideHapusPopup()">Batal</button>
                <!-- Tombol Hapus -->
                <button class="bg-red-500 hover:bg-red-600 text-white py-1 px-4 rounded-lg transition duration-200 w-24"
                    onclick="alert('Data berhasil dihapus!'); hideHapusPopup();">Hapus</button>
            </div>
        </div>
    </div>


    <script>
        function showArsipPopup() {
            document.getElementById('arsip-popup-overlay').classList.remove('hidden');
        }

        function hideArsipPopup() {
            document.getElementById('arsip-popup-overlay').classList.add('hidden');
        }

        function showHapusPopup() {
            document.getElementById('hapus-popup-overlay').classList.remove('hidden');
        }

        function hideHapusPopup() {
            document.getElementById('hapus-popup-overlay').classList.add('hidden');
        }
    </script>
@endsection

