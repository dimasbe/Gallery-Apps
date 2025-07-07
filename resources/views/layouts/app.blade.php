<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'GalleryApps') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        @media (width >= 64rem) {
                    .hidden-burger{
                        display: none !important
                    }
                }
        /* Gaya tambahan untuk scrollbar notifikasi */
        #notificationDropdown .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        #notificationDropdown .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        #notificationDropdown .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #888;
            border-radius: 10px;
        }

        #notificationDropdown .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #555;
        }

        /* Dark mode scrollbar */
        .dark #notificationDropdown .custom-scrollbar::-webkit-scrollbar-track {
            background: #2a2a27; /* Darker track */
        }

        .dark #notificationDropdown .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #555; /* Darker thumb */
        }

        .dark #notificationDropdown .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #777; /* Even darker thumb on hover */
        }

        /* Mobile Menu Styles */
        .mobile-menu {
            transition: transform 0.3s ease-out;
            transform: translateX(100%);
        }

        .mobile-menu.open {
            transform: translateX(0);
        }
    </style>
</head>

@stack('head')

<body class="bg-[#FDFDFC] text-[#1b1b18] min-h-screen font-[Poppins]">
    <header class="fixed top-0 left-0 w-full z-50 shadow-sm bg-white">
        <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            {{-- LOGO --}}
            <div class="flex items-center space-x-4">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="w-[150px] h-[70px] object-cover rounded-full">
                </a>
            </div>

            {{-- MENU (Hidden on small screens, shown on large screens) --}}
            <div class="hidden lg:flex items-center space-x-10 text-[15px] font-medium">
                <a href="/"
                class="{{ request()->is('/') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Beranda
                </a>

                <a href="/aplikasi"
                class="{{ request()->is('aplikasi*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Aplikasi
                </a>

                <a href="/kategori"
                class="{{ request()->is('kategori*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Kategori
                </a>

                <a href="/berita"
                class="{{ request()->is('berita*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                Berita
                </a>
            </div>

            {{-- USER MENU & Hamburger Button --}}
            <div class="flex items-center space-x-3 relative">
                @auth
                    {{-- DROPDOWN NOTIFIKASI (sesuai gambar) --}}
                    <div class="relative cursor-pointer" onclick="toggleNotificationDropdown()">
                        <svg class="w-6 h-6 text-gray-700" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        {{-- Dot notifikasi belum dibaca (sesuai gambar) --}}
                        <span id="globalNotificationDot" class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white hidden"></span>
                    </div>

                    {{-- Dropdown notifikasi (sesuai gambar) --}}
                    <div id="notificationDropdown" class="hidden absolute right-0 top-12 w-80 bg-white rounded-md shadow-lg z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200">
                            <p class="text-sm font-semibold text-gray-900">Notifikasi</p>
                        </div>
                        <div class="py-1 max-h-60 overflow-y-auto custom-scrollbar">
                            
                            @if ($notifications->count() > 0)
                            @foreach($notifications as $notification)
                                        <div data-notification-id="{{ $notification->id }}" class="notification-item flex items-start px-4 py-3 hover:bg-gray-100 cursor-pointer @if(!$notification->dibaca) unread-notification @endif">
                                            <div class="flex-grow overflow-hidden">
                                                <p class="text-sm font-medium text-gray-900">{{ $notification->judul }}</p>
                                                <p class="text-xs text-gray-600">{{ $notification->pesan }}</p>
                                            </div>
                                            <div class="ml-3 flex-shrink-0 text-right">
                                                <p class="text-xs text-gray-500 mt-1" data-original-time="{{ $notification->created_at }}">{{ $notification->created_at->diffForHumans() }}</p>
                                                @if(!$notification->dibaca)
                                                    <span class="unread-dot block h-2 w-2 rounded-full bg-blue-500 ml-auto mt-1"></span>
                                                @endif
                                            </div>
                                        </div>
                                @endforeach
                            @else
                                <div class="flex-grow overflow-hidden px-4 py-3">
                                    <p class="text-sm text-gray-400">
                                        Tidak Ada Notifikasi
                                    </p>
                                </div>
                            @endif 
                        </div>
                    </div>

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

                    {{-- TOMBOL PROFILE INI --}}
                    <button onclick="toggleDropdown()" class="flex items-center space-x-2 focus:outline-none hidden lg:flex"> {{-- Hidden on mobile --}}
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

                        <span class="ml-2 text-[#1b1b18] font-medium hidden sm:inline select-none">
                            {{ $name }}
                        </span>
                        <svg class="w-4 h-4 text-gray-500" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.184l3.71-3.954a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                        </svg>
                    </button>

                    <div id="dropdownMenu" class="hidden absolute right-0 top-12 w-44 bg-white rounded-md shadow-lg z-50">
                        <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[#1b1b18] hover:bg-gray-100">Edit Profil</a>
                        <a href="{{ route('tambah_aplikasi.index') }}" class="block px-4 py-2 text-sm text-[#1b1b18] hover:bg-gray-100">Tambah Aplikasi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#1b1b18] hover:bg-gray-100">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                    @if (Route::has('login'))
                        {{-- Tautan Login di header yang akan membuka modal --}}
                        <button onclick="openModal()" class="px-4 py-2 border border-[#e3e3e0] text-[#1b1b18] hover:border-black rounded-md text-sm hidden lg:block"> {{-- Hidden on mobile --}}
                            Login
                        </button>
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}" class="px-4 py-2 bg-[#AD1500] text-white rounded-md text-sm hover:bg-[#8F1000] hidden lg:block"> {{-- Hidden on mobile --}}
                                Register
                            </a>
                        @endif
                    @endif
                @endauth

                {{-- Hamburger Menu Button (Shown only on small screens) --}}
                <div class="hidden-burger">
                    <button id="hamburgerButton" class="text-gray-700 focus:outline-none">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>
        </nav>

        {{-- Mobile Menu (Hidden by default, shown when hamburger is clicked) --}}
        <div id="mobileMenu" class="mobile-menu fixed top-0 right-0 h-full w-64 bg-white shadow-lg z-40 lg:hidden">
            <div class="flex justify-end p-4">
                <button id="closeMobileMenuButton" class="text-gray-700 focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <div class="flex flex-col space-y-4 px-4 py-2 text-[15px] font-medium">
                <a href="/"
                   class="{{ request()->is('/') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                    Beranda
                </a>
                <a href="/aplikasi"
                   class="{{ request()->is('aplikasi*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                    Aplikasi
                </a>
                <a href="/kategori"
                   class="{{ request()->is('kategori*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                    Kategori
                </a>
                <a href="/berita"
                   class="{{ request()->is('berita*') ? 'underline underline-offset-4 decoration-[#AD1500] decoration-2' : '' }} text-[#1b1b18] hover:underline underline-offset-4 decoration-[#AD1500] decoration-2">
                    Berita
                </a>
                @auth
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-[#1b1b18] hover:bg-gray-100">Edit Profil</a>
                    <a href="{{ route('tambah_aplikasi.index') }}" class="block px-4 py-2 text-sm text-[#1b1b18] hover:bg-gray-100">Tambah Aplikasi</a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#1b1b18] hover:bg-gray-100">
                            Logout
                        </button>
                    </form>
                @else
                    <button onclick="openModal(); closeMobileMenu()" class="px-4 py-2 border border-[#e3e3e0] text-[#1b1b18] hover:border-black rounded-md text-sm w-full text-center">
                        Login
                    </button>
                    <a href="{{ route('register') }}" class="px-4 py-2 bg-[#AD1500] text-white rounded-md text-sm hover:bg-[#8F1000] text-center">
                        Register
                    </a>
                @endauth
            </div>
        </div>
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
    <footer class="w-full bg-white mt-20 px-2 py-4 border-t border-gray-150">
        <div class="max-w-7xl mx-auto px-2 py-6">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
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
                    <h3 class="font-semibold text-lg text-gray-800 mb-4">Sosial Media</h3>
                    <div class="flex space-x-4">
                        <a href="https://www.facebook.com/hummatech" class="text-[#AD1500] hover:opacity-80" aria-label="Facebook">
                            <img src="/images/icon_facebook.png" alt="Facebook" class="w-6 h-6" />
                        </a>
                        <a href="https://x.com/hummatech" class="text-[#AD1500] hover:opacity-80" aria-label="Twitter">
                            <img src="/images/icon_twitter.png" alt="Twitter" class="w-6 h-6" />
                        </a>
                        <a href="https://www.instagram.com/hummatech/" class="text-[#AD1500] hover:opacity-80" aria-label="Instagram">
                            <img src="/images/icon_instagram.png" alt="Instagram" class="w-6 h-6" />
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- Border garis full width + copyright yang lebih pendek --}}
        <div class="border-t border-gray-200 w-full">
            <div class="max-w-7xl mx-auto px-2 py-2 text-gray-500 text-xs flex flex-col sm:flex-row justify-center sm:justify-between items-center text-center">
                <div>2025 Hummatech All Rights Reserved</div>
                <div>Copyright By GalerryApp</div>
            </div>
        </div>
    </footer>

    {{-- Pop-up Notifikasi (Ditempatkan langsung di app.blade.php) --}}
    <div id="notificationPopupOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] hidden">
        <div id="notificationPopup" class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 relative m-4 flex flex-col items-center">
            {{-- Tombol Tutup di Pojok Kanan Atas --}}
            <button onclick="closeNotificationPopup()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Judul Notifikasi (di tengah) --}}
            <h3 id="popupNotificationTitle" class="text-lg font-bold text-gray-900 mb-1 text-center"></h3>
            {{-- Waktu Notifikasi (di tengah) --}}
            <p id="popupNotificationTime" class="text-xs text-gray-500 mb-4 text-center"></p>

            {{-- Card untuk Konten Notifikasi (di tengah) --}}
            <div class="bg-[#F7F7F7] rounded-md p-4 mb-6 w-full">
                <p id="popupNotificationContent" class="text-sm text-gray-700 leading-relaxed text-center"></p>
            </div>
            
            {{-- Tombol Tutup (di tengah) --}}
            <button onclick="closeNotificationPopup()" class="px-6 py-2 bg-[#AD1500] text-white rounded-md hover:bg-[#8F1000] focus:outline-none focus:ring-2 focus:ring-[#AD1500] focus:ring-opacity-50">Tutup</button>
        </div>
    </div>
    
    {{-- MODAL LOGIN (Disamakan dengan tampilan Register) --}}
