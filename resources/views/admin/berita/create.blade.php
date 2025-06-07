@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-800">Berita</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.berita.index') }}" class="hover:text-custom-primary-red">Berita</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold mb-6 text-red-800 text-center">Formulir Berita</h1>

        {{-- FORM MULAI --}}
        <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
    @csrf

    <!-- Judul Berita -->
    <div>
        <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
        <input type="text" name="judul_berita" id="judul_berita"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
            value="{{ old('judul_berita') }}">
        @error('judul_berita')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Kategori -->
    <div>
        <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
        <select name="kategori_id" id="kategori_id"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
            <option value="">Pilih Kategori</option>
            @foreach($kategori as $item)
                <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
                    {{ $item->nama_kategori }}
                </option>
            @endforeach
        </select>
        @error('kategori_id')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Thumbnail -->
    <div>
        <label for="thumbnail" class="block text-sm font-medium text-gray-700">Unggah Thumbnail Berita</label>
        <input type="file" name="thumbnail" id="thumbnail"
            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none"
            accept="image/*">
        @error('thumbnail')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Isi Berita -->
    <div>
        <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
        <textarea name="isi_berita" id="isi_berita" rows="4"
            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
            >{{ old('isi_berita') }}</textarea>
        @error('isi_berita')
            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
        @enderror
    </div>

    <!-- Tombol -->
    <div class="pt-6 flex justify-end space-x-4">
        <a href="{{ route('admin.berita.index') }}"
            class="inline-flex justify-center py-2 px-5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
            Batal
        </a>
        <button type="submit"
            class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
            Simpan
        </button>
    </div>
</form>

        {{-- FORM SELESAI --}}
    </div>
</div>
@endsection
