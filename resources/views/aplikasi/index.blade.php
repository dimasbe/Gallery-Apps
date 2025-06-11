@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="flex items-center justify-between mb-4">
        {{-- Tombol Kembali --}}
        <a href="javascript:history.back()" class="flex items-center text-gray-500 hover:text-gray-700 p-2 rounded-full">
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

    {{-- Aplikasi Paling Populer --}}
    <div class="mb-10 mt-10">
        <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4 flex items-center">
            Paling populer
            <a href="{{ route('aplikasi.populer') }}" class="ml-3 text-[#AD1500] hover:text-[#8F1000]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </h3>

        @if ($aplikasiPopuler->isEmpty())
            <p class="text-gray-600">Tidak ada aplikasi populer yang tersedia.</p>
        @else
            @php
                $perPage = $aplikasiPopuler->perPage();
                $currentPage = $aplikasiPopuler->currentPage();
                $startIndex = ($currentPage - 1) * $perPage;
                $columns = 3;
                $chunked = $aplikasiPopuler->values()->chunk(ceil($aplikasiPopuler->count() / $columns));
            @endphp
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 mt-8">
                @foreach ($chunked as $colIndex => $column)
                    <div class="space-y-5">
                        @foreach ($column as $rowIndex => $aplikasi)
                            <div class="flex items-start space-x-3 font-poppins">
                                <span class="text-sm font-bold text-[#1b1b18] w-5">
                                    {{ $startIndex + ($colIndex * ceil($aplikasiPopuler->count() / $columns)) + $rowIndex + 1 }}
                                </span>
                                <a href="{{ route('aplikasi.detail', $aplikasi->id) }}">
                                    @if ($aplikasi->logo)
                                        <img src="{{ asset('storage/' . $aplikasi->logo) }}"
                                            alt="Logo {{ $aplikasi->nama_aplikasi }}"
                                            class="w-12 h-12 rounded-lg object-cover" />
                                    @else
                                        <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </a>
                                <div class="flex flex-col">
                                    <h3 class="text-sm font-semibold text-[#1b1b18] leading-tight">
                                        <a href="{{ route('aplikasi.detail', $aplikasi->id) }}"
                                            class="hover:text-red-600">{{ $aplikasi->nama_aplikasi }}</a>
                                    </h3>
                                    <small class="text-gray-500 text-sm">{{ $aplikasi->nama_pemilik ?? 'Developer tidak tersedia' }}</small>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endforeach
            </div>
            <div class="mt-8">
                {{ $aplikasiPopuler->links('pagination::tailwind', ['pageName' => 'popular_page']) }}
            </div>
        @endif
    </div>

    {{-- Aplikasi per Kategori --}}
    @foreach ($categorizedApplications as $group)
        @php
            $category = $group['category'];
            $apps = $group['applications'];
            $perPage = $apps->perPage();
            $currentPage = $apps->currentPage();
            $startIndex = ($currentPage - 1) * $perPage;
            $columns = 3;
            $chunked = $apps->values()->chunk(ceil($apps->count() / $columns));
        @endphp

        <div class="mb-10 mt-12">
            <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4 flex items-center">
                {{ $category->nama_kategori }}
                <a href="{{ route('kategori.show', $category->nama_kategori) }}" class="ml-3 text-[#AD1500] hover:text-[#8F1000]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </a>
            </h3>

            @if ($apps->isEmpty())
                <p class="text-gray-600">Tidak ada aplikasi dalam kategori {{ $category->nama_kategori }}.</p>
            @else
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-x-10 mt-8">
                    @foreach ($chunked as $colIndex => $column)
                        <div class="space-y-5">
                            @foreach ($column as $rowIndex => $aplikasi)
                                <div class="flex items-start space-x-3 font-poppins">
                                    <span class="text-sm font-bold text-[#1b1b18] w-5">
                                        {{ $startIndex + ($colIndex * ceil($apps->count() / $columns)) + $rowIndex + 1 }}
                                    </span>
                                    <a href="{{ route('aplikasi.detail', $aplikasi->id) }}">
                                        @if ($aplikasi->logo)
                                            <img src="{{ asset('storage/' . $aplikasi->logo) }}"
                                                alt="Logo {{ $aplikasi->nama_aplikasi }}"
                                                class="w-12 h-12 rounded-lg object-cover" />
                                        @else
                                            <div class="w-12 h-12 bg-gray-200 flex items-center justify-center rounded-lg text-gray-500">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </a>
                                    <div class="flex flex-col">
                                        <h3 class="text-sm font-semibold text-[#1b1b18] leading-tight">
                                            <a href="{{ route('aplikasi.detail', $aplikasi->id) }}"
                                                class="hover:text-red-600">{{ $aplikasi->nama_aplikasi }}</a>
                                        </h3>
                                        <small class="text-gray-500 text-sm">{{ $aplikasi->nama_pemilik ?? 'Developer tidak tersedia' }}</small>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endforeach
                </div>
                <div class="mt-8">
                    {{ $apps->links('pagination::tailwind', ['pageName' => 'category_' . $category->id . '_page']) }}
                </div>
            @endif
        </div>
    @endforeach
</section>
@endsection
