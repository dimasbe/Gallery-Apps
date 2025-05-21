@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="flex justify-end mb-2 " style="padding-top: 75px">
                {{-- Form Pencarian --}}
                <form action="{{ route('search') }}" method="GET" class="ml-auto">
                    <div class="relative max-w-md">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari di sini..."
                            class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

    <!-- Kategori Belanja-->
  <div class="mb-9 mt-9">
    <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-7">
      Kategori Belanja
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-7">
        {{-- Kolom 1 --}}
        <div class="space-y-4">
            @foreach ([1, 2, 3, 4, 5] as $i)
                <div class="flex items-center space-x-3">
                    <span class="text-lg w-5">{{ $i }}</span>
                    <img src="{{ asset('images/game' . $i . '.png') }}" alt="Game {{ $i }}" class="w-10 h-10 rounded-md" />
                    <div class="flex-1">
                        <p class="text-sm font-medium">Hay Day</p>
                        <p class="text-xs text-gray-500">Belanja</p>
                        <p class="text-xs text-gray-500">4.7 ★</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Kolom 2 --}}
        <div class="space-y-4">
            @foreach ([6, 7, 8, 9, 10] as $i)
                <div class="flex items-center space-x-3">
                    <span class="text-lg w-5">{{ $i }}</span>
                    <img src="{{ asset('images/game' . $i . '.png') }}" alt="Game {{ $i }}" class="w-10 h-10 rounded-md" />
                    <div class="flex-1">
                        <p class="text-sm font-medium">Genshin Impact</p>
                        <p class="text-xs text-gray-500">Belanja</p>
                        <p class="text-xs text-gray-500">4.7 ★</p>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Kolom 3 --}}
        <div class="space-y-4">
            @foreach ([11, 12, 13, 14, 15] as $i)
                <div class="flex items-center space-x-3">
                    <span class="text-lg w-5">{{ $i }}</span>
                    <img src="{{ asset('images/game' . $i . '.png') }}" alt="Game {{ $i }}" class="w-10 h-10 rounded-md" />
                    <div class="flex-1">
                        <p class="text-sm font-medium">Alpaca Clicker</p>
                        <p class="text-xs text-gray-500">Belanja</p>
                        <p class="text-xs text-gray-500">4.7 ★</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    {{-- Pagination --}}
    <div class="flex justify-center mt-10 space-x-2 text-sm">
        @for ($p = 1; $p <= 5; $p++)
            <a href="#" class="px-3 py-1 rounded-md border border-gray-300 hover:bg-gray-100">{{ $p }}</a>
        @endfor
    </div>
@endsection