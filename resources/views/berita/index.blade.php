@extends('layouts.app')

@section('content')
<div class="container mx-auto max-w-7xl px-6">
    <div class="flex space-x-8">

    {{-- Sidebar Kategori + Form Pencarian --}}
<aside class="w-48 self-start flex-shrink-0 space-y-4">
    
    {{-- Form Pencarian --}}
    <div class="bg-white rounded-lg shadow p-3">
        <form action="{{ route('berita.index') }}" method="GET" class="flex flex-col space-y-2">
            <input 
                type="text" 
                name="search" 
                value="{{ request('search') }}"
                placeholder="Cari berita..." 
                class="px-3 py-2 border rounded focus:outline-none focus:ring-2 focus:ring-[#AD1500] text-sm"
            >
            <button 
                type="submit" 
                class="bg-[#AD1500] hover:bg-[#8F1000] text-white px-3 py-2 rounded text-sm font-semibold shadow">
                Cari
            </button>
        </form>
    </div>

    {{-- Kategori --}}
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
            {{-- Kontrol Jumlah Berita per Halaman --}}
            <div class="flex justify-end items-center mb-4">
    <form action="{{ route('berita.index') }}" method="GET" class="flex items-center gap-2 bg-white px-3 py-2 rounded shadow">
        {{-- Pertahankan kategori dan pencarian jika ada --}}
        <input type="hidden" name="kategori" value="{{ request('kategori') }}">
        <input type="hidden" name="search" value="{{ request('search') }}">

        <label for="perPage" class="text-sm text-gray-700">Tampilkan</label>
        <div class="relative">
            <select 
                name="perPage" 
                id="perPage" 
                onchange="this.form.submit()" 
                class="appearance-none border border-gray-300 text-sm rounded pl-3 pr-8 py-1 focus:ring-[#AD1500] focus:border-[#AD1500] shadow-sm">
                @foreach ([5, 10, 15, 20] as $jumlah)
                    <option value="{{ $jumlah }}" {{ request('perPage', 5) == $jumlah ? 'selected' : '' }}>
                        {{ $jumlah }}
                    </option>
                @endforeach
            </select>
            {{-- Panah custom --}}
            <div class="pointer-events-none absolute inset-y-0 right-2 flex items-center text-gray-500">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <!-- <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /> -->
                </svg>
            </div>
        </div>
        <span class="text-sm text-gray-700">berita</span>
    </form>
</div>



        </section>

    </div>
</div>
@endsection
