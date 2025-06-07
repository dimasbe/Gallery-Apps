@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-7xl px-6">
    <div class="flex space-x-8">

        {{-- Sidebar Kategori --}}
        <aside class="w-48 self-start flex-shrink-0">
            <div class="bg-white rounded-lg shadow p-3 max-h-[30rem] overflow-y-auto sticky top-10">
                <h3 class="text-lg font-semibold border-b-2 border-[#AD1500] pb-2 mb-5">Kategori Berita</h3>
                <ul class="space-y-3 text-sm font-medium text-gray-700">
                <li>
                    <a href="{{ route('berita.index') }}" class="hover:text-[#AD1500] transition-colors">
                        Semua
                    </a>
                </li>
                @foreach ($kategoris as $kategori)
                    <li>
                        <a href="{{ route('berita.index', ['kategori' => $kategori->id]) }}" 
                        class="hover:text-[#AD1500] transition-colors {{ request('kategori') == $kategori->id ? 'font-bold text-[#AD1500]' : '' }}">
                            {{ $kategori->nama_kategori }}
                        </a>
                    </li>
                @endforeach
            </ul>
            </div>
        </aside>

        {{-- Konten Berita --}}
        <section class="flex flex-col space-y-8 w-full px-4">
            @foreach ($beritas as $berita)
                <article class="w-full bg-white rounded-lg shadow-md p-6 flex flex-col md:flex-row md:space-x-8">
                    <img 
                        src="{{ $berita->thumbnail_url }}" 
                        alt="{{ $berita->judul_berita }}" 
                        style="width: 300px; height: 200px;" 
                        class="object-cover rounded-md mb-4 md:mb-0 flex-shrink-0"
                    />
                    <div class="flex flex-col justify-start flex-1">
                        <div>
                        <div class="mb-1">
                            <span class="font-bold" style="color: #AD1500;">{{ $berita->kategori->nama_kategori }}</span>
                        </div>
                            <h2 class="text-lg font-semibold text-gray-800 mt-1">{{ $berita->judul_berita }}</h2>
                            <p class="text-xs text-gray-600 mt-1">{{ $berita->tanggal_dibuat->format('d F Y') }}</p>
                            <p class="text-gray-700 mt-2 text-sm leading-relaxed">{{ Str::limit(strip_tags($berita->isi_berita), 120) }}</p>
                        </div>
                        <div class="mt-8">
                            <a href="{{ route('berita.show', $berita->id) }}" 
                                class="inline-block bg-[#AD1500] hover:bg-[#8F1000] text-white px-4 py-1 rounded-full text-xs font-semibold transition-colors shadow-md">
                                Baca selengkapnya
                            </a>
                        </div>
                    </div>
                </article>
            @endforeach
        </section>

    </div>
</div>
@endsection
