@extends('layouts.admin') {{-- This extends your main admin layout --}}

@section('title', 'Admin Dashboard') {{-- Page title for the <title> tag in HTML --}}

@section('content') {{-- This section will be injected into @yield('content') in the admin layout --}}

<style>
    /* Custom styles for the circular icons */
    .icon-circle {
        width: 60px; /* Adjust size as needed */
        height: 60px; /* Adjust size as needed */
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white; /* Icon color */
        font-size: 2rem; /* Icon size */
        flex-shrink: 0; /* Prevent shrinking in flex container */
    }
    .icon-red {
        background-color: #AD1500; /* Primary Red */
    }
    .icon-purple {
        background-color: #8B6DBF; /* Purple color from your Figma (approximate) */
    }
    .icon-green {
        background-color: #4CAF50; /* Example green for other icons */
    }
    .icon-blue {
        background-color: #2196F3; /* Example blue for other icons */
    }

    /* Custom styles for chart placeholders */
    .chart-placeholder {
        height: 250px; /* Adjusted height for bar chart */
        background-color: #f5f5f5; /* Light gray background */
        border-radius: 0.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-style: italic;
        margin-top: 1rem; /* Space below legend */
        /* Hide placeholder text when chart is present */
        text-indent: -9999px; /* Hide text */
        overflow: hidden; /* Ensure text is completely hidden */
    }
    .pie-chart-placeholder {
        height: 200px; /* Height for doughnut chart */
        width: 200px; /* Width for doughnut chart */
        background-color: #f5f5f5;
        border-radius: 50%; /* Make circular */
        display: flex;
        align-items: center;
        justify-content: center;
        color: #999;
        font-style: italic;
        margin: 0 auto; /* Center doughnut chart */
        /* Hide placeholder text when chart is present */
        text-indent: -9999px; /* Hide text */
        overflow: hidden; /* Ensure text is completely hidden */
    }

    /* Custom styles for app list items */
    .app-list-item {
        display: flex;
        align-items: center;
        gap: 1rem; /* Space between avatar and text */
        margin-bottom: 0.75rem; /* Space between list items */
    }
    .app-avatar {
        width: 40px;
        height: 40px;
        border-radius: 8px; /* Slightly rounded corners for app icons */
        object-fit: cover;
        background-color: #eee; /* Placeholder background */
    }
    .publisher-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #eee;
    }
</style>

