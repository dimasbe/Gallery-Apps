@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="flex justify-end mb-2">
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

    <div class="mb-10 mt-10">
        <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4 flex items-center">
            Paling populer
            <a href="/aplikasi/populer" class="ml-3 text-[#AD1500] hover:text-[#8F1000]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                </svg>
            </a>
        </h3>
        <div class="grid grid-cols-3 gap-4 mt-8">
            <div class="space-y-3">
                {{-- Aplikasi Populer 1 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>1</span>
                    </div>
                    {{-- Ubah ini untuk bisa diklik --}}
                    <a href="/aplikasi/detail" class="ml-3 text-[#AD1500] hover:text-[#8F1000]">
    <img src="{{ asset('images/icon_ml.png') }}" alt="Mobile Legends Icon" class="w-12 h-12 rounded-lg" />
</a>

                    <div class="flex flex-col">
                        <span class="font-semibold">Mobile Legends: Bang Bang</span>
                        <small class="text-gray-500 text-sm">MOONTOON</small>
                        <small class="text-gray-500 text-sm">3.8 ★</small>
                    </div>
                </div>
                {{-- Aplikasi Populer 2 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>2</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 2</span>
                        <small class="text-gray-500 text-sm">Developer 2</small>
                        <small class="text-gray-500 text-sm">4.5 ★</small>
                    </div>
                </div>
                {{-- Aplikasi Populer 3 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>3</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 3</span>
                        <small class="text-gray-500 text-sm">Developer 3</small>
                        <small class="text-gray-500 text-sm">4.2 ★</small>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                {{-- Aplikasi Populer 4 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>4</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 4</span>
                        <small class="text-gray-500 text-sm">Developer 4</small>
                        <small class="text-gray-500 text-sm">4.0 ★</small>
                    </div>
                </div>
                {{-- Aplikasi Populer 5 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>5</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 5</span>
                        <small class="text-gray-500 text-sm">Developer 5</small>
                        <small class="text-gray-500 text-sm">3.9 ★</small>
                    </div>
                </div>
                {{-- Aplikasi Populer 6 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>6</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 6</span>
                        <small class="text-gray-500 text-sm">Developer 6</small>
                        <small class="text-gray-500 text-sm">4.8 ★</small>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                {{-- Aplikasi Populer 7 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>7</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 7</span>
                        <small class="text-gray-500 text-sm">Developer 7</small>
                        <small class="text-gray-500 text-sm">4.1 ★</small>
                    </div>
                </div>
                {{-- Aplikasi Populer 8 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>8</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 8</span>
                        <small class="text-gray-500 text-sm">Developer 8</small>
                        <small class="text-gray-500 text-sm">3.7 ★</small>
                    </div>
                </div>
                {{-- Aplikasi Populer 9 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>9</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Another App Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Aplikasi 9</span>
                        <small class="text-gray-500 text-sm">Developer 9</small>
                        <small class="text-gray-500 text-sm">4.6 ★</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mb-10 mt-12">
        <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4">
            Permainan
        </h3>
        <div class="grid grid-cols-3 gap-4 mt-8">
            <div class="space-y-3">
                {{-- Permainan 1 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>1</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 1</span>
                        <small class="text-gray-500 text-sm">Developer Game 1</small>
                        <small class="text-gray-500 text-sm">4.3 ★</small>
                    </div>
                </div>
                {{-- Permainan 2 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>2</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 2</span>
                        <small class="text-gray-500 text-sm">Developer Game 2</small>
                        <small class="text-gray-500 text-sm">4.0 ★</small>
                    </div>
                </div>
                {{-- Permainan 3 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>3</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 3</span>
                        <small class="text-gray-500 text-sm">Developer Game 3</small>
                        <small class="text-gray-500 text-sm">4.9 ★</small>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                {{-- Permainan 4 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>4</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 4</span>
                        <small class="text-gray-500 text-sm">Developer Game 4</small>
                        <small class="text-gray-500 text-sm">3.5 ★</small>
                    </div>
                </div>
                {{-- Permainan 5 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>5</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 5</span>
                        <small class="text-gray-500 text-sm">Developer Game 5</small>
                        <small class="text-gray-500 text-sm">4.4 ★</small>
                    </div>
                </div>
                {{-- Permainan 6 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>6</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 6</span>
                        <small class="text-gray-500 text-sm">Developer Game 6</small>
                        <small class="text-gray-500 text-sm">4.7 ★</small>
                    </div>
                </div>
            </div>
            <div class="space-y-3">
                {{-- Permainan 7 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>7</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 7</span>
                        <small class="text-gray-500 text-sm">Developer Game 7</small>
                        <small class="text-gray-500 text-sm">4.2 ★</small>
                    </div>
                </div>
                {{-- Permainan 8 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>8</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 8</span>
                        <small class="text-gray-500 text-sm">Developer Game 8</small>
                        <small class="text-gray-500 text-sm">3.6 ★</small>
                    </div>
                </div>
                {{-- Permainan 9 --}}
                <div class="flex items-center gap-2">
                    <div class="mr-4">
                        <span>9</span>
                    </div>
                    <a href="{{ route('aplikasi.detail') }}"> {{-- Ganti dengan detail aplikasi yang relevan --}}
                        <img src="{{ asset('images/icon_ml.png') }}" alt="Game Icon" class="w-12 h-12 rounded-lg" />
                    </a>
                    <div class="flex flex-col">
                        <span class="font-semibold">Nama Game 9</span>
                        <small class="text-gray-500 text-sm">Developer Game 9</small>
                        <small class="text-gray-500 text-sm">4.5 ★</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection