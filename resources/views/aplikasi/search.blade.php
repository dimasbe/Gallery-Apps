@extends('layouts.app')

@section('content')
<section class="w-full flex flex-col items-center pt-4 md:pt-6 pb-6 md:pb-10 px-4 bg-gray-100 min-h-screen">

    {{-- Top Navbar/Header --}}
    <div class="w-full max-w-7xl bg-white rounded-lg shadow-md mb-8 py-4 px-6 flex flex-col sm:flex-row items-center justify-between">
        <div class="flex items-center space-x-2 mb-4 sm:mb-0">
            <div class="w-8 h-8 bg-red-600 rounded-full flex items-center justify-center text-white font-bold text-lg">G</div>
            <span class="text-2xl font-bold text-gray-800 font-poppins">gallery</span>
        </div>
        <nav class="flex-grow flex justify-center sm:justify-start">
            <ul class="flex space-x-6 text-gray-700 font-medium text-sm font-poppins">
                <li><a href="#" class="hover:text-red-600">Beranda</a></li>
                <li><a href="#" class="text-red-600 border-b-2 border-red-600 pb-1">Aplikasi</a></li>
                <li><a href="#" class="hover:text-red-600">Kategori</a></li>
                <li><a href="#" class="hover:text-red-600">Berita</a></li>
            </ul>
        </nav>
        <div class="flex space-x-3">
            <button class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 text-sm font-poppins">Login</button>
            <button class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 text-sm font-poppins">Register</button>
        </div>
    </div>

    <div class="max-w-7xl w-full bg-white p-6 rounded-lg shadow-md">

        {{-- Header: Judul + Form Pencarian --}}
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
            <h2 class="text-2xl md:text-3xl font-bold font-poppins text-[#1b1b18] dark:text-white mb-4 sm:mb-0">
                Hasil Pencarian Game
            </h2>

            <form action="{{ route('search') }}" method="GET" class="w-full sm:w-auto">
                <div class="relative max-w-sm ml-auto">
                    <input type="text" name="keyword" value="{{ request('keyword') }}" placeholder="Cari aplikasi"
                        class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-red-500 text-sm text-gray-800 font-poppins">
                    <button type="submit"
                        class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-red-600 text-white p-2 rounded-full hover:bg-red-700 flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        @if(request()->has('keyword') && request('keyword') != '')
            <p class="text-sm text-gray-500 mb-4 font-poppins">
                Menampilkan hasil untuk: <span class="font-semibold text-red-600">"{{ request('keyword') }}"</span>
            </p>
        @endif

        {{-- Grid Hasil Pencarian --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @forelse($games as $game)
                <div class="bg-white rounded-xl overflow-hidden shadow-md border border-gray-200">
                    <div class="relative w-full h-40 overflow-hidden">
                        <img src="{{ asset('images/' . $game->banner) }}" alt="{{ $game->name }} Banner" class="w-full h-full object-cover">
                        @if($game->label)
                            <span class="absolute top-3 left-3 bg-{{ $game->label_color ?? 'red' }}-600 text-white text-xs font-semibold px-3 py-1 rounded-md font-poppins">
                                {{ $game->label }}
                            </span>
                        @endif
                    </div>
                    <div class="p-4 flex items-start space-x-3">
                        <img src="{{ asset('images/' . $game->icon) }}" alt="{{ $game->name }} Icon" class="w-12 h-12 rounded-lg object-cover shadow-sm">
                        <div>
                            <h3 class="font-semibold text-gray-800 text-base mb-1 font-poppins">{{ $game->name }}</h3>
                            <p class="text-gray-600 text-xs font-poppins">{{ strtoupper($game->category) }}</p>
                            <div class="flex items-center mt-1">
                                <svg class="w-4 h-4 text-yellow-400 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z" />
                                </svg>
                                <span class="text-gray-700 text-xs font-poppins">{{ number_format($game->rating ?? 0, 1) }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <p class="col-span-full text-center text-gray-500 font-poppins">Tidak ada hasil ditemukan.</p>
            @endforelse
        </div>

    </div>
</section>
@endsection