<div class="p-6"> {{-- Main padding for content area --}}

    {{-- WHITE CARD FOR HEADER & BREADCRUMB --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6"> {{-- New white card for header, with shadow and rounded corners --}}
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Beranda</h1> {{-- Main page title --}}
            <nav aria-label="breadcrumb">
                <!-- <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Beranda</li> {{-- Breadcrumb for dashboard page --}}
                </ol> -->
            </nav>
        </div>
    </div>


    {{-- TOP SECTION: Title and Large Stats Cards --}}
    <h1 class="text-2xl font-semibold text-gray-800 mb-6"></h1> {{-- This title can now be empty or removed as it's in the header card --}}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Card: Number of Users --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
            <div class="icon-circle icon-red">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Jumlah Pengguna</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</h2> {{-- DYNAMIC DATA --}}
            </div>
        </div>

        {{-- Card: Uploaded Count --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
            <div class="icon-circle icon-red">
                <i class="fas fa-upload"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Aplikasi Diunggah</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalAplikasiDiunggah }}</h2> {{-- DYNAMIC DATA --}}
            </div>
        </div>
    </div>

    {{-- MIDDLE SECTION: Monthly Recap Chart (Left) & Most Visited Apps (Right) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Left Column: Monthly Recap (Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Rekap Bulanan</h2>
                <div class="relative inline-block text-gray-700">
                    {{-- Using input type="month" --}}
                    <input type="month"
                           id="monthlyRecapFilter" {{-- Adding ID for potential JavaScript --}}
                           class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red"
                           value="{{ now()->format('Y-m') }}"> {{-- Default to current month --}}
                </div>
            </div>
            <p class="text-gray-500 text-sm">Data untuk bulan yang dipilih.</p>
            {{-- Canvas for bar chart --}}
            <div class="chart-placeholder">
                <canvas id="monthlyRecapChart"></canvas>
            </div>
            {{-- Categories/filters below the chart (remain static for now if no dynamic data) --}}
            <div class="mt-4 flex flex-wrap gap-2 text-sm justify-center">
                @forelse ($kategoriAplikasi as $kategori)
                    <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">{{ $kategori->nama_kategori }}</span>
                @empty
                    <span class="px-3 py-1 bg-gray-200 rounded-full text-gray-700">Tidak ada kategori</span>
                @endforelse
            </div>
        </div>

        {{-- Right Column: Most Visited Apps --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aplikasi Sering Dikunjungi</h2>
            <div class="relative inline-block text-gray-700 mb-4">
                {{-- Using input type="month" --}}
                <input type="month"
                       id="mostVisitedAppsFilter" {{-- Adding ID --}}
                       class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red"
                       value="{{ now()->format('Y-m') }}"> {{-- Default to current month --}}
            </div>

            <ul class="space-y-4">
                {{-- DYNAMIC DATA: Loop through mostVisitedApps --}}
                @forelse ($mostVisitedApps as $index => $app)
                <li class="flex items-center space-x-3">
                    <span class="text-lg font-bold text-gray-500">{{ $index + 1 }}</span>
                    {{-- Using app logo from database --}}
                    <img src="{{ $app->logo ? asset('storage/' . $app->logo) : 'https://placehold.co/40x40/cccccc/333333?text=App+Icon' }}" alt="{{ $app->nama_aplikasi }} avatar" class="app-avatar">
                    <div class="flex-grow">
                        <p class="text-gray-800 font-semibold">{{ $app->nama_aplikasi }}</p>
                        <p class="text-gray-500 text-sm">{{ $app->nama_pemilik }}</p> {{-- Displaying publisher name --}}
                    </div>
                    {{-- Rating removed as requested --}}
                </li>
                @empty
                <li class="text-gray-500 text-center">Tidak ada aplikasi sering dikunjungi.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- BOTTOM SECTION: Popular Publishers (Left), Most Viewed News (Middle), Latest News (Right) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Left Column: Popular Publishers --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Publisher Terpopuler</h2>
            <ul class="space-y-3">
                {{-- DYNAMIC DATA: Loop through popularPublishers --}}
                @forelse($popularPublishers as $publisher)
                <li class="flex items-center space-x-3">
                    {{-- Using publisher logo from retrieved data (publisher_logo) --}}
                    <img src="{{ $publisher->publisher_logo ? asset('storage/' . $publisher->publisher_logo) : 'https://placehold.co/32x32/cccccc/333333?text=P' }}" alt="{{ $publisher->nama_pemilik }} avatar" class="publisher-avatar">
                    <div class="flex-grow">
                        <p class="text-gray-800 font-semibold">{{ $publisher->nama_pemilik }}</p>
                    </div>
                    <p class="text-gray-500 text-sm">{{ number_format($publisher->total_unduhan_apps) }} Kunjungan</p> {{-- Using total_unduhan_apps --}}
                </li>
                @empty
                <li class="text-gray-500 text-center">Tidak ada publisher terpopuler.</li>
                @endforelse
            </ul>
        </div>

        {{-- Middle Column: Most Viewed News (Doughnut Chart) --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            {{-- PERUBAHAN DI SINI: Judul dan Filter terpisah --}}
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Berita Sering Dilihat</h2>
            <div class="relative inline-block text-gray-700 w-full mb-4"> {{-- w-full agar filter mengambil seluruh lebar --}}
                <input type="month"
                       id="mostViewedNewsFilter" {{-- Adding ID --}}
                       class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red"
                       value="{{ now()->format('Y-m') }}"> {{-- Default to current month --}}
            </div>
            <p class="text-gray-800 text-xl font-bold mb-4">{{ number_format(array_sum($newsChartData)) }} Kunjungan Total</p>
            <div class="flex flex-col items-center justify-center">
                <div class="pie-chart-placeholder">
                    <canvas id="newsPieChart"></canvas>
                </div>
                {{-- Dynamic legend for doughnut chart --}}
                <div class="mt-4 text-sm w-full">
                    @forelse($mostViewedNewsForChart as $index => $news)
                        <div class="flex items-center mb-1">
                            @php
                                $colors = ['#3B82F6', '#EF4444', '#22C55E', '#F59E0B', '#8B6DBF'];
                                $color = $colors[$index % count($colors)];
                            @endphp
                            <span class="block w-3 h-3 rounded-full mr-2" style="background-color: {{ $color }};"></span>
                            {{-- Ensuring news title is displayed --}}
                            <span class="text-gray-700">{{ $news->judul_berita }}</span>: <span class="ml-auto font-semibold">{{ number_format($news->jumlah_kunjungan) }}</span>
                        </div>
                    @empty
                        <div class="text-gray-500 text-center">Tidak ada data berita untuk grafik.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Right Column: Latest News --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            {{-- Judul dan Filter terpisah --}}
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Berita Terbaru</h2>
            <div class="relative inline-block text-gray-700 w-full mb-4"> {{-- w-full agar filter mengambil seluruh lebar --}}
                <input type="month"
                       id="latestNewsFilter"
                       class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red"
                       value="{{ now()->format('Y-m') }}">
            </div>
            {{-- Konten untuk bagian "Berita" akan ditampilkan di sini, contohnya daftar berita terbaru --}}
            <ul class="mt-4 space-y-3">
                {{-- DYNAMIC DATA: Loop through $beritas --}}
                @forelse($beritas as $beritaItem) {{-- Changed variable name to avoid conflict with $beritas (plural) --}}
                    <li>
                        <a href="{{ route('berita.show', $beritaItem->id) }}" class="text-gray-800 font-semibold hover:text-[#AD1500]">{{ $beritaItem->judul_berita }}</a>
                        <p class="text-gray-500 text-xs">{{ \Carbon\Carbon::parse($beritaItem->tanggal_dibuat)->locale('id')->isoFormat('D MMMMllll') }}</p>
                    </li>
                @empty
                    <li class="text-gray-500">Tidak ada berita terbaru untuk ditampilkan.</li>
                @endforelse
            </ul>
        </div>
    </div>
</div>

{{-- CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Data from Laravel for Chart.js (encoded from PHP)
        const newsChartLabels = @json($newsChartLabels);
        const newsChartData = @json($newsChartData);

        // Monthly Recap Bar Chart
        var monthlyRecapCtx = document.getElementById('monthlyRecapChart').getContext('2d');
        var monthlyRecapChart = new Chart(monthlyRecapCtx, {
            type: 'bar',
            data: {
                labels: ['Sen', 'Sel', 'Rab', 'Kam', 'Jum', 'Sab', 'Min'], // This is still static, can be made dynamic if data available
                datasets: [{
                    label: 'Jumlah Interaksi',
                    data: [1200, 1900, 1500, 2000, 2200, 1800, 2500], // This is still static, can be made dynamic if data available
                    backgroundColor: '#AD1500', // Primary Red
                    borderColor: '#AD1500',
                    borderWidth: 1,
                    borderRadius: 5, // Rounded corners for bars
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // Hide legend
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            display: false // Hide y-axis grid lines
                        }
                    },
                    x: {
                        grid: {
                            display: false // Hide x-axis grid lines
                        }
                    }
                }
            }
        });

        // News Doughnut Chart
        var newsPieCtx = document.getElementById('newsPieChart').getContext('2d');
        var newsPieChart = new Chart(newsPieCtx, {
            type: 'doughnut', // Changed to doughnut for ring effect
            data: {
                labels: newsChartLabels, // DYNAMIC DATA
                datasets: [{
                    data: newsChartData, // DYNAMIC DATA
                    backgroundColor: [
                        '#3B82F6', // Blue-500 (Tailwind CSS)
                        '#EF4444', // Red-500 (Tailwind CSS)
                        '#22C55E', // Green-500 (Tailwind CSS)
                        '#F59E0B', // Yellow-500 (Tailwind CSS)
                        '#8B6DBF'  // Purple from your custom style
                    ],
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false // We will create a custom legend below the chart
                    }
                }
            }
        });

        // Hide chart placeholder text after rendering
        // Ensure canvas element exists before trying to access parentNode
        const monthlyRecapChartParent = document.getElementById('monthlyRecapChart')?.parentNode;
        if (monthlyRecapChartParent) {
            monthlyRecapChartParent.style.textIndent = '0';
            monthlyRecapChartParent.style.overflow = 'visible'; // Visible to see the chart
            monthlyRecapChartParent.style.backgroundColor = 'transparent'; // Remove placeholder background
        }

        const newsPieChartParent = document.getElementById('newsPieChart')?.parentNode;
        if (newsPieChartParent) {
            newsPieChartParent.style.textIndent = '0';
            newsPieChartParent.style.overflow = 'visible'; // Visible to see the chart
            newsPieChartParent.style.backgroundColor = 'transparent'; // Remove placeholder background
            newsPieChartParent.style.borderRadius = '0'; // Remove circular background if not needed for chart itself
        }
    });
</script>
@endsection
