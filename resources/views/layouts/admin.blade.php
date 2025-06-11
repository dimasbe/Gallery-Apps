<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Admin Dashboard')</title>
    {{-- Tailwind CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet" />
    {{-- Font Awesome --}}
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css"
    />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --color-primary-red: #AD1500;
            --color-primary-red-darker: #8D1100;
            --color-sidebar-bg: #FFFFFF;
            --color-sidebar-hover: #F0F0F0;
            --color-sidebar-active: var(--color-primary-red); /* Keep active background red */
            --color-text-sidebar: #AD1500;
            --color-text-light: #FFFFFF; /* White text for active red background */
            --color-topbar-bg: #FFFFFF;
            --color-main-bg: #F8F8F8;
        }
        .bg-custom-primary-red { background-color: var(--color-primary-red); }
        .hover\:bg-custom-primary-red-darker:hover { background-color: var(--color-primary-red-darker); }
        .text-custom-primary-red { color: var(--color-primary-red); }
        .border-custom-primary-red { border-color: var(--color-primary-red); }

        .bg-custom-sidebar-bg { background-color: var(--color-sidebar-bg); }
        .hover\:bg-custom-sidebar-hover:hover { background-color: var(--color-sidebar-hover); }
        .bg-custom-sidebar-active { background-color: var(--color-sidebar-active); } /* Active red background */
        .text-custom-sidebar { color: var(--color-text-sidebar); }
        .text-custom-light { color: var(--color-text-light); } /* White text for active state */

        html, body {
            height: 100%;
            margin: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Pastikan body mengambil tinggi penuh viewport */
        }

        /* Header, Sidebar, Main Content */
        header {
            height: 102px; /* Atau tinggi header Anda yang sebenarnya */
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 20;
            background-color: var(--color-topbar-bg);
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            padding: 1rem; /* Padding default */
            padding-right: 1.5rem; /* Tambahkan padding kanan untuk menyeimbangkan layout */
            display: flex; /* Tambahkan ini agar flexbox bekerja */
            align-items: center; /* Vertically align items */
        }

        #sidebar {
            width: 256px; /* Lebar default sidebar */
            position: fixed;
            top: 102px; /* Cocokkan dengan tinggi header */
            bottom: 0;
            left: 0;
            overflow-y: auto; /* Ini yang membuat sidebar bisa discroll */
            background-color: var(--color-sidebar-bg);
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); /* Tambahkan shadow pada sidebar */
            z-index: 15; /* Pastikan sidebar di atas main content tapi di bawah header */
            transition: width 0.3s ease-in-out; /* Pastikan transisi width ada */
        }

        #mainContent {
            margin-left: 256px; /* Offset untuk sidebar */
            margin-top: 102px; /* Offset untuk header */
            overflow-y: auto; /* Ini yang membuat main content bisa discroll */
            height: calc(100vh - 102px); /* Mengisi sisa tinggi viewport di bawah header */
            padding: 1.5rem;
            background-color: var(--color-main-bg);
            transition: margin-left 0.3s ease-in-out; /* Pastikan transisi margin-left ada */
        }

        /* New class for the subtle raised effect when active */
        .sidebar-item-active-raised {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            position: relative;
            z-index: 10;
        }

        /* Ensure active item's text/icon color is white */
        .sidebar-item-active .fas,
        .sidebar-item-active .sidebar-text {
            color: var(--color-text-light) !important; /* Force white text/icon for active state */
        }

        /* Crucially: Prevent active item from changing on hover */
        .sidebar-item-active:hover {
            background-color: var(--color-primary-red) !important; /* Keep it red on hover */
            /* Re-apply the shadow if you want it to persist or slightly change on hover for active state */
            box-shadow: 0 6px 10px -1px rgba(0, 0, 0, 0.12), 0 3px 6px -1px rgba(0, 0, 0, 0.08); /* Slightly stronger shadow on hover */
        }

        .sidebar-scroll::-webkit-scrollbar {
            width: 6px;
        }
        .sidebar-scroll::-webkit-scrollbar-track {
            background: #F0F0F0;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb {
            background: var(--color-primary-red);
            border-radius: 3px;
        }
        .sidebar-scroll::-webkit-scrollbar-thumb:hover {
            background: var(--color-primary-red-darker);
        }

        /* Aturan untuk Sidebar Collapsed */
        #sidebar.sidebar-collapsed { /* Gunakan ID dan class secara bersamaan untuk spesifitas lebih tinggi */
            width: 64px; /* Lebar w-16 di Tailwind */
            overflow: hidden;
        }
        #sidebar.sidebar-collapsed .sidebar-text,
        #sidebar.sidebar-collapsed .sidebar-logo-text {
            display: none;
        }
        #sidebar.sidebar-collapsed .sidebar-item a {
            justify-content: center;
        }
        #sidebar.sidebar-collapsed .sidebar-item a i {
            margin-right: 0 !important;
        }
        #sidebar.sidebar-collapsed .sidebar-panel-text {
            display: none;
        }
        #sidebar.sidebar-collapsed .sidebar-footer {
            display: none;
        }
        #sidebar.sidebar-collapsed .sidebar-item a {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        /* Ini Kunci agar Main Content melebar */
        #mainContent.main-content-shifted {
            margin-left: 64px; /* Offset untuk sidebar saat diminimalkan (sesuai lebar sidebar-collapsed) */
        }

        /* Custom styles for logos to ensure sizing */
        #fullLogo {
            width: 180px; /* Sesuaikan ukuran logo penuh */
            height: auto; /* Biarkan tinggi menyesuaikan agar tidak terdistorsi */
            object-fit: contain; /* Ensures the whole logo is visible within the defined area */
        }

        #minimizedLogo {
            width: 48px; /* Sesuaikan ukuran logo minimal */
            height: 48px;
            object-fit: contain;
        }

        /* --- FIXED FOOTER STYLES --- */
        #footer {
            position: fixed;
            bottom: 0;
            left: 256px; /* Initial offset for sidebar */
            right: 0;
            height: 70px; /* Set a fixed height for the footer */
            z-index: 10;
            background-color: white; /* Ensure background color */
            box-shadow: 0 -2px 4px rgba(0,0,0,0.1); /* Optional: add shadow to the top of the footer */
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0 1.5rem; /* Padding for the content inside the footer */
            transition: left 0.3s ease-in-out; /* Smooth transition for sidebar toggle */
        }

        #footer.footer-shifted {
            left: 64px; /* Shift when sidebar is collapsed */
        }

        /* Ensure body has padding at the bottom to prevent content from being hidden by the fixed footer */
        body {
            padding-bottom: 70px; /* Adjust this value to match your footer's height */
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-custom-main-bg font-sans">
    {{-- Header (Top Bar) --}}
    <header class="bg-custom-topbar-bg shadow-md p-4 flex items-center z-10">
        {{-- Grup Logo dan Tombol Hamburger --}}
        <div class="flex items-center">

            <a href="{{ route('admin.dashboard') }}" id="logoLink">
                {{-- Logo Penuh (awalnya terlihat) --}}
                <img
                    src="{{ asset('images/logo.png') }}"
                    alt="Logo"
                    id="fullLogo"
                />

                {{-- Logo Kecil (awalnya tersembunyi) --}}
                <img
                    src="{{ asset('images/logo2.png') }}"
                    alt="Minimized Logo"
                    id="minimizedLogo"
                    class="hidden"
                />
            </a>

            {{-- Tombol Hamburger dipindahkan ke sini, setelah logo --}}
            <button id="sidebarToggle" class="text-custom-primary-red hover:text-custom-primary-red focus:outline-none focus:text-custom-primary-red ml-4">
                <i class="fas fa-bars text-xl"></i>
            </button>
        </div>

        <!-- {{-- Search Bar --}}
        <div class="flex mx-8">
            <div class="flex w-64 md:w-80">
                <input
                    type="text"
                    placeholder="Cari di sini..."
                    class="flex-grow px-4 py-2 rounded-l-md border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
                />
                <button
                    class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-md hover:bg-[#f5f5f5] focus:outline-none"
                >
                    <i class="fas fa-search text-custom-primary-red"></i>
                </button>
            </div>
        </div> -->

        {{-- Dropdown Profil --}}
        <div class="flex items-center space-x-4 ml-auto">
            <div class="relative">
                <button id="profileDropdownBtn" class="flex items-center space-x-2 focus:outline-none">
                    <div
                        class="w-10 h-10 rounded-full bg-custom-primary-red flex items-center justify-center text-white font-bold text-lg overflow-hidden">
                        {{-- Menampilkan gambar profil jika ada, atau inisial jika tidak ada --}}
                        @if(Auth::check() && Auth::user()->profile_picture)
                            <img src="{{ asset('storage/' . Auth::user()->profile_picture) }}" alt="Avatar" class="w-full h-full object-cover">
                        @else
                            @php
                                $initials = 'U'; // Inisial default
                                if (Auth::check()) {
                                    if (Auth::user()->name) {
                                        $words = explode(' ', Auth::user()->name);
                                        $initials = '';
                                        foreach ($words as $word) {
                                            $initials .= strtoupper(substr($word, 0, 1));
                                        }
                                        $initials = substr($initials, 0, 2); // Ambil maksimal 2 inisial
                                    } elseif (Auth::user()->username) {
                                        $initials = strtoupper(substr(Auth::user()->username, 0, 1));
                                    }
                                }
                            @endphp
                            {{ $initials }}
                        @endif
                    </div>
                    <div class="flex flex-col text-sm text-left">
                        <span class="font-semibold text-custom-primary-red">Admin Gallery Apps</span> <span class="text-gray-500 text-xs">
                            @if(Auth::check())
                                {{ Auth::user()->name }}
                            @else
                                @username_admin
                            @endif
                        </span>
                    </div>
                </button>

                <div
                    id="profileDropdownMenu"
                    class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-20 hidden"
                >
                    <form method="POST" action="{{ route('admin.logout') }}">
                        @csrf
                        <button
                            type="submit"
                            class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 hover:text-red-700"
                        >
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </header>

    {{-- Main Content Area (Sidebar + Content) --}}
    <div class="flex flex-1">
        <aside
            id="sidebar"
            class="w-64 bg-custom-sidebar-bg text-custom-sidebar flex flex-col p-4 shadow-lg overflow-y-auto sidebar-scroll"
        >
            <nav class="flex-grow">
                <ul>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.dashboard') }}"
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.dashboard') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}"
                        >
                            <i class="fas fa-home mr-3 text-lg"></i> <span class="sidebar-text">Beranda</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.verifikasi') }}"
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.verifikasi') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}"
                        >
                            <i class="fas fa-check-circle mr-3 text-lg"></i> <span class="sidebar-text">Verifikasi</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.riwayat.index') }}"
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.riwayat.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}"
                        >
                            <i class="fas fa-history mr-3 text-lg"></i> <span class="sidebar-text">Riwayat</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.kategori.index') }}"
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.kategori.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}"
                        >
                            <i class="fas fa-th-list mr-3 text-lg"></i> <span class="sidebar-text">Kategori</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.berita.index') }}"
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.berita.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}"
                        >
                            <i class="fas fa-newspaper mr-3 text-lg"></i> <span class="sidebar-text">Berita</span>
                        </a>
                    </li>
                  
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.arsip.index') }}"
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.arsip.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}"
                        >
                            <i class="fas fa-archive mr-3 text-lg"></i> <span class="sidebar-text">Arsip</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

        {{-- MAIN CONTENT --}}
        <main id="mainContent" class="flex-grow p-6 overflow-y-auto bg-custom-main-bg">
            @yield('content')

        {{-- FOOTER --}}
        <div class="flex justify-between items-center text-gray-500 text-sm border-t bg-white mt-6 px-8 py-4"
            style="margin-left: -1.5rem; margin-right: -1.5rem; width: calc(100% + 3rem);">
            <p>2025 Hummatech All Rights Reserved</p>
            <p>Copyright By GalleryApp</p>
        </div>
        </main>
    </div>

        {{-- JavaScript --}}
        <script>
        document.addEventListener('DOMContentLoaded', function () {
            const profileDropdownBtn = document.getElementById('profileDropdownBtn');
            const profileDropdownMenu = document.getElementById('profileDropdownMenu');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const fullLogo = document.getElementById('fullLogo');
            const minimizedLogo = document.getElementById('minimizedLogo');
            const footer = document.getElementById('footer'); // ✅ tambahkan ini

            // --- Profile Dropdown Toggle ---
            if (profileDropdownBtn && profileDropdownMenu) {
                profileDropdownBtn.addEventListener('click', function (event) {
                    event.stopPropagation();
                    profileDropdownMenu.classList.toggle('hidden');
                });

                document.addEventListener('click', function (event) {
                    if (!profileDropdownMenu.contains(event.target) && !profileDropdownBtn.contains(event.target)) {
                        profileDropdownMenu.classList.add('hidden');
                    }
                });
            }

            // --- Sidebar Toggle ---
            if (sidebarToggle && sidebar && mainContent && fullLogo && minimizedLogo) {
                sidebarToggle.addEventListener('click', function () {
                    sidebar.classList.toggle('sidebar-collapsed');
                    mainContent.classList.toggle('main-content-shifted');
                    
                    if (footer) {
                        footer.classList.toggle('footer-shifted');
                    }

                    if (sidebar.classList.contains('sidebar-collapsed')) {
                        fullLogo.classList.add('hidden');
                        minimizedLogo.classList.remove('hidden');
                    } else {
                        fullLogo.classList.remove('hidden');
                        minimizedLogo.classList.add('hidden');
                    }
                });
            }
        });
    </script>
@stack('scripts')
</body>
</html>