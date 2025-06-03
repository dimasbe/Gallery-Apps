{{-- views/admin/berita/show.blade.php --}}

@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-3xl font-bold text-red-800">{{ $berita->judul_berita }}</h1>
        <p class="text-gray-600 mb-4">Oleh: {{ $berita->penulis }} | Kategori: {{ $berita->kategori->nama_kategori ?? 'N/A' }}</p>
        <p class="text-gray-600 mb-4">Tanggal Dibuat: {{ $berita->tanggal_dibuat->format('d M Y') }} | Terakhir Diedit: {{ $berita->tanggal_diedit->format('d M Y') }}</p>

        @if($berita->fotoBeritas->where('tipe', 'thumbnail')->first())
            <div class="mb-6">
                <img src="{{ Storage::url($berita->fotoBeritas->where('tipe', 'thumbnail')->first()->nama_gambar) }}" alt="Thumbnail Berita" class="w-full h-64 object-cover rounded-md shadow-md">
                @if($berita->fotoBeritas->where('tipe', 'thumbnail')->first()->keterangan_gambar)
                    <p class="text-center text-sm text-gray-500 mt-2">{{ $berita->fotoBeritas->where('tipe', 'thumbnail')->first()->keterangan_gambar }}</p>
                @endif
            </div>
        @endif

        <div class="prose max-w-none">
            {!! $berita->isi_berita !!} {{-- Render the HTML content from CKEditor --}}
        </div>

        <div class="mt-6 flex justify-end">
            <a href="{{ route('admin.berita.index') }}" class="inline-flex justify-center py-2 px-5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                Kembali ke Daftar Berita
            </a>
        </div>
    </div>
</div>
@endsection