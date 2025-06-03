<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title>{{ config('app.name', 'Laravel') }}</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
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
    </style>
</head>
<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] min-h-screen font-[Poppins]">
    <header class="fixed top-0 left-0 w-full z-50 shadow-sm bg-white dark:bg-[#1b1b18]">
        <nav class="flex items-center justify-between px-6 py-4 max-w-7xl mx-auto">
            {{-- LOGO --}}
            <div class="flex items-center space-x-4">
                <a href="/" class="{{ request()->is('/') ? 'active' : '' }}">
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
                    {{-- DROPDOWN NOTIFIKASI (sesuai gambar) --}}
                    <div class="relative cursor-pointer" onclick="toggleNotificationDropdown()">
                        <svg class="w-6 h-6 text-gray-700 dark:text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"></path>
                        </svg>
                        {{-- Dot notifikasi belum dibaca (sesuai gambar) --}}
                        <span id="globalNotificationDot" class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500 ring-2 ring-white hidden"></span>
                    </div>

                    {{-- Dropdown notifikasi (sesuai gambar) --}}
                    <div id="notificationDropdown" class="hidden absolute right-0 top-12 w-80 bg-white dark:bg-[#1b1b18] rounded-md shadow-lg z-50 overflow-hidden">
                        <div class="px-4 py-3 border-b border-gray-200 dark:border-gray-700">
                            <p class="text-sm font-semibold text-gray-900 dark:text-white">Notifikasi</p>
                        </div>
                        <div class="py-1 max-h-60 overflow-y-auto custom-scrollbar">
                            {{-- Contoh item notifikasi - GANTI DENGAN DATA DARI DATABASE ANDA --}}
                            {{-- Notifikasi 1: Upload Aplikasi Berhasil--}}
                            <div class="notification-item flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-[#2a2a27] cursor-pointer unread-notification">
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Upload Aplikasi Berhasil</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Aplikasi "Kalkulator Pintar" sudah berhasil diunggah.</p>
                                </div>
                                <div class="ml-3 flex-shrink-0 text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-original-time="7.14 AM">7.14 AM</p>
                                    <span class="unread-dot block h-2 w-2 rounded-full bg-blue-500 ml-auto mt-1"></span>
                                </div>
                            </div>
                            {{-- Notifikasi 2: Fitur Baru Telah Hadir--}}
                            <div class="notification-item flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-[#2a2a27] cursor-pointer unread-notification">
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Fitur Baru Telah Hadir</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Sekarang kamu bisa menambahkan changelog aplikasi.</p>
                                </div>
                                <div class="ml-3 flex-shrink-0 text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-original-time="Kemarin">Kemarin</p>
                                    <span class="unread-dot block h-2 w-2 rounded-full bg-blue-500 ml-auto mt-1"></span>
                                </div>
                            </div>
                            {{-- Notifikasi 3: Selamat Datang di Galery Apps!--}}
                            <div class="notification-item flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-[#2a2a27] cursor-pointer unread-notification">
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Selamat Datang di Galery Apps!</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Yuk mulai unggah aplikasi pertamamu.</p>
                                </div>
                                <div class="ml-3 flex-shrink-0 text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-original-time="Sabtu">Sabtu</p>
                                    <span class="unread-dot block h-2 w-2 rounded-full bg-blue-500 ml-auto mt-1"></span>
                                </div>
                            </div>
                            {{-- Notifikasi 4: Maintenance Terjadwal--}}
                            <div class="notification-item flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-[#2a2a27] cursor-pointer">
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Maintenance Terjadwal</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Galery Apps akan offline sementara malam ini.</p>
                                </div>
                                <div class="ml-3 flex-shrink-0 text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-original-time="05/01/2025">05/01/2025</p>
                                    {{-- Dot biru tidak ada karena sudah dibaca --}}
                                </div>
                            </div>
                             {{-- Notifikasi 5: Sistem Dalam Pemeliharaan--}}
                            <div class="notification-item flex items-start px-4 py-3 hover:bg-gray-100 dark:hover:bg-[#2a2a27] cursor-pointer">
                                <div class="flex-grow overflow-hidden">
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">Sistem Dalam Pemeliharaan</p>
                                    <p class="text-xs text-gray-600 dark:text-gray-400">Galery Apps akan offline sementara malam ini.</p>
                                </div>
                                <div class="ml-3 flex-shrink-0 text-right">
                                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-1" data-original-time="05/01/2025">05/01/2025</p>
                                    {{-- Dot biru tidak ada karena sudah dibaca --}}
                                </div>
                            </div>
                        </div>
                        {{-- <a href="/semua-notifikasi" class="block text-center text-sm px-4 py-2 text-[#AD1500] dark:text-[#F39C12] hover:bg-gray-100 dark:hover:bg-[#2a2a27] border-t border-gray-200 dark:border-gray-700">Lihat Semua</a> --}}
                        {{-- Baris di atas dihilangkan untuk menghapus tombol "Lihat Semua" --}}
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
                        <a href="{{ route('user_login.aplikasi.index') }}" class="block px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#2a2a27]">Tambah Aplikasi</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left px-4 py-2 text-sm text-[#1b1b18] dark:text-[#EDEDEC] hover:bg-gray-100 dark:hover:bg-[#2a2a27]">
                                Logout
                            </button>
                        </form>
                    </div>
                @else
                   @if (Route::has('login'))
                        {{-- Tautan Login di header yang akan membuka modal --}}
                         <button onclick="openModal()" class="px-4 py-2 border border-[#e3e3e0] dark:border-[#3E3E3A] text-[#1b1b18] dark:text-[#EDEDEC] hover:border-black dark:hover:border-white rounded-md text-sm">
                            Login
                         </button>
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
                    <h3 class="font-semibold text-lg text-gray-800 mb-4">Sosial Media</h3>
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

    {{-- Pop-up Notifikasi (Ditempatkan langsung di app.blade.php) --}}
    <div id="notificationPopupOverlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-[9999] hidden">
        <div id="notificationPopup" class="bg-white dark:bg-[#1b1b18] rounded-lg shadow-xl max-w-md w-full p-6 relative m-4 flex flex-col items-center">
            {{-- Tombol Tutup di Pojok Kanan Atas --}}
            <button onclick="closeNotificationPopup()" class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 dark:text-gray-500 dark:hover:text-gray-300">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                </svg>
            </button>

            {{-- Judul Notifikasi (di tengah) --}}
            <h3 id="popupNotificationTitle" class="text-lg font-bold text-gray-900 dark:text-white mb-1 text-center"></h3>
            {{-- Waktu Notifikasi (di tengah) --}}
            <p id="popupNotificationTime" class="text-xs text-gray-500 dark:text-gray-400 mb-4 text-center"></p>

            {{-- Card untuk Konten Notifikasi (di tengah) --}}
            <div class="bg-[#F7F7F7] dark:bg-[#2a2a27] rounded-md p-4 mb-6 w-full">
                <p id="popupNotificationContent" class="text-sm text-gray-700 dark:text-gray-300 leading-relaxed text-center"></p>
            </div>
            
            {{-- Tombol Tutup (di tengah) --}}
            <button onclick="closeNotificationPopup()" class="px-6 py-2 bg-[#AD1500] text-white rounded-md hover:bg-[#8F1000] focus:outline-none focus:ring-2 focus:ring-[#AD1500] focus:ring-opacity-50">Tutup</button>
        </div>
    </div>
    
    {{-- MODAL LOGIN (Disamakan dengan tampilan Register) --}}
    <div id="loginModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center hidden z-50">
        <div class="w-[460px] bg-white rounded-xl shadow p-8 relative">
            <button onclick="closeModal()" class="absolute top-3 right-3 text-gray-500 hover:text-gray-700 dark:text-gray-300 dark:hover:text-gray-100 text-2xl font-semibold">
                &times;
            </button>
            <h2 class="text-[24px] font-bold text-black text-center mb-1">Login</h2>
            <p class="text-center text-[13px] text-black mb-6">Selamat Datang Kembali di GalleryApps</p>

            {{-- Notifikasi Error untuk Modal Login --}}
            @if ($errors->has('email') || $errors->has('password') || session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4" role="alert">
                    @if ($errors->has('email'))
                        <span class="block">{{ $errors->first('email') }}</span>
                    @endif
                    @if ($errors->has('password'))
                        <span class="block">{{ $errors->first('password') }}</span>
                    @endif
                    @if (session('error'))
                        <span class="block">{{ session('error') }}</span>
                    @endif
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="login_email" class="block text-sm font-medium text-black mb-1">Email</label>
                    <input id="login_email" name="email" type="email" required autofocus
                           class="w-full h-[40px] px-4 border border-gray-300 rounded-md bg-white text-sm text-black"
                           placeholder="Masukkan email anda" autocomplete="email">
                </div>

                <div>
                    <label for="login_password" class="block text-sm font-medium text-black mb-1">Password</label>
                    <div class="relative">
                        <input id="login_password" name="password" type="password" required autocomplete="current-password"
                               class="w-full h-[40px] px-4 pr-10 border border-gray-300 rounded-md bg-white text-sm text-black"
                               placeholder="Masukkan password anda">
                        <button type="button" onclick="togglePassword(this)" class="absolute right-3 top-1/2 -translate-y-1/2 z-10">
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

    {{-- Script for Dropdown and Notification --}}
    <script>
        // Fungsi untuk dropdown profil
        function toggleDropdown() {
            const dropdown = document.getElementById('dropdownMenu');
            dropdown.classList.toggle('hidden');
            // Jika dropdown notifikasi terbuka, tutup
            const notificationDropdown = document.getElementById('notificationDropdown');
            if (notificationDropdown && !notificationDropdown.classList.contains('hidden')) {
                notificationDropdown.classList.add('hidden');
            }
            // Tutup pop-up juga jika terbuka
            closeNotificationPopup();
        }

        // Fungsi untuk menampilkan/menyembunyikan dropdown notifikasi
        function toggleNotificationDropdown() {
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('hidden');
            // Jika dropdown profil terbuka, tutup
            const profileDropdown = document.getElementById('dropdownMenu');
            if (profileDropdown && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }
            // Tutup pop-up juga jika terbuka
            closeNotificationPopup();
        }

        // Fungsi untuk menampilkan pop-up notifikasi
        function showNotificationPopup(title, time, content) {
            document.getElementById('popupNotificationTitle').innerText = title;
            document.getElementById('popupNotificationTime').innerText = time;
            document.getElementById('popupNotificationContent').innerText = content;
            document.getElementById('notificationPopupOverlay').classList.remove('hidden');
            // Sembunyikan dropdown notifikasi jika terbuka
            document.getElementById('notificationDropdown').classList.add('hidden');
        }

        // Fungsi untuk menutup pop-up notifikasi
        function closeNotificationPopup() {
            document.getElementById('notificationPopupOverlay').classList.add('hidden');
        }

        // Menutup dropdown/pop-up jika user mengklik di luar area
        document.addEventListener('click', function (event) {
            // Logic untuk dropdown profil
            const profileTrigger = event.target.closest('button[onclick="toggleDropdown()"]');
            const profileDropdown = document.getElementById('dropdownMenu');
            const insideProfileDropdown = event.target.closest('#dropdownMenu');
            if (profileDropdown && !profileTrigger && !insideProfileDropdown && !profileDropdown.classList.contains('hidden')) {
                profileDropdown.classList.add('hidden');
            }

            // Logic untuk dropdown notifikasi
            const notificationIconTrigger = event.target.closest('div.relative.cursor-pointer'); // Ini adalah div pembungkus ikon lonceng
            const notificationDropdown = document.getElementById('notificationDropdown');
            const insideNotificationDropdown = event.target.closest('#notificationDropdown');

            if (notificationDropdown && !notificationIconTrigger && !insideNotificationDropdown && !notificationDropdown.classList.contains('hidden')) {
                notificationDropdown.classList.add('hidden');
            }

            // Logic untuk pop-up notifikasi (tutup jika klik di luar pop-up tapi bukan di dalam notifikasi dropdown/ikon)
            const notificationPopupOverlay = document.getElementById('notificationPopupOverlay');
            const notificationPopup = document.getElementById('notificationPopup');
            // Pastikan klik tidak berasal dari dalam pop-up, tidak dari dalam dropdown notifikasi, dan tidak dari ikon notifikasi
            if (notificationPopupOverlay && !notificationPopup.contains(event.target) && !insideNotificationDropdown && !notificationIconTrigger) {
                if (!notificationPopupOverlay.classList.contains('hidden')) {
                    closeNotificationPopup();
                }
            }
        });

        // --- Logika untuk notifikasi belum dibaca ---

        // Fungsi untuk memperbarui dot merah pada ikon lonceng utama
        function updateGlobalUnreadNotificationDot() {
            const unreadCount = document.querySelectorAll('#notificationDropdown .unread-notification').length;
            const globalNotificationDot = document.getElementById('globalNotificationDot');

            if (globalNotificationDot) {
                if (unreadCount > 0) {
                    globalNotificationDot.classList.remove('hidden');
                } else {
                    globalNotificationDot.classList.add('hidden');
                }
            }
        }

        // Fungsi untuk menandai notifikasi individual sebagai sudah dibaca
        function markNotificationAsRead(notificationElement) {
            if (notificationElement && notificationElement.classList.contains('unread-notification')) {
                notificationElement.classList.remove('unread-notification');
                const unreadDot = notificationElement.querySelector('.unread-dot');
                if (unreadDot) {
                    unreadDot.classList.add('hidden'); // Sembunyikan dot biru
                }
                updateGlobalUnreadNotificationDot(); // Perbarui jumlah notifikasi belum dibaca
                // TODO: Di sini Anda bisa mengirim permintaan AJAX ke server untuk menandai notifikasi sebagai dibaca di database
            }
        }

        // Fungsi untuk memformat waktu sesuai gambar (Hari ini, Kemarin, Sabtu, atau MM/DD/YYYY) menjadi "Hari, DD Bln, HH.MM AM/PM"
        function formatTimeForPopup(originalTime) {
            const now = new Date();
            const dayOfWeek = ["Min", "Sen", "Sel", "Rab", "Kam", "Jum", "Sab"];
            const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
            let displayDate = "";
            let displayTime = "";
            let dateObj;

            if (originalTime.toLowerCase() === "hari ini") {
                dateObj = now;
                displayTime = now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit', hour12: true });
            } else if (originalTime.toLowerCase() === "kemarin") {
                dateObj = new Date(now);
                dateObj.setDate(now.getDate() - 1);
                displayTime = "09.00 AM"; // Placeholder, idealnya dari data notifikasi asli
            } else if (originalTime.toLowerCase() === "sabtu") {
                // Ini perlu logika yang lebih cerdas untuk menentukan Sabtu yang tepat.
                // Untuk sementara, kita asumsikan Sabtu yang paling dekat di masa lalu jika hari ini bukan Sabtu.
                dateObj = new Date(now);
                dateObj.setDate(now.getDate() - (now.getDay() + 7 - 6) % 7); // 6 adalah indeks hari Sabtu
                displayTime = "08.00 PM"; // Placeholder
            } else if (originalTime.match(/^\d{1,2}\.\d{2}\s(AM|PM)$/i)) { // Contoh: "7.14 AM"
                dateObj = now; // Asumsi hari ini jika hanya waktu
                displayTime = originalTime;
            } else if (originalTime.match(/^\d{2}\/\d{2}\/\d{4}$/)) { // Contoh: "05/01/2025"
                const parts = originalTime.split('/');
                dateObj = new Date(parts[2], parts[0] - 1, parts[1]); // Month is 0-indexed
                displayTime = "09.00 AM"; // Placeholder
            } else {
                // Fallback untuk format yang tidak dikenal
                return originalTime;
            }

            if (dateObj) {
                displayDate = dayOfWeek[dateObj.getDay()] + ", " + dateObj.getDate() + " " + monthNames[dateObj.getMonth()];
                return displayDate + ", " + displayTime;
            }
            return originalTime;
        }


        // Event listener saat DOM sudah siap
        document.addEventListener('DOMContentLoaded', function() {
            // Tambahkan event listener ke setiap item notifikasi untuk menampilkan pop-up
            const notificationDropdownContainer = document.getElementById('notificationDropdown');
            if (notificationDropdownContainer) {
                 notificationDropdownContainer.addEventListener('click', function(event) {
                    const notificationItem = event.target.closest('.notification-item');
                    if (notificationItem) {
                        // Ambil data dari elemen notifikasi
                        const title = notificationItem.querySelector('p.text-sm.font-medium.text-gray-900').innerText;
                        // Mengambil waktu dari data-original-time jika ada, jika tidak, dari innerText
                        const originalTime = notificationItem.querySelector('.text-xs.text-gray-500').getAttribute('data-original-time') || notificationItem.querySelector('.text-xs.text-gray-500').innerText;
                        const content = notificationItem.querySelector('p.text-xs.text-gray-600').innerText;

                        // Periksa apakah notifikasi memiliki dot biru (yaitu unread-dot)
                        const unreadDotElement = notificationItem.querySelector('.unread-dot');
                        if (unreadDotElement && !unreadDotElement.classList.contains('hidden')) {
                             markNotificationAsRead(notificationItem); // Tandai sebagai sudah dibaca
                        }
                        
                        const formattedTime = formatTimeForPopup(originalTime);
                        showNotificationPopup(title, formattedTime, content); // Tampilkan pop-up
                    }
                });
            }
           
            // Panggil saat halaman dimuat untuk inisialisasi dot merah
            updateGlobalUnreadNotificationDot();
        });

                // Fungsi untuk modal login
        function openModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.remove('hidden');
        }

        function closeModal() {
            const modal = document.getElementById('loginModal');
            modal.classList.add('hidden');
        }

        // Tutup modal saat mengklik di luar area modal (jika modal terbuka)
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('loginModal');
            // Pastikan modal ada dan tidak tersembunyi
            if (modal && !modal.classList.contains('hidden')) {
                const modalContent = modal.querySelector('.w-[460px]');
                // Jika klik dilakukan di luar konten modal tetapi di dalam area modal overlay
                if (!modalContent.contains(event.target) && event.target === modal) {
                    closeModal();
                }
            }
        });

        // Tutup modal dengan tombol Escape
        document.addEventListener('keydown', function(event) {
            const modal = document.getElementById('loginModal');
            if (event.key === 'Escape' && modal && !modal.classList.contains('hidden')) {
                closeModal();
            }
        });

        // Fungsi untuk toggle password visibility (dibuat global agar bisa diakses dari manapun)
        window.togglePassword = function(button) {
            const input = button.previousElementSibling;
            const eye = button.querySelector('.eye-icon');
            const eyeOff = button.querySelector('.eye-off-icon');

            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            eye.classList.toggle('hidden', !isPassword);
            eyeOff.classList.toggle('hidden', isPassword);
        };

        // Membuka modal secara otomatis jika ada error login atau session 'error'
        document.addEventListener('DOMContentLoaded', function() {
            const loginLinkHeader = document.getElementById('loginLinkHeader');
            if (loginLinkHeader) {
                loginLinkHeader.addEventListener('click', function(event) {
                    event.preventDefault(); // Mencegah navigasi default
                    openModal(); // Membuka modal login
                });
            }

            // Ini akan memastikan modal login terbuka jika ada error validasi dari controller
            @if ($errors->has('email') || $errors->has('password') || session('error'))
                openModal();
            @endif
        });
    </script>
</body>
</html>