@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    {{-- Tombol Kembali --}}
    <div class="mb-2 -mt-6">
        <a href="{{ route('berita.index') }}" class="text-black hover:text-gray-700 flex items-center">
            <svg class="w-4 h-4 mr-1" fill="none" stroke="#AD1500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
            </svg>
            Kembali
        </a>
    </div>

    {{-- Grid Layout untuk Artikel & Berita Terkait --}}
    <div class="grid lg:grid-cols-3 gap-8 mt-8">
        {{-- Konten Artikel --}}
        <article class="lg:col-span-2 bg-white rounded-lg shadow-md p-8">
        {{-- Image Banner Berita (dynamic) --}}
        @php
            $thumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
        @endphp
        @if($thumbnail)
        <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
            <img src="{{ Storage::url($thumbnail->nama_gambar) }}" alt="{{ $berita->judul_berita }}" class="w-full h-[400px] object-cover">
        </div>
        @else
        {{-- Default image jika tidak ada thumbnail --}}
        <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
            <img src="{{ asset('images/default-berita.png') }}" alt="Default Berita" class="w-full h-[400px] object-cover">
        </div>
        @endif
            <h1 class="text-4xl font-bold text-gray-900 mb-4">{{ $berita->judul_berita }}</h1>

            <div class="flex items-center text-gray-600 text-sm mb-6">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="#AD1500" viewBox="0 0 24 24" 
                    xmlns="http://www.w3.org/2000/svg" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" y1="7" x2="21" y2="7" />
                    <line x1="3" y1="12" x2="21" y2="12" />
                    <line x1="3" y1="17" x2="21" y2="17" />
                </svg>
                <span class="mr-4">{{ $berita->kategori->nama_kategori ?? 'Admin Galery Apps' }}</span>
                
                <svg class="w-4 h-4 mr-2" fill="none" stroke="#AD1500" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <span>{{ $berita->tanggal_dibuat ? $berita->tanggal_dibuat->format('d F Y') : '-' }}</span>
            </div>

        <div class="prose max-w-none text-gray-800 leading-relaxed">
            {!! $berita->isi_berita !!}
        </div>
    </article>

        {{-- Berita Terkait --}}
        <aside>
            <h3 class="text-xl font-semibold mb-4 border-b-2 border-[#AD1500] pb-2">Berita Terkait</h3>
            <div class="space-y-6">
                @forelse ($beritaTerkait as $terkait)
                    <article class="flex space-x-4 items-start">
                        <img src="{{ $terkait->thumbnail_url }}" alt="{{ $terkait->judul_berita }}" class="w-24 h-16 object-cover rounded-md flex-shrink-0" />
                        <div>
                            <a href="{{ route('berita.show', $terkait->id) }}" class="font-semibold text-[#AD1500] hover:underline">
                                {{ Str::limit($terkait->judul_berita, 50) }}
                            </a>
                            <p class="text-xs text-gray-600">{{ $terkait->tanggal_dibuat->format('d F Y') }}</p>
                            <p class="text-sm text-gray-700 mt-1">{{ Str::limit(strip_tags($terkait->isi_berita), 100) }}</p>
                        </div>
                    </article>
                @empty
                    <p class="text-sm text-gray-500">Belum ada berita terkait.</p>
                @endforelse
            </div>
        </aside>
    </div>
</section>
@endsection
