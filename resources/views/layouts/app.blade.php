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
    <header class="fixed top-0 left-0 w-full z-50 shadow-sm bg-white dark:bg-[#1b1b18]">
        <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            {{-- LOGO --}}
            <div class="flex items-center space-x-4">
                <a href="/" class="{{ route('dashboard') }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-[150px] h-[70px] object-cover rounded-full">
                </a>
            </div>

            {{-- MENU --}}
            <div class="hidden lg:flex items-center space-x-10 text-[15px] font-medium">
                <a href="/"
                class="{{ request()->is('/') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Beranda
                </a>

                <a href="/aplikasi"
                class="{{ request()->is('aplikasi*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Aplikasi
                </a>

                <a href="/kategori"
                class="{{ request()->is('kategori*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Kategori
                </a>            
                
                <a href="/berita"
                class="{{ request()->is('berita*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] dark:text-[#EDEDEC] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Berita
                </a>
            </div>

            {{-- USER MENU --}}
            <div class="flex items-center space-x-3 relative">
                @auth
                    @php
                        $defaultAvatar = asset('images/default-avatar.png');
                        $avatarPath = Auth::user()->avatar ?? null;

                        function fixGoogleAvatarUrl($url) {
                            if (str_contains($url, 'lh3.googleusercontent.com')) {
                                if (!preg_match('/=s\d+(-c)?$/', $url)) {
                                    return $url . '=s256-c';
                                } else {
                                    return preg_replace('/=s\d+(-c)?$/', '=s256-c', $url);
                                }
                            }
                            return $url;
                        }

                        if ($avatarPath && filter_var($avatarPath, FILTER_VALIDATE_URL)) {
                            $avatarUrl = fixGoogleAvatarUrl($avatarPath);
                        } elseif ($avatarPath) {
                            $avatarUrl = asset('storage/' . $avatarPath);
                        } else {
                            $avatarUrl = null;
                        }

                        $name = Auth::user()->name ?? '';
                        $nameParts = preg_split('/\s+/', trim($name));
                        $initials = strtoupper(
                            collect($nameParts)->map(fn($part) => mb_substr($part, 0, 1))->implode('')
                        );
                        $initials = substr($initials, 0, 2);
                    @endphp

                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none">
                        @if ($avatarUrl)
                            <img
                                src="{{ $avatarUrl }}"
                                onerror="this.onerror=null;this.src='{{ $defaultAvatar }}';"
                                alt="Avatar"
                                class="w-10 h-10 rounded-full object-cover"
                            >
                        @else
                            <div class="w-10 h-10 rounded-full bg-[#AD1500] text-white flex items-center justify-center font-semibold text-lg select-none">
                                {{ $initials ?: '?' }}
                            </div>
                        @endif

                        <span class="ml-2 text-[#1b1b18] dark:text-[#EDEDEC] font-medium hidden sm:inline select-none">
                            {{ $name }}
                        </span>
                        <svg class="w-4 h-4 text-gray-500 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.184l3.71-3.954a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="dropdownMenu" class="hidden absolute right-0 top-12 w-44 bg-white dark:bg-[#1b1b18] rounded-md shadow-lg z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#2a2a27]">Edit Profil</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#2a2a27]">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    @if (Route::has('login'))
                        <a href="{{ route('login') }}" class="px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] hover:border-black dark:hover:border-white rounded-md text-sm">
                            Login
                        </a>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-[#AD1500] text-white rounded-md text-sm hover:bg-[#8F1000]">
                                Register
                            </a>
                        @endif
                    @endif
                @endauth
            </div>
        </nav>
    </header>

    {{-- FLASH NOTIFICATION --}}
    @if (session('status'))
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <span class="block sm:inline">{{ session('status') }}</span>
            </div>
        </div>
    @endif

    {{-- PAGE CONTENT --}}
    <main class="max-w-7xl mx-auto w-full px-4 sm:px-6 lg:px-8 py-6 pt-[120px]">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="w-full bg-white mt-20 px-4 py-8">
        <div class="max-w-7xl mx-auto px-2 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                {{-- Bagian Tentang Aplikasi --}}
                <div class="text-left">
                    <div class="flex items-center mb-4">
                        <img src="{{ asset('images/logo2.png') }}" alt="Logo Galerry Apps" class="w-12 h-12 rounded-full object-cover" />
                    </div>
                    <p class="text-gray-600 text-sm">
                        Galerry Apps adalah platform gratis untuk berbagai aplikasi buatan pengguna, tempat di mana siapa saja bisa mengunggah, menjelajahi, dan menemukan karya digital dari komunitas kreatif di seluruh Indonesia.
                    </p>
                </div>

                {{-- Bagian Alamat --}}
                <div class="text-left">
                    <h3 class="font-semibold text-lg text-gray-800 mb-4">Alamat</h3>
                    <ul class="text-gray-600 text-sm">
                        <li class="flex items-start mb-2">
                            <img src="/images/iconmaps.png" alt="Lokasi" class="w-5 h-5 mr-2 flex-shrink-0" />
                            <span>Perum Permata Regency 1 Blok 10 no 28<br />Ngijo Karangploso Malang</span>
                        </li>
                        <li class="flex items-center mb-2">
                            <img src="/images/icon_email.png" alt="Email" class="w-5 h-5 mr-2 flex-shrink-0" />
                            <span>galerryapps@gmail.com</span>
                        </li>
                        <li class="flex items-center">
                            <img src="/images/icon_telepon.png" alt="Telepon" class="w-5 h-5 mr-2 flex-shrink-0" />
                            <span>(+62) 82132560566</span>
                        </li>
                    </ul>
                </div>

                {{-- Bagian Sosial Media --}}
                <div class="text-left">
                    <h3 class="font-semibold text-lg text-gray-800 mb-4"></h3>
                    <div class="flex space-x-4">
                        <a href="#" class="text-[#AD1500] hover:opacity-80" aria-label="Facebook">
                            <img src="/images/icon_facebook.png" alt="Facebook" class="w-6 h-6" />
                        </a>
                        <a href="#" class="text-[#AD1500] hover:opacity-80" aria-label="Twitter">
                            <img src="/images/icon_twitter.png" alt="Twitter" class="w-6 h-6" />
                        </a>
                        <a href="#" class="text-[#AD1500] hover:opacity-80" aria-label="Instagram">
                            <img src="/images/icon_instagram.png" alt="Instagram" class="w-6 h-6" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Border garis full width + copyright yang lebih pendek --}}
        <div class="border-t border-gray-200 w-full">
            <div class="max-w-7xl mx-auto px-2 py-2 text-gray-500 text-xs flex justify-between">
                <div>2025 Hummatech All Rights Reserved</div>
                <div>Copyright By GalerryApp</div>
            </div>
        </div>
    </footer>

    {{-- Script for Dropdown --}}
    <script>
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
        }

        document.addEventListener('click', function (event) {
            const trigger = event.target.closest('button[onclick="toggleDropdown()"]');
            const dropdown = document.getElementById('dropdownMenu');
            const insideDropdown = event.target.closest('#dropdownMenu');
            if (!trigger && !insideDropdown && dropdown && !dropdown.classList.contains('hidden')) {
                dropdown.classList.add('hidden');
            }
        });
    </script>
</body>
</html>
