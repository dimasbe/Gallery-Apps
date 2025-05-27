@extends('layouts.admin') {{-- Pastikan ini mengarah ke layout admin Anda --}}

@section('title', 'Halaman Riwayat (Tanpa Data)')

@section('content')
    <div class="p-6 bg-white border-b border-gray-200">
        <h1 class="text-2xl font-bold mb-4">Ini adalah Halaman Riwayat</h1>
        <p>Konten halaman riwayat akan ditampilkan di sini. Data belum dimuat dari database.</p>
        <p>Jika Anda melihat pesan ini, berarti koneksi rute, controller, dan view sudah berhasil!</p>
    </div>
@endsection