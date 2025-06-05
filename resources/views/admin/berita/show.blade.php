@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-800">Detail Berita</h1>
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
                    <li class="text-custom-primary-red" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        {{-- Kolom Info Detail Berita --}}
        <div class="bg-white shadow-md rounded-md overflow-hidden border border-gray-300 p-6 space-y-4">
            <div>
                <h2 class="font-semibold text-red-800 mb-1">Judul Berita</h2>
                <p class="text-gray-700">{{ $berita->judul_berita }}</p>
            </div>

            <div>
                <h2 class="font-semibold text-red-800 mb-1">Penulis</h2>
                <p class="text-gray-700">{{ $berita->penulis }}</p>
            </div>

            <div>
                <h2 class="font-semibold text-red-800 mb-1">Kategori</h2>
                <p class="text-gray-700">{{ $berita->kategori->nama_kategori ?? 'N/A' }}</p>
            </div>

            <div>
                <h2 class="font-semibold text-red-800 mb-1">Dibuat</h2>
                <p class="text-gray-700">{{ $berita->tanggal_dibuat ? $berita->tanggal_dibuat->format('Y-m-d H:i:s') : '-' }}</p>
            </div>

            <div>
                <h2 class="font-semibold text-red-800 mb-1">Diedit</h2>
                <p class="text-gray-700">{{ $berita->tanggal_diedit ? $berita->tanggal_diedit->format('Y-m-d H:i:s') : '-' }}</p>
            </div>
        </div>

        {{-- Thumbnail --}}
        @php
            $thumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
        @endphp
        @if($thumbnail)
            <div class="mt-8">
                <h2 class="text-2xl font-semibold text-red-800 mb-2">Thumbnail</h2>
                <img src="{{ Storage::url($thumbnail->nama_gambar) }}" alt="Thumbnail Berita" class="w-full h-64 object-cover rounded-md shadow-md">
                @if($thumbnail->keterangan_gambar)
                    <p class="text-gray-500 mt-2">{{ $thumbnail->keterangan_gambar }}</p>
                @endif
            </div>
        @endif

        {{-- Isi Berita --}}
        <div class="mt-8">
            <h2 class="text-2xl font-semibold text-red-800 mb-4">Isi Berita</h2>
            <article class="prose max-w-none">
                {!! $berita->isi_berita !!}
            </article>
        </div>

        {{-- Tombol Kembali --}}
        <div class="mt-10 flex justify-end">
            <a href="{{ route('admin.berita.index') }}" 
               class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</div>
@endsection
