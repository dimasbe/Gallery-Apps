@extends('layouts.admin') {{-- Ini mengextends layout utama admin Anda, pastikan 'layouts/admin.blade.php' ada --}}

@section('title', 'Admin Dashboard') {{-- Judul halaman untuk bagian <title> di HTML --}}

@section('content') {{-- Bagian ini akan di-inject ke dalam @yield('content') di layout admin --}}
<div class="min-h-screen bg-gray-100 dark:bg-gray-900 text-gray-800 dark:text-gray-100 py-10 px-6">
    <div class="max-w-7xl mx-auto">
        <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            {{-- Kartu Statistik 1 --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-2">Statistik 1</h2>
                <p class="text-gray-600 dark:text-gray-300">Contoh konten statistik.</p>
            </div>

            {{-- Kartu Statistik 2 --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-2">Statistik 2</h2>
                <p class="text-gray-600 dark:text-gray-300">Contoh konten statistik.</p>
            </div>

            {{-- Kartu Statistik 3 --}}
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow p-6">
                <h2 class="text-xl font-semibold mb-2">Statistik 3</h2>
                <p class="text-gray-600 dark:text-gray-300">Contoh konten statistik.</p>
            </div>
        </div>
    </div>
</div>
@endsection