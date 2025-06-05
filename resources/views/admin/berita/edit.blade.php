@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-800">Edit Berita</h1>
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
                    <li class="text-custom-primary-red" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        {{-- Validasi Error --}}
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Flash Error --}}
        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Judul Berita -->
            <div>
                <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                <input type="text" name="judul_berita" id="judul_berita"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    value="{{ old('judul_berita', $berita->judul_berita) }}" required>
            </div>

            <!-- Penulis -->
            <div>
                <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
                <input type="text" name="penulis" id="penulis"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    value="{{ old('penulis', $berita->penulis) }}" required>
            </div>

            <!-- Kategori (multiple) -->
            <div>
    <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
    <select name="kategori_id" id="kategori_id"
        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
        required>
        <option value="" disabled {{ old('kategori_id', $berita->kategori_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
        @foreach ($kategori as $item)
            <option value="{{ $item->id }}"
                {{ old('kategori_id', $berita->kategori_id ?? '') == $item->id ? 'selected' : '' }}>
                {{ $item->nama_kategori }}
            </option>
        @endforeach
    </select>
</div>


            <!-- Thumbnail -->
            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Unggah Thumbnail Berita</label>
                <input type="file" name="thumbnail" id="thumbnail"
                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none"
                    accept="image/*" onchange="previewImage(event, 'thumbnail-preview')">
                @php
                    $currentThumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
                @endphp
                <div id="thumbnail-preview" class="mt-2">
                    <img src="{{ $currentThumbnail ? asset('storage/' . $currentThumbnail->nama_gambar) : 'https://placehold.co/100x100?text=No+Thumbnail' }}"
                        alt="Thumbnail" class="w-24 h-24 object-cover rounded-md">
                </div>
            </div>

            <!-- Isi Berita -->
            <div>
                <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                <textarea name="isi_berita" id="isi_berita" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    required>{{ old('isi_berita', $berita->isi_berita) }}</textarea>
            </div>

            <!-- Tombol -->
            <div class="pt-6 flex justify-end space-x-4">
            <a href="{{ route('admin.berita.index') }}"
        class="inline-flex justify-center py-2 px-5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
        Batal
    </a>
                <button type="submit"
                    class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function previewImage(event, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = '';

        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover rounded-md mt-2">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    }
</script>
@endsection
