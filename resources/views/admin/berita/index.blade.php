@extends('layouts.admin')

@section('content')
<!-- Wrapper Konten Utama -->
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <!-- Navbar Riwayat + Breadcrumbs -->
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Berita</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Berita</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- Header --}}
        <div class="flex justify-between items-center mb-4">
            <h1 class="text-xl font-bold text-custom-primary-red">Daftar Berita</h1>
            <a href="{{ route('admin.berita.create') }}" 
               class="bg-custom-primary-red text-white px-4 py-2 rounded-md hover:bg-custom-primary-red-darker transition duration-200">
                <i class="fas fa-plus mr-2"></i> Tambah Berita
            </a>
        </div>

        {{-- Alert success/error --}}
        @if (session('success'))
            <script>alert("{{ session('success') }}");</script>
        @endif
        @if (session('error'))
            <script>alert("{{ session('error') }}");</script>
        @endif

        {{-- Tabel Berita --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider rounded-tl-lg">
                            No.
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Thumbnail
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Judul Berita
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Penulis
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal Rilis
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal Update
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider rounded-tr-lg">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($berita as $item)
                        <tr>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                <img src="{{ $item->thumbnail_url }}" alt="Thumbnail Berita" class="w-16 h-16 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700 font-medium">{{ $item->judul_berita }}</td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">{{ $item->penulis }}</td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                {{ $item->tanggal_dibuat ? $item->tanggal_dibuat->format('d M Y') : '-' }}
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                {{ $item->tanggal_diedit ? $item->tanggal_diedit->format('d M Y') : '-' }}
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('admin.berita.show', $item->id) }}" 
                                       class="bg-blue-600 border border-blue-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $item->id) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold py-1 px-3 rounded shadow">
                                        Edit
                                    </a>
                                    <form action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" 
                                            class="bg-red-700 border border-red-800 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-gray-500">Tidak ada berita yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- Pagination (Statis) --}}
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600">
                Rows per page:
                <select id="rows-per-page" class="ml-2 border border-gray-300 rounded-md py-2 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red">
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
@endsection
