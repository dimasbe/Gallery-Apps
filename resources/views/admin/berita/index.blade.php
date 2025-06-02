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
        {{-- Main container for the header row --}}
        <div class="flex items-center mb-4">
            {{-- Left-aligned text --}}
            <h1 class="text-xl font-bold text-custom-primary-red">Manajemen Berita</h1>
        
            {{-- Center-aligned text. flex-grow makes it take available space, text-center centers the content within it. --}}
            <div class="flex-grow text-center">
                <h2 class="text-xl font-bold text-black-1000">Daftar Berita</h2>
            </div>
        
            {{-- Right-aligned buttons group. space-x-6 applied here for distance between filter group and 'Tambah' button --}}
            <div class="flex space-x-4">
                </div>
                {{-- 'Tambah' button --}}
                <a href="{{ route('admin.berita.create') }}" class="bg-custom-primary-red text-white px-4 py-2 rounded-md hover:bg-custom-primary-red-darker transition duration-200">
                    <i class="fas fa-plus mr-2"></i> Tambah Berita
                </a>
            </div>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden">
                <thead>
                    <tr>
                        <th class="py-3 px-4 bg-gray-50 text-left text-s font-semibold text-black tracking-wider rounded-tl-lg">No.</th>
                        <th class="py-3 px-4 bg-gray-50 text-left text-s font-semibold text-black tracking-wider">Thumbnail</th>
                        <th class="py-3 px-4 bg-gray-50 text-left text-s font-semibold text-black tracking-wider">Judul Berita</th>
                        <th class="py-3 px-4 bg-gray-50 text-left text-s font-semibold text-black tracking-wider">Penulis</th>
                        <th class="py-3 px-4 bg-gray-50 text-left text-s font-semibold text-black tracking-wider">Tanggal Dibuat</th>
                        <th class="py-3 px-4 bg-gray-50 text-left text-s font-semibold text-black tracking-wider rounded-tr-lg">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($beritas as $berita)
                        <tr>
                            <td class="py-4 px-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="py-4 px-4 text-sm text-gray-700">
                                <img src="{{ $berita->thumbnail_url }}" alt="Thumbnail Berita" class="w-16 h-16 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="py-4 px-4 text-sm text-gray-700 font-medium">{{ $berita->judul_berita }}</td>
                            <td class="py-4 px-4 text-sm text-gray-700">{{ $berita->penulis }}</td>
                            <td class="py-4 px-4 text-sm text-gray-700">{{ $berita->tanggal_dibuat->format('d M Y H:i') }}</td>
                            <td class="py-4 px-4 text-sm text-gray-700">
                                <div class="action-buttons">
                                    <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-info text-s">Detail</a>
                                    <a href="{{ route('admin.berita.edit', $berita->id) }}" class="btn btn-warning text-s">Edit</a>
                                    <form action="{{ route('admin.berita.destroy', $berita->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus berita ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger text-s">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-4 px-4 text-center text-gray-500">Tidak ada berita yang tersedia.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection