@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    {{-- Tombol Kembali --}}
    <div class="mb-2 -mt-6">
        {{-- Mengarahkan tombol kembali ke rute berita.index --}}
        <a href="{{ route('berita.index') }}" class="text-black hover:text-gray-700 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="#AD1500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Image Banner Berita (dynamic) --}}
    @php
        // Menggunakan relasi fotoBeritas di model Berita untuk mendapatkan thumbnail
        $thumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
    @endphp
    @if($thumbnail)
    <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
        {{-- Menggunakan Storage::url() untuk mendapatkan URL gambar dari public disk --}}
        <img src="{{ Storage::url($thumbnail->nama_gambar) }}" alt="{{ $berita->judul_berita }}" class="w-full h-[400px] object-cover">
    </div>
    @else
    {{-- Default image jika tidak ada thumbnail --}}
    <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
        {{-- Asumsi Anda memiliki gambar default di public/images/default-berita.png --}}
        <img src="{{ asset('images/default-berita.png') }}" alt="Default Berita" class="w-full h-[400px] object-cover">
    </div>
    @endif

    {{-- Konten Artikel --}}
    <article class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $berita->judul_berita }}</h1>

        <div class="flex items-center text-gray-600 text-sm mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
            {{-- Menampilkan penulis berita, dengan fallback jika null --}}
            <span class="mr-4">{{ $berita->penulis ?? 'Admin Galery Apps' }}</span>

            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            {{-- Memformat tanggal dibuat, dengan fallback jika null --}}
            <span>{{ $berita->tanggal_dibuat ? $berita->tanggal_dibuat->format('d F Y') : '-' }}</span>
        </div>

        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {{-- Menampilkan isi berita, dengan {!! !!} karena berisi HTML dari CKEditor --}}
            {!! $berita->isi_berita !!}
        </div>
    </article>

    {{-- Berita Terkait dan Tag Populer (bisa kamu isi dinamis juga jika mau) --}}
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Bisa ditambahkan berita terkait dinamis di sini --}}
        <div class="md:col-span-2">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Berita Terkait</h2>
            <div class="space-y-6">
                {{-- Contoh hardcoded, bisa diganti dinamis --}}
                {{-- ... --}}
            </div>
        </div>
    </div>
</section>
@endsection
