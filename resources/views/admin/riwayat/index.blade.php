@extends('layouts.admin')

@section('content')
    <!-- Navbar Riwayat + Breadcrumbs -->
    <div class="bg-white shadow-md rounded-xl px-6 py-4 mb-6 flex items-center justify-between">
        <!-- Judul Halaman -->
        <h1 class="text-2xl font-bold" style="color: #AD1500;">Riwayat</h1>


        <!-- Breadcrumbs Custom -->
        <nav class="text-sm text-gray-600" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="#" class="hover:underline hover:text-red-600 font-medium">Beranda</a>
                </li>
                <li>
                    <span class="text-red-600 text-lg">●</span>
                </li>
                <li>
                    <a href="#" class="hover:underline hover:text-red-600 font-medium">Riwayat</a>
                </li>
                <li>
                    <span class="text-red-600 text-lg">●</span>
                </li>
                <li class="text-gray-800 font-semibold capitalize">{{ request('status', 'diterima') }}</li>
            </ol>
        </nav>
    </div>

    <div class="p-6">
        <div class="bg-white shadow-md rounded-xl p-6">
            <!-- Tombol Switch Status -->
            <div class="flex justify-end mb-4">
                <div class="flex items-center space-x-3">
                    <a href="?status=diterima">
                        <button
                            class="px-5 py-2 rounded-2xl font-semibold 
                {{ request('status', 'diterima') == 'diterima' ? 'bg-red-700 text-white' : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                            Diterima
                        </button>
                    </a>
                    <a href="?status=ditolak">
                        <button
                            class="px-5 py-2 rounded-2xl font-semibold 
                {{ request('status') == 'ditolak' ? 'bg-red-700 text-white' : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                            Ditolak
                        </button>
                    </a>
                </div>
            </div>


            <!-- Tabel Riwayat -->
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm text-left border-separate border-spacing-y-4">
                    <thead class="text-gray-700">
                        <tr class="hover:bg-gray-100 transition duration-200">
                            @foreach (['No.', 'Nama Aplikasi', 'Pemilik', 'Kategori', 'Tanggal', 'Status', 'Aksi'] as $header)
                                <th class="align-middle text-center">
                                    <div
                                        class="bg-white px-4 py-3 rounded-lg shadow-sm w-full text-sm font-semibold text-gray-700 text-center">
                                        {{ $header }}
                                    </div>
                                </th>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @for ($i = 1; $i <= 5; $i++)
                            <tr class="hover:bg-gray-100 transition duration-200">
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm text-center w-full">
                                        {{ $i }}</div>
                                </td>
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm w-full">Mobile Legend</div>
                                </td>
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm w-full">Stevia Magdalena</div>
                                </td>
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm w-full">Permainan</div>
                                </td>
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm w-full">06 - 05 - 2025</div>
                                </td>
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm w-full">
                                        <span
                                            class="
                                        text-xs font-semibold px-3 py-1 rounded-full
                                        {{ request('status', 'diterima') == 'diterima' ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                                            {{ ucfirst(request('status', 'diterima')) }}
                                        </span>
                                    </div>
                                </td>
                                <td>
                                    <div class="bg-white px-4 py-3 rounded-lg shadow-sm w-full h-full">
                                        <div class="flex items-center justify-center gap-2 h-full">
                                            @if (request('status', 'diterima') == 'diterima')
                                                <button
                                                    class="bg-yellow-300 text-yellow-900 text-xs font-semibold px-3 py-1 rounded-lg hover:bg-yellow-400 transition">
                                                    Arsipkan
                                                </button>
                                            @else
                                                <button
                                                    class="bg-red-600 text-white text-xs font-semibold px-3 py-1 rounded-lg hover:bg-red-700 transition">
                                                    Hapus
                                                </button>
                                            @endif
                                            <button
                                                class="bg-blue-600 text-white text-xs font-semibold px-3 py-1 rounded-lg hover:bg-blue-700 transition">
                                                Lihat
                                            </button>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endfor
                    </tbody>
                </table>
            </div>

            <!-- Pagination + Rows per page -->
            <div class="mt-6 flex justify-end items-center space-x-6 text-sm text-gray-600">
                <div class="flex items-center">
                    <span class="mr-1">Rows per page:</span>
                    <button class="px-2 py-1 border border-gray-300 rounded">5 ▾</button>
                </div>
                <div class="flex items-center space-x-2">
                    <span>1–5 of 30</span>
                    <button class="text-gray-400 hover:text-gray-700">&lt;</button>
                    <button class="text-gray-400 hover:text-gray-700">&gt;</button>
                </div>
            </div>
        </div>
    </div>
@endsection