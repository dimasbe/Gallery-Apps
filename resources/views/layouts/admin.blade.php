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

        /* New class for the subtle raised effect when active */
        .sidebar-item-active-raised {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            /* You can adjust these values for more or less prominence */
            position: relative; /* Needed for z-index if you want it to truly "pop" above siblings */
            z-index: 10; /* Make it slightly above other items */
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

        .sidebar-transition {
            transition: width 0.3s ease-in-out;
        }
        .main-content-transition {
            transition: margin-left 0.3s ease-in-out;
        }

        .sidebar-collapsed {
            width: 64px; /* w-16 */
            overflow: hidden;
        }
        .sidebar-collapsed .sidebar-text,
        .sidebar-collapsed .sidebar-logo-text {
            display: none;
        }
        .sidebar-collapsed .sidebar-item a {
            justify-content: center;
        }
        .sidebar-collapsed .sidebar-item a i {
            margin-right: 0 !important;
        }
        .sidebar-collapsed .sidebar-panel-text {
            display: none;
        }
        .sidebar-collapsed .sidebar-footer {
            display: none;
        }
        .sidebar-collapsed .sidebar-item a {
            padding-left: 0.5rem;
            padding-right: 0.5rem;
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .main-content-shifted {
            margin-left: 64px;
        }
    </style>
</head>
<body class="flex flex-col min-h-screen bg-custom-main-bg font-sans">
    {{-- Header (Top Bar) --}}
    <header class="bg-custom-topbar-bg shadow-md p-4 flex items-center justify-between z-10">
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="text-custom-primary-red hover:text-custom-primary-red focus:outline-none focus:text-custom-primary-red">
                <i class="fas fa-bars text-xl"></i>
            </button>
            <a href="{{ route('admin.dashboard') }}">
                <img src="{{ asset('images/logo.png') }}" alt="Logo" style="width:150px; height:70px; object-fit: cover; border-radius: 9999px;" />
            </a>
        </div>

        <div class="flex-grow flex justify-start ml-16">
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
        </div>
        <nav class="flex items-center space-x-4">
            {{-- Tampilan Admin Gallery Apps --}}
            <span class="text-gray-800 font-semibold text-lg">Admin Gallery Apps</span>
            {{-- Form Logout --}}
            <form method="POST" action="{{ route('admin.logout') }}">
                @csrf
                <button type="submit" class="bg-custom-primary-red hover:bg-custom-primary-red-darker text-white font-semibold py-2 px-4 rounded-full shadow-md transition duration-300 ease-in-out">
                    Logout
                </button>
            </form>
        </nav>
    </header>

    {{-- Main Content Area (Sidebar + Content) --}}
    <div class="flex flex-1">
        <aside
            id="sidebar"
            class="w-64 bg-custom-sidebar-bg text-custom-sidebar flex flex-col p-4 shadow-lg overflow-y-auto sidebar-scroll sidebar-transition"
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
                    <li class="mb-2 sidebar-item"> {{-- Tambahkan class sidebar-item di sini --}}
                        <a
                            href="{{ route('admin.verifikasi') }}" {{-- <-- PERBAIKAN DI SINI --}}
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.verifikasi') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}" {{-- <-- Tambahkan logika active --}}
                        >
                            <i class="fas fa-check-circle mr-3 text-lg"></i> <span class="sidebar-text">Verifikasi</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.riwayat.index') }}" {{-- <-- PERBAIKAN DI SINI --}}
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.riwayat.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}" {{-- <-- Tambahkan logika active dengan wildcard --}}
                        >
                            <i class="fas fa-history mr-3 text-lg"></i> <span class="sidebar-text">Riwayat</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.berita.index') }}" {{-- <-- PERBAIKAN DI SINI --}}
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.berita.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}" {{-- <-- Tambahkan logika active dengan wildcard --}}
                        >
                            <i class="fas fa-newspaper mr-3 text-lg"></i> <span class="sidebar-text">Berita</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.kategori.index') }}" {{-- <-- PERBAIKAN DI SINI --}}
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.kategori.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}" {{-- <-- Tambahkan logika active dengan wildcard --}}
                        >
                            <i class="fas fa-th-list mr-3 text-lg"></i> <span class="sidebar-text">Kategori</span>
                        </a>
                    </li>
                    <li class="mb-2 sidebar-item">
                        <a
                            href="{{ route('admin.arsip.index') }}" {{-- <-- PERBAIKAN DI SINI --}}
                            class="flex items-center p-3 rounded-lg text-custom-sidebar hover:bg-custom-sidebar-hover transition duration-200
                            {{ request()->routeIs('admin.arsip.*') ? 'bg-custom-sidebar-active text-custom-light sidebar-item-active sidebar-item-active-raised' : '' }}" {{-- <-- Tambahkan logika active dengan wildcard --}}
                        >
                            <i class="fas fa-archive mr-3 text-lg"></i> <span class="sidebar-text">Arsip</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>

         {{-- MAIN CONTENT --}}
        <main id="mainContent" class="flex-grow p-6 overflow-y-auto bg-custom-main-bg main-content-transition">
                @yield('content')

                {{-- FOOTER --}}
                <div class="flex justify-between items-center text-gray-500 text-sm pt-8 border-t border-gray-200 mt-8">
                    <p>2025 Hummatech All Rights Reserved</p>
                    <p>Copyright By GalleryApp</p>
                </div>
        </main>
    </div>

    {{-- Script JavaScript Anda di sini --}}
    {{-- <script src="{{ asset('js/app.js') }}"></script> --}}
    @stack('scripts') 
</body>
</html>