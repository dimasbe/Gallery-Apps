@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
    {{-- Header dan Breadcrumbs --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Detail Berita</h1> 
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-700">Beranda</a>
                        <span class="mx-2 text-red-700 text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.berita.index') }}" class="hover:text-red-700">Berita</a>
                        <span class="mx-2 text-red-700 text-base">&bull;</span>
                    </li>
                    <li class="text-red-700" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 space-y-6">
    {{-- Informasi Utama --}}
    <div class="border border-gray-300 rounded-md p-4">
        <h2 class="text-xl font-bold text-red-800 mb-4 font-poppins">Informasi Utama</h2>
        <div class="grid md:grid-cols-2 gap-4">
            <div>
                <h3 class="font-semibold text-red-800 mb-1 font-poppins">Judul Berita</h3>
                <p class="text-gray-700">{{ $berita->judul_berita }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-red-800 mb-1 font-poppins">Kategori</h3>
                <p class="text-gray-700">{{ $berita->kategori->nama_kategori ?? 'N/A' }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-red-800 mb-1 font-poppins">Dibuat</h3>
                <p class="text-gray-700">{{ $berita->tanggal_dibuat ? $berita->tanggal_dibuat->format('Y-m-d H:i:s') : '-' }}</p>
            </div>

            <div>
                <h3 class="font-semibold text-red-800 mb-1 font-poppins">Diedit</h3>
                <p class="text-gray-700">{{ $berita->tanggal_diedit ? $berita->tanggal_diedit->format('Y-m-d H:i:s') : '-' }}</p>
            </div>
        </div>
    </div>

    {{-- Thumbnail --}}
    @php
        $thumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
    @endphp
    @if($thumbnail)
    <div class="border border-gray-300 rounded-md p-4">
        <h2 class="text-xl font-bold text-red-800 mb-4 font-poppins">Thumbnail</h2>
            <img src="{{ Storage::url($thumbnail->nama_gambar) }}" alt="Thumbnail Berita" class="w-full h-64 object-cover rounded-md shadow-md">
            @if($thumbnail->keterangan_gambar)
                <p class="text-gray-500 mt-2 italic">{{ $thumbnail->keterangan_gambar }}</p>
            @endif
        </div>
    @endif

    {{-- Isi Berita --}}
    <div class="border border-gray-300 rounded-md p-4">
        <h2 class="text-xl font-bold text-red-800 mb-4 font-poppins">Isi Berita</h2>
        <textarea readonly 
            class="w-full h-64 resize-none border border-gray-300 rounded-md p-4 text-gray-800 leading-relaxed font-poppins focus:outline-none focus:ring-2 focus:ring-red-500 bg-white overflow-auto"
        >{{ $berita->isi_berita }}</textarea>
    </div>

    {{-- Tombol Kembali --}}
    <div class="flex justify-end">
        <a href="{{ route('admin.berita.index') }}" 
           class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800 font-poppins">
            Kembali ke Daftar Berita
        </a>
    </div>

</div>
@endsection
