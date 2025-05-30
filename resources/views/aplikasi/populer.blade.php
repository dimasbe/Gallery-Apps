@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="flex justify-end mb-2">
        {{-- Form Pencarian --}}
        <form action="{{ route('search') }}" method="GET" class="ml-auto">
            <div class="relative max-w-md">
                <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari di sini..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins">
                <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </button>
            </div>
        </form>
    </div>

    <!-- Paling Populer -->
    <div class="mb-10 mt-10">
        <h3 class="text-left text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4">
        Paling populer
        </h3>
        <div class="grid grid-cols-3 gap-4 mt-8">
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>1</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>2</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>3</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>1</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>2</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>3</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>1</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>2</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>3</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>1</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>2</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>3</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
        </div>
        <div class="space-y-3">
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>1</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>2</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>3</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>1</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>2</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
            <div class="flex items-center gap-2">
                <div class="mr-4">
                    <span>3</span>
                </div>
                <img src="{{ asset('images/icon_ml.png') }}" alt="ChatGPT" class="w-12 h-12" />
                <div class="flex flex-col">
                    <span class="font-semibold">ChatGPT</span>
                    <small class="text-gray-500 text-sm">OpenAI</small>
                    <small class="text-gray-500 text-sm">4.7 ★</small>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-10 flex justify-end"> {{-- Hapus items-center di sini --}}
        <div class="inline-flex text-sm font-medium border border-gray-300 rounded-md overflow-hidden bg-white shadow-sm">
            {{-- Previous Button --}}
            <a href="#" class="px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 border-r border-gray-200">
                &lt;
            </a>

            {{-- Page 1 (Active) --}}
            <a href="#" class="px-3 py-2 bg-[#AD1500] text-white">
                1
            </a>

            {{-- Page 2 --}}
            <a href="#" class="px-3 py-2 text-gray-700 hover:bg-gray-100 border-x border-gray-200">
                2
            </a>

            {{-- Page 3 --}}
            <a href="#" class="px-3 py-2 text-gray-700 hover:bg-gray-100 border-r border-gray-200">
                3
            </a>

            {{-- Dots --}}
            <span class="px-3 py-2 text-gray-400 bg-gray-100 border-x border-gray-200">...</span>

            {{-- Page 10 --}}
            <a href="#" class="px-3 py-2 text-gray-700 hover:bg-gray-100 border-r border-gray-200">
                10
            </a>

            {{-- Next Button --}}
            <a href="#" class="px-3 py-2 bg-gray-100 text-gray-600 hover:bg-gray-200 border-l border-gray-200">
                &gt;
            </a>
        </div>
    </div>

</section>
@endsection