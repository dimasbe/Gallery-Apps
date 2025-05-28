@extends('layouts.admin') {{-- Ini mengextends layout utama admin Anda --}}

@section('title', 'Admin Dashboard') {{-- Judul halaman untuk bagian <title> di HTML --}}

@section('content') {{-- Bagian ini akan di-inject ke dalam @yield('content') di layout admin --}}

<style>
    /* Custom styles for the circular icons */
    .icon-circle {
        width: 60px; /* Sesuaikan ukuran sesuai kebutuhan */
        height: 60px; /* Sesuaikan ukuran sesuai kebutuhan */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white; /* Warna ikon */
        font-size: 2rem; /* Ukuran ikon */
        flex-shrink: 0; /* Mencegah penyusutan dalam flex container */
    }
    .icon-red {
        background-color: #AD1500; /* Merah Utama */
    }
    .icon-purple {
        background-color: #8B6DBF; /* Warna ungu dari Figma Anda (kira-kira) */
    }
    .icon-green {
        background-color: #4CAF50; /* Contoh hijau untuk ikon lain */
    }
    .icon-blue {
        background-color: #2196F3; /* Contoh biru untuk ikon lain */
    }

    /* Custom styles for chart placeholders */
    .chart-placeholder {
        height: 250px; /* Tinggi disesuaikan untuk grafik batang */
        background-color: #f5f5f5; /* Latar belakang abu-abu muda */
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-style: italic;
        margin-top: 1rem; /* Spasi di bawah legenda */
        /* Sembunyikan teks placeholder ketika grafik ada */
        text-indent: -9999px; /* Sembunyikan teks */
        overflow: hidden; /* Pastikan teks benar-benar tersembunyi */
    }
    .pie-chart-placeholder {
        height: 200px; /* Tinggi untuk grafik donat */
        width: 200px; /* Lebar untuk grafik donat */
        background-color: #f5f5f5;
        border-radius: 50%; /* Buat melingkar */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-style: italic;
        margin: 0 auto; /* Tengah grafik donat */
        /* Sembunyikan teks placeholder ketika grafik ada */
        text-indent: -9999px; /* Sembunyikan teks */
        overflow: hidden; /* Pastikan teks benar-benar tersembunyi */
    }

    /* Custom styles for app list items */
    .app-list-item {
        display: flex;
        align-items: center;
        gap: 1rem; /* Spasi antara avatar dan teks */
        margin-bottom: 0.75rem; /* Spasi antar item daftar */
    }
    .app-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px; /* Sudut sedikit membulat untuk ikon aplikasi */
        object-fit: cover;
        background-color: #eee; /* Latar belakang placeholder */
    }
    .publisher-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #eee;
    }
</style>

