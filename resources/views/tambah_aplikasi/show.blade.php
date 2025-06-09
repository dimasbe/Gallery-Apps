@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-grey-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-xl space-y-6">
        <h2 class="text-xl font-semibold text-gray-900 text-center mb-6">Detail Aplikasi: {{ $aplikasi->nama_aplikasi }}</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="flex flex-col items-center">
                <img src="{{ Storage::url($aplikasi->logo) }}" alt="Logo Aplikasi" class="w-32 h-32 object-cover rounded-full border border-gray-300 shadow-sm">
                <p class="text-sm font-medium text-gray-700 mt-2">Logo Aplikasi</p>
            </div>
            <div>
                <p><strong class="font-medium">Nama Aplikasi:</strong> {{ $aplikasi->nama_aplikasi }}</p>
                <p><strong class="font-medium">Pemilik:</strong> {{ $aplikasi->nama_pemilik }}</p>
                <p><strong class="font-medium">Kategori:</strong> {{ $aplikasi->kategori->nama_kategori }}</p>
                <p><strong class="font-medium">Tanggal Rilis:</strong> {{ \Carbon\Carbon::parse($aplikasi->tanggal_rilis)->format('d F Y') }}</p>
                <p><strong class="font-medium">Versi:</strong> {{ $aplikasi->versi }}</p>
                <p><strong class="font-medium">Rating Konten:</strong> {{ $aplikasi->rating_konten }}</p>
                <p><strong class="font-medium">Tautan Aplikasi:</strong> <a href="{{ $aplikasi->tautan_aplikasi }}" target="_blank" class="text-blue-600 hover:underline">{{ $aplikasi->tautan_aplikasi }}</a></p>
                <p><strong class="font-medium">Status Verifikasi:</strong>
                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                        @if($aplikasi->status_verifikasi == 'diterima') bg-green-100 text-green-800
                        @elseif($aplikasi->status_verifikasi == 'pending') bg-yellow-100 text-yellow-800
                        @else bg-red-100 text-red-800 @endif">
                        {{ ucfirst($aplikasi->status_verifikasi) }}
                    </span>
                </p>
                @if ($aplikasi->status_verifikasi == 'ditolak' && $aplikasi->alasan_penolakan)
                    <p class="mt-2 text-red-700"><strong class="font-medium">Alasan Penolakan:</strong> {{ $aplikasi->alasan_penolakan }}</p>
                @endif
            </div>
        </div>

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800">Deskripsi</h3>
            <p class="mt-2 text-gray-700">{{ $aplikasi->deskripsi }}</p>
        </div>

        @if($aplikasi->fitur)
            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-800">Fitur</h3>
                <p class="mt-2 text-gray-700">{{ $aplikasi->fitur }}</p>
            </div>
        @endif

        <div class="mt-6">
            <h3 class="text-lg font-semibold text-gray-800">Foto Aplikasi</h3>
            @if($aplikasi->fotoAplikasi->isEmpty())
                <p class="mt-2 text-gray-600">Tidak ada foto aplikasi yang diunggah.</p>
            @else
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-4 mt-4">
                    @foreach($aplikasi->fotoAplikasi as $foto)
                        <img src="{{ Storage::url($foto->path_foto) }}" alt="Foto Aplikasi" class="w-full h-32 object-cover rounded-md border border-gray-300 shadow-sm">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="flex justify-end space-x-4 mt-8">
            <a href="{{ route('user_login.aplikasi.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                Kembali ke Daftar
            </a>
            <a href="{{ route('user_login.aplikasi.edit', $aplikasi->id) }}" class="inline-flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Edit Aplikasi
            </a>
        </div>
    </div>
</div>
@endsection