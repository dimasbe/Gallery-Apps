<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Font Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    <!-- Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen font-[Poppins]">
    <header class="w-full shadow-sm bg-white dark:bg-[#1b1b18]">
        @if (Route::has('login'))
            <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
                {{-- LOGO --}}
                <div class="flex items-center space-x-4">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-[150px] h-[70px] object-cover rounded-full">
                </div>

                {{-- MENU --}}
                <div class="hidden lg:flex items-center space-x-10 text-[15px] font-medium">
                    <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">Beranda</a>
                    <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">Aplikasi</a>
                    <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">Kategori</a>
                    <a href="#" class="text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">Berita</a>
                </div>

                {{-- USER MENU --}}
                <div class="flex items-center space-x-3 relative">
                    @auth
                        @php
                            $defaultAvatar = asset('images/default-avatar.png');
                            $googleAvatar = Auth::user()->google_avatar ?? null;
                            $localAvatar = Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : null;

                            // Validasi URL google avatar
                            $validGoogleAvatar = filter_var($googleAvatar, FILTER_VALIDATE_URL) ? $googleAvatar : null;

                            // Ambil inisial dari nama user
                            $name = Auth::user()->name ?? '';
                            $nameParts = preg_split('/\s+/', trim($name));
                            $initials = '';
                            foreach ($nameParts as $part) {
                                $initials .= mb_substr($part, 0, 1);
                            }
                            $initials = strtoupper(substr($initials, 0, 2));

                            // Prioritas: lokal > google avatar valid > null (untuk inisial)
                            $avatarUrl = $localAvatar ?: $validGoogleAvatar ?: null;
                        @endphp

                        <button type="button" onclick="toggleDropdown()" class="flex items-center focus:outline-none">
                            @if ($avatarUrl)
                                <img
                                    src="{{ $avatarUrl }}"
                                    onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';"
                                    alt="Avatar"
                                    class="w-10 h-10 rounded-full object-cover"
                                >
                            @else
                                {{-- Tampilkan lingkaran inisial --}}
                                <div class="w-10 h-10 rounded-full bg-[#AD1500] text-white flex items-center justify-center font-semibold text-lg select-none">
                                    {{ $initials ?: '?' }}
                                </div>
                            @endif
                            <span class="ml-2 text-[#1b1b18] dark:text-[#EDEDEC] font-medium hidden sm:inline">
                                {{ $name }}
                            </span>
                            <svg class="w-4 h-4 ml-1 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.184l3.71-3.954a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <!-- Flash Notification -->
            @if (session('status'))
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('status') }}</span>
                    </div>
                </div>
            @endif

            <main>
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
