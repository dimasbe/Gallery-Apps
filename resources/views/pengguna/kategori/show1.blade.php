@extends('layouts.app')

@section('content')
    <div class="mt-8">
        <a href="{{ route('welcome') }}" {{-- Jika ini untuk kategori umum, gunakan index_umum --}}
            class="inline-flex items-center px-3 py-1 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-[#AD1500] hover:bg-[#8F1000] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#AD1500] transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali
        </a>
    </div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Kategori : {{ $kategori->nama_kategori }}</h1>

        @if ($aplikasi->isEmpty())
            <p class="text-gray-500 text-center">Tidak ada aplikasi yang tersedia dalam kategori ini.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($aplikasi as $aplikasiItem)
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        @if ($aplikasiItem->logo)
                            <img src="{{ asset('storage/' . $aplikasiItem->logo) }}" alt="Logo {{ $aplikasiItem->nama_aplikasi }}" class="w-full h-48 object-cover">
                        @else
                            <div class="w-full h-48 bg-gray-200 flex items-center justify-center text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                            </div>
                        @endif
                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $aplikasiItem->nama_aplikasi }}</h2>
                            <p class="text-gray-700 text-sm mb-4">{{ Str::limit($aplikasiItem->deskripsi, 100) }}</p>
                            {{-- **BARIS YANG DIPERBAIKI:** --}}
                            <a href="{{ route('aplikasi.detail', $aplikasiItem->id) }}" class="inline-block bg-[#AD1500] text-white px-4 py-2 rounded-md hover:bg-[#8F1000] text-sm">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection