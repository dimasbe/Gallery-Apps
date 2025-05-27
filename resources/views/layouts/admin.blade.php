<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Admin Dashboard')</title>
    {{-- Link ke CSS Tailwind --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    {{-- Link ke Font Awesome untuk ikon --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    {{-- Atau jika Anda mengcompile Tailwind lokal, gunakan: --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/app.css') }}"> --}}

    <style>
        /* Definisi Warna Kustom */
        :root {
            --color-primary-red: #AD1500; /* Merah Utama yang Baru */
            --color-primary-red-darker: #8D1100; /* Merah sedikit lebih gelap untuk hover */
            --color-sidebar-bg: #FFFFFF; /* PUTIH untuk sidebar */
            --color-sidebar-hover: #F0F0F0; /* Abu-abu sangat terang untuk hover sidebar */
            --color-sidebar-active: var(--color-primary-red); /* Merah untuk item aktif sidebar */
            --color-text-on-dark: #333333; /* Teks gelap di background terang (sidebar) */
            --color-text-on-light-primary: #333333; /* Warna teks gelap di background terang */
        }

        /* Mengaplikasikan variabel CSS ke kelas Tailwind */
        .bg-custom-primary-red { background-color: var(--color-primary-red); }
        .hover\:bg-custom-primary-red-darker:hover { background-color: var(--color-primary-red-darker); }
        .text-custom-primary-red { color: var(--color-primary-red); }

        .bg-custom-sidebar-bg { background-color: var(--color-sidebar-bg); }
        .hover\:bg-custom-sidebar-hover:hover { background-color: var(--color-sidebar-hover); }
        .bg-custom-sidebar-active { background-color: var(--color-sidebar-active); }
        .text-on-dark { color: var(--color-text-on-dark); } /* Digunakan untuk teks di sidebar (sekarang putih) */
        .text-on-light-primary { color: var(--color-text-on-light-primary); }

        /* Custom scrollbar untuk sidebar */
        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #F0F0F0; /* Track scrollbar abu-abu terang */
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: var(--color-primary-red); /* Thumb scrollbar merah */
            border-radius: 3px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: var(--color-primary-red-darker);
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-gray-100 font-sans"> {{-- Menambahkan font-sans default Tailwind --}}

    {{-- Header (Top Bar) --}}
    <header class="bg-white shadow-md p-4 flex justify-between items-center z-10">
        <div class="flex items-center">
            {{-- Logo / Nama Aplikasi --}}
            <span class="text-2xl font-bold text-custom-primary-red">Gallery Apps</span> {{-- Teks logo merah --}}
            {{-- Search Bar (contoh sederhana) --}}
            <div class="ml-8 relative hidden md:block"> {{-- Sembunyikan di mobile, tampilkan di md ke atas --}}
                <input type="text" placeholder="Cari di sini..." class="pl-10 pr-4 py-2 rounded-full border border-gray-300 bg-gray-50 text-gray-800 focus:outline-none focus:ring-2 focus:ring-custom-primary-red"> {{-- Ring fokus merah --}}
                <i class="fas fa-search absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
            </div>
        </div>
        <nav class="flex items-center space-x-4">
            {{-- Tampilan Admin Gallery Apps --}}
            <span class="text-gray-800 font-semibold text-lg">Admin Gallery Apps</span>
            {{-- Form Logout --}}
            <form method="POST" action="{{ route('admin.logout') }}"> {{-- Pastikan rute logout benar --}}
                @csrf
                <button type="submit" class="bg-custom-primary-red hover:bg-custom-primary-red-darker text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300 ease-in-out">
                    Logout
                </button>
            </form>
        </nav>
    </header>

    {{-- Main Content Area (Sidebar + Content) --}}
    <div class="flex flex-1">

        {{-- Sidebar - Latar belakang putih, teks gelap --}}
        <aside class="w-64 bg-custom-sidebar-bg text-on-dark flex flex-col p-4 shadow-lg overflow-y-auto sidebar-scroll">
            <div class="text-xl font-semibold mb-6 text-custom-primary-red text-center">Admin Panel</div> {{-- Warna teks merah --}}
            <nav class="flex-grow">
                <ul>
                    <li class="mb-2">
                        <a href="{{ route('admin.dashboard') }}" class="flex items-center p-3 rounded-lg text-on-dark hover:bg-custom-sidebar-hover transition duration-200 {{ request()->routeIs('admin.dashboard') ? 'bg-custom-sidebar-active text-white' : '' }}">
                            <i class="fas fa-home mr-3"></i> Beranda
                        </a>
                    </li>
                    <li class="mb-2">
                        {{-- MODIFIKASI DI SINI --}}
                        <a href="{{ route('admin.verifikasi') }}" class="flex items-center p-3 rounded-lg text-on-dark hover:bg-custom-sidebar-hover transition duration-200 {{ request()->routeIs('admin.verifikasi') ? 'bg-custom-sidebar-active text-white' : '' }}">
                            <i class="fas fa-check-circle mr-3"></i> Verifikasi
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-3 rounded-lg text-on-dark hover:bg-custom-sidebar-hover transition duration-200">
                            <i class="fas fa-history mr-3"></i> Riwayat
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-3 rounded-lg text-on-dark hover:bg-custom-sidebar-hover transition duration-200">
                            <i class="fas fa-newspaper mr-3"></i> Berita
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-3 rounded-lg text-on-dark hover:bg-custom-sidebar-hover transition duration-200">
                            <i class="fas fa-th-list mr-3"></i> Kategori
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="#" class="flex items-center p-3 rounded-lg text-on-dark hover:bg-custom-sidebar-hover transition duration-200">
                            <i class="fas fa-archive mr-3"></i> Arsip
                        </a>
                    </li>
                    {{-- Tambahkan menu sidebar lainnya di sini --}}
                </ul>
            </nav>
            {{-- Footer Sidebar (misal copyright) --}}
            <div class="mt-auto text-sm text-gray-500 text-center py-4"> {{-- Ubah ke gray-500 agar lebih terlihat --}}
                Copyright By Gallery App
            </div>
        </aside>

        {{-- Content Area - Latar belakang abu-abu muda --}}
        <main class="flex-grow p-6 overflow-y-auto">
            @yield('content')
        </main>
    </div>

    {{-- Script JavaScript Anda di sini --}}
    {{-- Jika Anda menggunakan Vite (Laravel 9+), pastikan ini ada di layout utama --}}
    {{-- @vite('resources/js/app.js') --}}
    {{-- Atau jika menggunakan Laravel Mix (Laravel 8-): --}}
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}

    {{-- Ini penting untuk script Chart.js dan script spesifik halaman lainnya --}}
    @stack('scripts') 
</body>
</html>
