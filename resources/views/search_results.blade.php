@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    {{-- Header: Tombol Kembali dan Form Search --}}
    <div class="flex justify-between items-center mb-2 flex-wrap gap-y-2">
        {{-- Tombol Kembali --}}
        <div>
            <a href="{{ route('aplikasi') }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                kembali
            </a>
        </div>

        {{-- Form Search --}}
        <form action="{{ route('search') }}" method="GET" class="ml-auto">
            <div class="relative max-w-md">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari lagi..."
                    class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins"
                    autocomplete="off"
                >
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]" aria-label="Cari">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    {{-- Judul Hasil --}}
    <div class="mb-6 mt-8">
        <h1 class="text-xl md:text-2xl font-semibold text-[#1b1b18] font-poppins text-left">
            Hasil Pencarian untuk "{{ $query }}"
        </h1>
    </div>

    {{-- Hasil Aplikasi --}}
    @php
        // $results adalah instance paginator dari controller
        $perPage = $results->perPage();
        $currentPage = $results->currentPage();
        $globalStartingIndex = ($currentPage - 1) * $perPage; // Index awal untuk halaman ini
        $actualItemsPerVisualColumn = ceil($results->count() / 3); // Dari logika controller
    @endphp

    @if ($results->isEmpty())
        <div class="text-center text-gray-600 text-lg py-10">
            Tidak ada aplikasi yang ditemukan dengan kata kunci tersebut.
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10">
            @foreach ($columnedResults as $colIndex => $column)
                <div class="space-y-5">
                    @foreach ($column as $rowInColIndex => $aplikasi)
                        <div class="flex items-start space-x-3 font-poppins">
                            @php
                                $itemOriginalIndex = ($colIndex * $actualItemsPerVisualColumn) + $rowInColIndex;
                                $displayNumber = $globalStartingIndex + $itemOriginalIndex + 1;
                            @endphp
                            <span class="text-sm font-bold text-[#1b1b18] w-5">{{ $displayNumber }}</span>

                            <a href="{{ route('aplikasi.detail', $aplikasi->id) }}">
                                @if ($aplikasi->logo)
                                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="{{ $aplikasi->nama_aplikasi }}"
                                        class="w-12 h-12 rounded-lg object-cover">
                                @else
                                    <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                        </svg>
                                    </div>
                                @endif
                            </a>

                            <div class="flex flex-col">
                                <h3 class="text-sm font-semibold text-[#1b1b18] leading-tight">
                                    <a href="{{ route('aplikasi.detail', $aplikasi->id) }}" class="hover:text-red-600">{{ $aplikasi->nama_aplikasi }}</a>
                                </h3>

                                <p class="text-xs text-gray-500">
                                    {{ $aplikasi->nama_pemilik ?? 'Developer tidak tersedia' }}
                                </p>

                                {{-- Rating section removed --}}
                                {{-- <p class="text-xs text-gray-600">
                                    {{ number_format($aplikasi->rating_konten ?? 0, 1) }} ★
                                </p> --}}
                            </div>
                        </div>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $results->links() }}
        </div>
    @endif
</section>
@endsection