<div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
    <div class="w-[460px] bg-white rounded-xl shadow p-8 relative">
        <button onclick="closeLoginModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 text-2xl font-semibold">
            &times;
        </button>
        <h2 class="text-[24px] font-bold text-black text-center mb-1">Login</h2>
        <p class="text-center text-[13px] text-black mb-6">Selamat Datang Kembali di GalleryApps</p>

        {{-- Notifikasi Error Umum untuk Modal Login (jika ada error yang tidak terkait langsung dengan input) --}}
        @if (session('error') && !($errors->has('email') || $errors->has('password')))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                <span class="block">{{ session('error') }}</span>
            </div>
        @endif

        <form id="loginForm" method="POST" action="{{ route('login') }}" class="space-y-4" novalidate>
            @csrf

            <div>
                <label for="login_email" class="block text-sm font-medium text-black mb-1">Email</label>
                <input id="login_email" name="email" type="email" required autofocus
                    class="w-full h-[40px] px-4 border border-gray-300 rounded-md bg-white text-sm text-black @error('email') border-red-500 @enderror"
                    placeholder="Masukkan email anda" autocomplete="email" value="{{ old('email') }}">
                <p class="text-red-500 text-xs italic mt-1 hidden" id="error-login_email">Email wajib diisi.</p>
                @error('email')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="login_password" class="block text-sm font-medium text-black mb-1">Password</label>
                <div class="relative">
                    <input id="login_password" name="password" type="password" required autocomplete="current-password"
                        class="w-full h-[40px] px-4 pr-10 border border-gray-300 rounded-md bg-white text-sm text-black @error('password') border-red-500 @enderror"
                        placeholder="Masukkan password anda">
                    <button type="button" onclick="togglePassword(this, 'login_password')" class="absolute right-3 top-1/2 -translate-y-1/2 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-icon w-5 h-5 text-gray-500 block" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path d="M2.458 12C3.732 7.943 7.523 5 12 5
                                s8.268 2.943 9.542 7-3.732 7-9.542 7
                                -8.268-2.943-9.542-7z" />
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="eye-off-icon w-5 h-5 text-gray-500 hidden" fill="none"
                            stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path d="M13.875 18.825A10.05 10.05 0 0112 19
                                c-4.478 0-8.269-2.944-9.543-7
                                a9.956 9.956 0 012.342-3.36m3.093-2.52
                                A9.953 9.953 0 0112 5c4.478 0 8.269 2.944 9.543 7
                                a9.956 9.956 0 01-1.88 3.106" />
                            <path d="M3 3l18 18" />
                        </svg>
                    </button>
                </div>
                <p class="text-red-500 text-xs italic mt-1 hidden" id="error-login_password">Password wajib diisi.</p>
                @error('password')
                    <p class="text-red-500 text-xs italic mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <input id="login_remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                    <label for="login_remember_me" class="ml-2 block text-sm text-black">Ingat saya</label>
                </div>
                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                        Lupa kata sandi Anda?
                    </a>
                @endif
            </div>

            <button type="submit" class="w-full h-[40px] mt-2 bg-[#AD1500] text-white font-semibold text-sm rounded-md transition-all">
                Login
            </button>
        </form>

        <div class="flex items-center my-6">
            <hr class="flex-grow border-gray-300">
            <span class="mx-3 text-gray-500 text-sm">Atau</span>
            <hr class="flex-grow border-gray-300">
        </div>

        <div class="flex justify-center">
            <a href="{{ route('google.redirect', ['from' => 'login']) }}"
                class="flex items-center gap-2 border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-black hover:bg-gray-100 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" class="w-5 h-5">
                <span>Login dengan Google</span>
            </a>
        </div>

        <div class="mt-6 text-center text-sm text-black">
            Belum punya akun?
            <a href="{{ route('register') }}" class="text-[#0500FF] hover:underline font-medium">Register</a>
        </div>
    </div>
