@extends('layouts.app')

@section('content')
<div class="max-w-4xl mx-auto py-8">
    <h1 class="text-2xl font-bold mb-4 capitalize">Kategori: {{ $slug }}</h1>

    <p class="mb-4">Menampilkan konten untuk kategori <strong>{{ $slug }}</strong>. Silakan sesuaikan konten berdasarkan kategori ini.</p>

    {{-- Contoh konten dinamis --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        @for ($i = 1; $i <= 6; $i++)
            <div class="bg-gray-100 p-4 rounded shadow">
                <h2 class="font-semibold text-lg">Item {{ $i }} di kategori {{ ucfirst($slug) }}</h2>
                <p class="text-sm text-gray-600">Deskripsi item {{ $i }} dalam kategori {{ $slug }}.</p>
            </div>
        @endfor
    </div>
</div>
@endsection