@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="flex justify-between mb-2 items-center">
    {{-- Tombol Kembali ke halaman kategori --}}
    <a href="{{ route('kategori.index_umum') }}" class="flex items-center text-gray-500 hover:text-gray-700 p-2 rounded-full">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
        </svg>
        <span class="text-sm font-poppins">Kembali</span>
    </a>

        {{-- Form Pencarian --}}
        <form action="{{ route('search') }}" method="GET" class="ml-auto">
            <div class="relative max-w-md">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari di sini..."
                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins"
                    autocomplete="off">
                <button type="submit"
                    class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]"
                    aria-label="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <div class="mb-10 mt-10">
        <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4 flex items-center">
            Kategori : {{ $category->nama_kategori }}
        </h3>

        {{-- Logika penomoran dipindahkan atau disederhanakan --}}
        @php
            $globalStartingIndexForCategory = ($applications->currentPage() - 1) * $applications->perPage();
        @endphp

        @if ($applications->isEmpty())
            <p class="text-gray-600 col-span-3">Tidak ada aplikasi dalam kategori {{ $category->nama_kategori }}.</p>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 gap-y-6 mt-8">
                @foreach ($applications as $index => $aplikasi) {{-- CHANGE THIS LINE --}}
                    <div class="flex items-start space-x-3 font-poppins">
                        <span class="text-sm font-bold text-[#1b1b18] w-5">
                            {{ $globalStartingIndexForCategory + $index + 1 }} {{-- Adjust index for current page --}}
                        </span>
                        <a href="{{ route('aplikasi.detail', $aplikasi->id) }}" class="block w-full">
                            <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px] hover:shadow-2xl transition-shadow duration-300">
                                @php
                                    $coverImage = $aplikasi->fotoAplikasi->first()
                                        ? asset('storage/' . $aplikasi->fotoAplikasi->first()->path_foto)
                                        : 'https://placehold.co/400x200/cccccc/333333?text=Cover+App';

                                    $iconImage = $aplikasi->logo
                                        ? asset('storage/' . $aplikasi->logo)
                                        : 'https://placehold.co/40x40/cccccc/333333?text=Icon';
                                @endphp

                                <img src="{{ $coverImage }}" alt="{{ $aplikasi->nama_aplikasi }} Thumbnail" class="w-full h-32 object-cover">
                                <div class="pt-4 flex items-start space-x-3">
                                    <img src="{{ $iconImage }}" alt="Logo {{ $aplikasi->nama_pemilik }}" class="w-10 h-10 rounded-md object-cover">
                                    <div>
                                        <h3 class="font-semibold text-gray-800 text-sm mb-1">{{ $aplikasi->nama_aplikasi }}</h3>
                                        <p class="text-gray-600 text-xs">{{ $aplikasi->nama_pemilik }}</p>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>

            <div class="mt-6">
                {{ $applications->links() }} {{-- CHANGE THIS LINE --}}
            </div>
        @endif
    </div>
</section>
@endsection