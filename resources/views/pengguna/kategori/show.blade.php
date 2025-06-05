@extends('layouts.app')

@section('content')
    <div class="mt-8">
        <a href="{{ route('kategori.index') }}"
            class="inline-flex items-center px-4 py-2 border border-transparent text-base font-medium rounded-md shadow-sm text-white bg-[#AD1500] hover:bg-[#8F1000] focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-[#AD1500] transition ease-in-out duration-150">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Kembali ke Semua Kategori
        </a>
    </div>
    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Kategori {{ $kategori->nama_kategori }}</h1>

        @if ($aplikasi->isEmpty())
            <p class="text-gray-500 text-center">Tidak ada aplikasi yang tersedia dalam kategori ini.</p>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
                @foreach ($aplikasi as $aplikasiItem) {{-- Ubah nama variabel untuk menghindari konflik --}}
                    <div class="bg-white rounded-lg shadow-md overflow-hidden">
                        {{-- Assuming you have an image for your application --}}
                        {{-- <img src="{{ asset('storage/' . $aplikasiItem->image_path) }}" alt="{{ $aplikasiItem->nama_aplikasi }}" class="w-full h-48 object-cover"> --}}
                        <div class="p-4">
                            <h2 class="text-xl font-semibold text-gray-900 mb-2">{{ $aplikasiItem->nama_aplikasi }}</h2>
                            <p class="text-gray-700 text-sm mb-4">{{ Str::limit($aplikasiItem->deskripsi, 100) }}</p>
                            {{-- Pastikan rute aplikasi.show juga sudah didefinisikan dengan benar --}}
                            <a href="{{ route('pengguna.aplikasi.show', $aplikasiItem->slug) }}" class="inline-block bg-[#AD1500] text-white px-4 py-2 rounded-md hover:bg-[#8F1000] text-sm">Lihat Detail</a>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection