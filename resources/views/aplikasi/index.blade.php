@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="flex justify-end mb-2">
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

    {{-- Bagian Paling Populer (berdasarkan jumlah_kunjungan) --}}
    <div class="mb-16 mt-10">
        <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4 flex items-center">
            Paling populer
            <a href="{{ route('aplikasi.populer') }}" class="ml-3 text-[#AD1500] hover:text-[#8F1000]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </h3>

        @if ($aplikasiPopuler->isEmpty())
            <p class="text-gray-600">Tidak ada aplikasi populer yang tersedia.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6 mt-6">
                @foreach($aplikasiPopuler as $aplikasi)
                    <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md p-4">
                        <div class="w-full h-40 bg-gray-100 dark:bg-gray-700 rounded-lg overflow-hidden mb-4">
                            <img src="{{ asset('storage/' . $aplikasi->logo) }}"
                                alt="{{ $aplikasi->nama_aplikasi }}"
                                class="w-full h-full object-cover">
                        </div>
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-1">
                            {{ $aplikasi->nama_aplikasi }}
                        </h3>
                        <p class="text-sm text-gray-600 dark:text-gray-300">
                            {{ Str::limit($aplikasi->deskripsi, 80) }}
                        </p>
                        <a href="{{ route('aplikasi.detail', $aplikasi->slug) }}"
                        class="mt-3 inline-block text-red-700 hover:underline text-sm font-semibold">
                            Lihat Detail →
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>


    {{-- Bagian Aplikasi per Kategori --}}
    @foreach ($categorizedApplications as $categoryGroup)
        @php
            $category = $categoryGroup['category'];
            $applications = $categoryGroup['applications'];
            $columnedResults = $categoryGroup['columnedResults'];

            $perPageCategory = $applications->perPage();
            $currentPageCategory = $applications->currentPage();
            $globalStartingIndexCategory = ($currentPageCategory - 1) * $perPageCategory;
            $actualItemsPerVisualColumnCategory = ceil($applications->count() / 3);
        @endphp

        <div class="mb-10 mt-12">
            <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4 flex items-center">
                {{ $category->nama_kategori }}
                <a href="{{ route('kategori.show', $category->nama_kategori) }}" class="ml-3 text-[#AD1500] hover:text-[#8F1000]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </h3>

            @if ($applications->isEmpty())
                <p class="text-gray-600 col-span-3">Tidak ada aplikasi dalam kategori {{ $category->nama_kategori }} yang tersedia.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 mt-8">
                    @foreach ($columnedResults as $colIndex => $column)
                        <div class="space-y-5">
                            @foreach ($column as $rowInColIndex => $aplikasi)
                                <div class="flex items-start space-x-3 font-poppins">
                                    @php
                                        $itemOriginalIndex = ($colIndex * $actualItemsPerVisualColumnCategory) + $rowInColIndex;
                                        $displayNumber = $globalStartingIndexCategory + $itemOriginalIndex + 1;
                                    @endphp
                                    <span class="text-sm font-bold text-[#1b1b18] w-5">{{ $displayNumber }}</span>

                                    <a href="{{ route('aplikasi.detail', $aplikasi->id) }}">
                                        @if ($aplikasi->logo)
                                            <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo {{ $aplikasi->nama_aplikasi }}" class="w-12 h-12 rounded-lg object-cover" />
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="flex flex-col">
                                        <h3 class="text-sm font-semibold text-[#1b1b18] leading-tight">
                                            <a href="{{ route('aplikasi.detail', $aplikasi->id) }}" class="hover:text-red-600">{{ $aplikasi->nama_aplikasi }}</a>
                                        </h3>
                                        <small class="text-gray-500 text-sm">{{ $aplikasi->nama_pemilik ?? 'Developer tidak tersedia' }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $applications->links('pagination::tailwind', ['pageName' => 'category_' . $category->id . '_page']) }}
                </div>
            @endif
        </div>
    @endforeach

</section>
@endsection