</div>

<script>
    // Navbar Dropdown (User Profile)
    function toggleDropdown() {
        const dropdownMenu = document.getElementById('dropdownMenu');
        dropdownMenu.classList.toggle('hidden');
    }

    // Notification Dropdown
    function toggleNotificationDropdown() {
        const notificationDropdown = document.getElementById('notificationDropdown');
        notificationDropdown.classList.toggle('hidden');
        
        // Mark all unread notifications as read when the dropdown is opened
        const unreadNotifications = document.querySelectorAll('.notification-item'); // Select all notification items
        let unreadCountAfterOpen = 0; // Track unread after opening

        unreadNotifications.forEach(item => {
            if (item.classList.contains('unread-notification')) {
                const notificationId = item.dataset.notificationId;
                // Make an AJAX request to mark as read in the database
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        // Only remove classes if the server successfully marked as read
                        item.classList.remove('unread-notification');
                        const unreadDot = item.querySelector('.unread-dot');
                        if (unreadDot) {
                            unreadDot.classList.add('hidden');
                        }
                    } else {
                        console.error('Failed to mark notification as read:', response.statusText);
                        // If marking as read fails, keep it as unread
                        unreadCountAfterOpen++;
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                    // If error occurs, keep it as unread
                    unreadCountAfterOpen++;
                })
                .finally(() => {
                    // Update global dot after all async operations
                    updateGlobalNotificationDot();
                });
            }
        });
        updateGlobalNotificationDot(); // Initial update just in case (will be re-updated by finally blocks)
    }


    // Close dropdowns when clicking outside
    window.onclick = function(event) {
        if (!event.target.matches('button') && !event.target.closest('#dropdownMenu') && !event.target.closest('.relative.cursor-pointer') && !event.target.closest('#hamburgerButton') && !event.target.closest('#mobileMenu')) {
            const dropdownMenu = document.getElementById('dropdownMenu');
            if (!dropdownMenu.classList.contains('hidden')) {
                dropdownMenu.classList.add('hidden');
            }
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (!notificationDropdown.classList.contains('hidden')) {
                notificationDropdown.classList.add('hidden');
            }
            const mobileMenu = document.getElementById('mobileMenu');
            if (mobileMenu && mobileMenu.classList.contains('open')) {
                mobileMenu.classList.remove('open');
            }
        }
    };

    // Toggle Password Visibility in Login Modal
    function togglePassword(button, inputId) {
        const input = document.getElementById(inputId);
        const eyeIcon = button.querySelector('.eye-icon');
        const eyeOffIcon = button.querySelector('.eye-off-icon');

        if (input.type === "password") {
            input.type = "text";
            eyeIcon.classList.add('hidden');
            eyeOffIcon.classList.remove('hidden');
        } else {
            input.type = "password";
            eyeIcon.classList.remove('hidden');
            eyeOffIcon.classList.add('hidden');
        }
    }

    // Login Modal
    const loginModal = document.getElementById('loginModal');
    const loginForm = document.getElementById('loginForm');
    const loginEmailInput = document.getElementById('login_email');
    const loginPasswordInput = document.getElementById('login_password');
    const errorLoginEmail = document.getElementById('error-login_email');
    const errorLoginPassword = document.getElementById('error-login_password');

    function openModal() {
        loginModal.classList.remove('hidden');
    }

    function closeLoginModal() {
        loginModal.classList.add('hidden');
        // Clear previous error messages when closing the modal
        errorLoginEmail.classList.add('hidden');
        errorLoginPassword.classList.add('hidden');
        loginEmailInput.classList.remove('border-red-500');
        loginPasswordInput.classList.remove('border-red-500');
    }

    // Validate login form
    loginForm.addEventListener('submit', function(event) {
        let isValid = true;

        if (loginEmailInput.value.trim() === '') {
            errorLoginEmail.classList.remove('hidden');
            loginEmailInput.classList.add('border-red-500');
            isValid = false;
        } else {
            errorLoginEmail.classList.add('hidden');
            loginEmailInput.classList.remove('border-red-500');
        }

        if (loginPasswordInput.value.trim() === '') {
            errorLoginPassword.classList.remove('hidden');
            loginPasswordInput.classList.add('border-red-500');
            isValid = false;
        } else {
            errorLoginPassword.classList.add('hidden');
            loginPasswordInput.classList.remove('border-red-500');
        }

        if (!isValid) {
            event.preventDefault();
        }
    });

    // Check for errors on page load and open the modal if present
    @if ($errors->has('email') || $errors->has('password') || session('error'))
        document.addEventListener('DOMContentLoaded', function() {
            openModal();
        });
    @endif

    // Notification Popup
    const notificationPopupOverlay = document.getElementById('notificationPopupOverlay');
    const popupNotificationTitle = document.getElementById('popupNotificationTitle');
    const popupNotificationTime = document.getElementById('popupNotificationTime');
    const popupNotificationContent = document.getElementById('popupNotificationContent');

    document.querySelectorAll('.notification-item').forEach(item => {
        item.addEventListener('click', function() {
            const title = this.querySelector('p:nth-child(1)').textContent;
            const content = this.querySelector('p:nth-child(2)').textContent;
            const originalTime = this.querySelector('[data-original-time]').dataset.originalTime;

            popupNotificationTitle.textContent = title;
            popupNotificationContent.textContent = content;
            popupNotificationTime.textContent = formatNotificationTime(originalTime);

            notificationPopupOverlay.classList.remove('hidden');

            // Mark this specific notification as read (client-side only for now)
            this.classList.remove('unread-notification');
            const unreadDot = this.querySelector('.unread-dot');
            if (unreadDot) {
                unreadDot.classList.add('hidden');
            }
            updateGlobalNotificationDot();

            // Optionally, send an AJAX request to mark as read on the server
            const notificationId = this.dataset.notificationId;
            if (notificationId) {
                fetch(`/notifications/${notificationId}/mark-as-read`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                })
                .then(response => {
                    if (!response.ok) {
                        console.error('Failed to mark notification as read:', response.statusText);
                    }
                })
                .catch(error => {
                    console.error('Error marking notification as read:', error);
                });
            }
        });
    });

    function closeNotificationPopup() {
        notificationPopupOverlay.classList.add('hidden');
    }

    function formatNotificationTime(timestamp) {
        const date = new Date(timestamp);
        const now = new Date();
        const diffTime = Math.abs(now - date);
        const diffMinutes = Math.ceil(diffTime / (1000 * 60));
        const diffHours = Math.ceil(diffTime / (1000 * 60 * 60));
        const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

        if (diffMinutes < 60) {
            return `${diffMinutes} menit yang lalu`;
        } else if (diffHours < 24) {
            return `${diffHours} jam yang lalu`;
        } else if (diffDays < 7) {
            return `${diffDays} hari yang lalu`;
        } else {
            return date.toLocaleDateString('id-ID', {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            });
        }
    }

    // Global Notification Dot Logic
    function updateGlobalNotificationDot() {
        const globalDot = document.getElementById('globalNotificationDot');
        const unreadCount = document.querySelectorAll('.notification-item.unread-notification').length;
        if (unreadCount > 0) {
            globalDot.classList.remove('hidden');
        } else {
            globalDot.classList.add('hidden');
        }
    }

    // Initial check for unread notifications on page load
    document.addEventListener('DOMContentLoaded', updateGlobalNotificationDot);

    // Mobile Menu Logic
    const hamburgerButton = document.getElementById('hamburgerButton');
    const mobileMenu = document.getElementById('mobileMenu');
    const closeMobileMenuButton = document.getElementById('closeMobileMenuButton');

    hamburgerButton.addEventListener('click', () => {
        mobileMenu.classList.add('open');
    });

    closeMobileMenuButton.addEventListener('click', () => {
        mobileMenu.classList.remove('open');
    });

    function closeMobileMenu() {
        mobileMenu.classList.remove('open');
    }

</script>
</body>
</html>