<div class="p-6"> {{-- Padding utama untuk area konten --}}

    {{-- KARTU PUTIH UNTUK HEADER & BREADCRUMB --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6"> {{-- Card putih baru untuk header, dengan bayangan dan sudut membulat --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Beranda</h1> {{-- Judul utama halaman --}}
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Dashboard</li> {{-- Breadcrumb untuk halaman dashboard --}}
                </ol>
            </nav>
        </div>
    </div>


    {{-- BAGIAN ATAS: Judul dan Kartu Statistik Besar --}}
    <h1 class="text-2xl font-semibold text-gray-800 mb-6"></h1> {{-- Judul ini sekarang bisa dikosongkan atau dihapus karena sudah ada di kartu header --}}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Kartu: Jumlah Pengguna --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
            <div class="icon-circle icon-red">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Jumlah Pengguna</p>
                <h2 class="text-3xl font-bold text-gray-800">36.964</h2>
            </div>
        </div>

        {{-- Kartu: Jumlah Diunggah --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
            <div class="icon-circle icon-red">
                <i class="fas fa-upload"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Aplikasi Diunggah</p>
                <h2 class="text-3xl font-bold text-gray-800">790</h2>
            </div>
        </div>
    </div>

    {{-- BAGIAN TENGAH: Rekap Bulanan Chart (Kiri) & Aplikasi Sering Dikunjungi (Kanan) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Kolom Kiri: Rekap Bulanan (Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Rekap Bulanan</h2>
                <div class="relative inline-block text-gray-700">
                    <select class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red">
                        <option>Maret 2025</option>
                        <option>Februari 2025</option>
                        <option>Januari 2025</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <p class="text-gray-500 text-sm">Mar 01 - Mar 31</p>
            {{-- Canvas untuk grafik batang --}}
            <div class="chart-placeholder">
                <canvas id="monthlyRecapChart"></canvas>
            </div>
            {{-- Kategori/filter di bawah grafik --}}
            <div class="mt-4 flex flex-wrap gap-2 text-sm justify-center">
                <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">Belanja</span>
                <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">Permainan</span>
                <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">Kesehatan</span>
                <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">Olahraga</span>
                <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">Fash</span> {{-- Singkatan dari "Fashion" --}}
            </div>
        </div>

        {{-- Kolom Kanan: Aplikasi Sering Dikunjungi --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aplikasi Sering Dikunjungi</h2>
            <div class="relative inline-block text-gray-700 mb-4">
                <select class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red">
                    <option>Januari 2025</option>
                    <option>Desember 2024</option>
                    <option>November 2024</option>
                </select>
                <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                    <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                </div>
            </div>

            <ul class="space-y-4">
                @php
                    $apps = [
                        ['name' => 'ChatGPT', 'developer' => 'OpenAI', 'rating' => '4.7'],
                        ['name' => 'Cici - Asisten AI Anda', 'developer' => 'SPRING ISG PTE. LTD.', 'rating' => '4.4'],
                        ['name' => 'TikTok Lite', 'developer' => 'TikTok Pte. Ltd.', 'rating' => '4.6'],
                        ['name' => 'Quizizz', 'developer' => 'Quizizz Inc.', 'rating' => '4.8'],
                        ['name' => 'Ruangguru', 'developer' => 'ruangguru.com', 'rating' => '4.5'],
                        ['name' => 'Google Kelas', 'developer' => 'Google LLC', 'rating' => '3.5'],
                    ];
                @endphp
                @foreach ($apps as $index => $app)
                <li class="flex items-center space-x-3">
                    <span class="text-lg font-bold text-gray-500">{{ $index + 1 }}</span>
                    {{-- Menggunakan asset() untuk gambar lokal --}}
                    <img src="{{ asset('images/icon_ml.png') }}" alt="{{ $app['name'] }} avatar" class="app-avatar">
                    <div class="flex-grow">
                        <p class="text-gray-800 font-semibold">{{ $app['name'] }}</p>
                        <p class="text-gray-500 text-sm">{{ $app['developer'] }}</p>
                    </div>
                    <div class="flex items-center text-gray-500 text-sm">
                        <i class="fas fa-star text-yellow-400 mr-1"></i>
                        <span>{{ $app['rating'] }}</span>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>

    {{-- BAGIAN BAWAH: Publisher Terpopuler (Kiri), Berita Sering Dilihat (Tengah), Berita (Kanan) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Kolom Kiri: Publisher Terpopuler --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Publisher Terpopuler</h2>
            <ul class="space-y-3">
                @php
                    $publishers = [
                        ['name' => 'GalleryAi', 'unduhan' => '1.2M'],
                        ['name' => 'GalleryAi', 'unduhan' => '900k'],
                        ['name' => 'Figma PTE. LTD.', 'unduhan' => '850k'],
                        ['name' => 'OpenAI', 'unduhan' => '700k'],
                        ['name' => 'GalleryAi', 'unduhan' => '650k'],
                        ['name' => 'GalleryAi', 'unduhan' => '600k'],
                        ['name' => 'GalleryAi', 'unduhan' => '550k'],
                        ['name' => 'GalleryAi', 'unduhan' => '500k'],
                        ['name' => 'GalleryAi', 'unduhan' => '450k'],
                        ['name' => 'GalleryAi', 'unduhan' => '400k'],
                    ];
                @endphp
                @foreach($publishers as $publisher)
                <li class="flex items-center space-x-3">
                    {{-- Menggunakan asset() untuk gambar lokal --}}
                    <img src="{{ asset('images/icon_ml.png') }}" alt="{{ $publisher['name'] }} avatar" class="publisher-avatar">
                    <div class="flex-grow">
                        <p class="text-gray-800 font-semibold">{{ $publisher['name'] }}</p>
                    </div>
                    <p class="text-gray-500 text-sm">{{ $publisher['unduhan'] }} Unduhan</p>
                </li>
                @endforeach
            </ul>
        </div>

        {{-- Kolom Tengah: Berita Sering Dilihat (Grafik Donat) --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Berita Sering Dilihat</h2>
                <div class="relative inline-block text-gray-700">
                    <select class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red">
                        <option>Maret 2025</option>
                        <option>Februari 2025</option>
                        <option>Januari 2025</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            <p class="text-gray-800 text-xl font-bold mb-4">73.279.932B</p>
            {{-- Canvas untuk grafik donat --}}
            <div class="flex flex-col items-center justify-center">
                <div class="pie-chart-placeholder">
                    <canvas id="newsPieChart"></canvas>
                </div>
                <div class="mt-4 text-sm w-full">
                    <div class="flex items-center mb-1">
                        <span class="block w-3 h-3 rounded-full bg-blue-500 mr-2"></span>
                        <span class="text-gray-700">Label 1</span>: <span class="ml-auto font-semibold">36,638,491M</span>
                    </div>
                    <div class="flex items-center mb-1">
                        <span class="block w-3 h-3 rounded-full bg-red-500 mr-2"></span>
                        <span class="text-gray-700">Label 2</span>: <span class="ml-auto font-semibold">1,411,881M</span>
                    </div>
                    <div class="flex items-center mb-1">
                        <span class="block w-3 h-3 rounded-full bg-green-500 mr-2"></span>
                        <span class="text-gray-700">Label 3</span>: <span class="ml-auto font-semibold">4,070,967M</span>
                    </div>
                    <div class="flex items-center mb-1">
                        <span class="block w-3 h-3 rounded-full bg-yellow-500 mr-2"></span>
                        <span class="text-gray-700">Label 4</span>: <span class="ml-auto font-semibold">12,272,831M</span>
                    </div>
                    <div class="flex items-center mb-1">
                        <span class="block w-3 h-3 rounded-full bg-purple-500 mr-2"></span>
                        <span class="text-gray-700">Label 5</span>: <span class="ml-auto font-semibold">1,211,831M</span>
                    </div>
                </div>
            </div>
        </div>

        {{-- Kolom Kanan: Berita --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Berita</h2>
                <div class="relative inline-block text-gray-700">
                    <select class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red">
                        <option>Maret 2025</option>
                        <option>Februari 2025</option>
                        <option>Januari 2025</option>
                    </select>
                    <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-2 text-gray-700">
                        <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M9.293 12.95l.707.707L15.657 8l-1.414-1.414L10 10.828 5.757 6.586 4.343 8z"/></svg>
                    </div>
                </div>
            </div>
            {{-- Konten untuk bagian "Berita" akan ditampilkan di sini, contohnya daftar berita terbaru --}}
            <p class="text-gray-500">Konten berita terbaru akan ditampilkan di sini.</p>
            {{-- Anda bisa menambahkan daftar item berita, mungkin dengan judul, tanggal, dll. --}}
            <ul class="mt-4 space-y-3">
                <li class="text-gray-800 font-semibold">Judul Berita 1</li>
                <li class="text-gray-800 font-semibold">Judul Berita 2</li>
                <li class="text-gray-800 font-semibold">Judul Berita 3</li>
                <li class="text-gray-800 font-semibold">Judul Berita 4</li>
                <li class="text-gray-800 font-semibold">Judul Berita 5</li>
            </ul>
        </div>
    </div>
</div>

{{-- CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Grafik Batang Rekap Bulanan
        var monthlyRecapCtx = document.getElementById('monthlyRecapChart').getContext('2d');
        var monthlyRecapChart = new Chart(monthlyRecapCtx, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'],
                datasets: [{
                    label: 'Jumlah Interaksi',
                    data: [1200, 1900, 1500, 2000, 2200, 1800, 2500],
                    backgroundColor: '#AD1500', // Merah Utama
                    borderColor: '#AD1500',
                    borderWidth: 1,
                    borderRadius: 5, // Sudut membulat untuk batang
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false // Sembunyikan garis grid sumbu y
                        }
                    },
                    x: {
                        grid: {
                            display: false // Sembunyikan garis grid sumbu x
                        }
                    }
                }
            }
        });

        // Grafik Donat Berita
        var newsPieCtx = document.getElementById('newsPieChart').getContext('2d');
        var newsPieChart = new Chart(newsPieCtx, {
            type: 'doughnut', // Diubah menjadi doughnut untuk efek cincin
            data: {
                labels: ['Label 1', 'Label 2', 'Label 3', 'Label 4', 'Label 5'],
                datasets: [{
                    data: [36638491, 1411881, 4070967, 12272831, 1211831],
                    backgroundColor: [
                        '#3B82F6', // Blue-500 (Tailwind CSS)
                        '#EF4444', // Red-500 (Tailwind CSS)
                        '#22C55E', // Green-500 (Tailwind CSS)
                        '#F59E0B', // Yellow-500 (Tailwind CSS)
                        '#8B6DBF'  // Ungu dari gaya kustom Anda
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Kita akan membuat legenda kustom di bawah grafik
                    }
                }
            }
        });

        // Sembunyikan teks placeholder untuk grafik setelah dirender
        document.getElementById('monthlyRecapChart').parentNode.style.textIndent = '0';
        document.getElementById('newsPieChart').parentNode.style.textIndent = '0';
    });
</script>
@endsection