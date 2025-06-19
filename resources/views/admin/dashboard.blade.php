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

    /* Chart Container improvements */
    .chart-wrapper {
        position: relative; /* For absolute positioning of navigation arrows */
        margin-top: 1rem;
        padding-top: 10px; /* Space above chart for potential legend or title */
        padding-bottom: 20px; /* Space for scrollbar */
        background-color: #f5f5f5; /* Light gray background */
        border-radius: 0.5rem;
        min-height: 280px; /* Ensure minimum height for chart area including scrollbar */
    }

    .chart-scroll-container {
        overflow-x: auto; /* Enable horizontal scrolling */
        -webkit-overflow-scrolling: touch; /* Smooth scrolling on iOS */
        padding-bottom: 5px; /* Adjust if scrollbar obscures labels */
    }

    /* Custom scrollbar styling (Webkit browsers) */
    .chart-scroll-container::-webkit-scrollbar {
        height: 8px; /* Height of horizontal scrollbar */
    }
    .chart-scroll-container::-webkit-scrollbar-track {
        background: #f1f1f1;
        border-radius: 10px;
    }
    .chart-scroll-container::-webkit-scrollbar-thumb {
        background: #888;
        border-radius: 10px;
    }
    .chart-scroll-container::-webkit-scrollbar-thumb:hover {
        background: #555;
    }

    /* Ensure canvas takes appropriate space inside scrollable div */
    #monthlyRecapChart {
        height: 250px; /* Fixed height for the chart canvas */
        /* Width will be set dynamically by JS to allow scrolling */
    }

    /* Styles for navigation arrows - HIDDEN */
    .chart-navigation {
        display: none; /* Hide the navigation arrows */
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
        object-fit: cover; /* Ensures image fills the area, cropping if necessary */
        background-color: #eee; /* Placeholder background */
        flex-shrink: 0; /* Prevent shrinking */
        flex-grow: 0; /* Prevent growing */
        display: block; /* Ensures it behaves as a block element for consistent sizing */
    }
    .publisher-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        object-fit: cover;
        background-color: #eee;
    }
    /* Placeholder for Pie Chart */
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
    }
</style>

<div class="p-6"> {{-- Main padding for content area --}}

    {{-- WHITE CARD FOR HEADER & BREADCRUMB + SINGLE MONTH FILTER --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Beranda</h1>
            <div class="relative inline-block text-gray-700">
                <input type="month"
                        id="mainMonthFilter" {{-- ID unik untuk filter utama --}}
                        class="block appearance-none w-full bg-gray-50 border border-gray-300 text-gray-700 py-2 px-4 pr-8 rounded-lg leading-tight focus:outline-none focus:bg-white focus:border-custom-primary-red"
                        value="{{ now()->format('Y-m') }}"> {{-- Default to current month --}}
            </div>
        </div>
    </div>

    {{-- TOP SECTION: Title and Large Stats Cards --}}
    <h1 class="text-2xl font-semibold text-gray-800 mb-6"></h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
        {{-- Card: Number of Users --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
            <div class="icon-circle icon-red">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Jumlah Pengguna</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalUsers }}</h2>
            </div>
        </div>

        {{-- Card: Uploaded Count --}}
        <div class="bg-white rounded-xl shadow-sm p-6 flex items-center space-x-6">
            <div class="icon-circle icon-red">
                <i class="fas fa-upload"></i>
            </div>
            <div>
                <p class="text-gray-500 text-sm">Aplikasi Diunggah</p>
                <h2 class="text-3xl font-bold text-gray-800">{{ $totalAplikasiDiunggah }}</h2>
            </div>
        </div>
    </div>

    {{-- MIDDLE SECTION: Monthly Recap Chart (Left) & Most Visited Apps (Right) --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Left Column: Monthly Recap (Chart) --}}
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-xl font-semibold text-gray-800">Rekap Bulanan</h2>
            </div>
            <p class="text-gray-500 text-sm">Jumlah aplikasi diunggah per kategori</p>

            <div class="chart-wrapper">
                <div class="chart-scroll-container" id="monthlyRecapChartContainer">
                    <canvas id="monthlyRecapChart"></canvas>
                </div>
                {{-- Navigation arrows are hidden via CSS --}}
                <div class="chart-navigation">
                    <button id="scrollLeftBtn" aria-label="Scroll left"><i class="fas fa-chevron-left"></i></button>
                    <button id="scrollRightBtn" aria-label="Scroll right"><i class="fas fa-chevron-right"></i></button>
                </div>
            </div>
        </div>

        {{-- Right Column: Most Visited Apps --}}
        <div class="lg:col-span-1 bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Aplikasi Sering Dikunjungi</h2>
            <ol class="space-y-4" id="mostVisitedAppsList">
                {{-- Data akan dimuat di sini oleh JavaScript --}}
            </ol>
        </div>
    </div>

    {{-- BOTTOM SECTION: Popular Publishers (Left), Most Viewed News (Middle), Latest News (Right) --}}
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 mb-8">
        {{-- Left Column: Popular Publishers --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Publisher Terpopuler</h2>
            <ol class="space-y-3" id="popularPublishersList">
                {{-- Data akan dimuat di sini oleh JavaScript --}}
            </ol>
        </div>

        {{-- Middle Column: Most Viewed News (Doughnut Chart) --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Berita Sering Dilihat</h2>
            <p class="text-gray-800 text-xl font-bold mb-4" id="totalNewsViews"></p>
            <div class="flex flex-col items-center justify-center">
                <div class="pie-chart-placeholder">
                    <canvas id="newsPieChart"></canvas>
                </div>
                <div class="mt-4 text-sm w-full" id="newsPieChartLegend">
                    {{-- Data akan dimuat di sini oleh JavaScript --}}
                </div>
            </div>
        </div>

        {{-- Right Column: Latest News --}}
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Berita Terbaru</h2>
            <ul class="mt-4 space-y-3" id="latestNewsList">
                {{-- Data akan dimuat di sini oleh JavaScript --}}
            </ul>
        </div>
    </div>
</div>

{{-- CDN Chart.js --}}
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{-- Font Awesome for Icons (ensure this is linked in your main layout or here) --}}
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<script>
    // Define colors once for consistency (can be expanded or dynamically generated)
    const COLORS = ['#AD1500', '#3B82F6', '#EF4444', '#22C55E', '#F59E0B', '#8B6DBF', '#10B981', '#6366F1', '#EC4899', '#F97316'];

    // Global variables to hold chart instances
    let monthlyRecapChart;
    let newsPieChart;

    document.addEventListener('DOMContentLoaded', function () {
        const initialData = @json($initialData);

        renderMonthlyRecapChart(initialData.monthlyRecap.labels, initialData.monthlyRecap.datasets);
        renderNewsPieChart(initialData.newsChart.labels, initialData.newsChart.data);
        updateMostVisitedAppsList(initialData.mostVisitedApps);
        updatePopularPublishersList(initialData.popularPublishers);
        updateLatestNewsList(initialData.latestNews);

        document.getElementById('mainMonthFilter').addEventListener('change', function() {
            const [year, month] = this.value.split('-');
            fetchDashboardData(month, year);
        });
    });

    /**
     * Renders or updates the Monthly Recap Bar Chart, showing total apps per category.
     * @param {Array<string>} originalLabels - Original labels for the X-axis (days).
     * @param {Array<Object>} originalDatasets - Array of dataset objects, each with label (category) and daily data.
     */
    function renderMonthlyRecapChart(originalLabels, originalDatasets) {
        const ctx = document.getElementById('monthlyRecapChart').getContext('2d');
        if (monthlyRecapChart) monthlyRecapChart.destroy(); // Destroy previous chart instance

        // Aggregate data by category for the entire month
        const categoryLabels = [];
        const categoryData = []; // Store raw counts for bar heights and tooltip
        const categoryColors = [];

        originalDatasets.forEach((dataset, index) => {
            categoryLabels.push(dataset.label); // Category name
            const totalForCategory = dataset.data.reduce((sum, value) => sum + value, 0);
            categoryData.push(totalForCategory); // Sum of apps for the month for this category
            categoryColors.push(COLORS[index % COLORS.length]); // Assign color
        });

        // Determine a suitable suggestedMax for the Y-axis based on actual data
        const maxDataValue = Math.max(...categoryData);
        // If max is 0 or low, set a default suggestedMax, otherwise calculate a slightly higher max
        const suggestedYMax = maxDataValue > 0 ? Math.ceil(maxDataValue * 1.2) : 10; // Ensure at least 10 if no data or very little


        monthlyRecapChart = new Chart(ctx, {
            type: 'bar', // Type remains 'bar'
            data: {
                labels: categoryLabels, // Now category names
                datasets: [{
                    label: 'Jumlah Aplikasi', // Label for tooltip
                    data: categoryData, // Data is now raw counts
                    backgroundColor: categoryColors, // Use distinct colors for each bar
                    hoverBackgroundColor: categoryColors.map(color => color + '80'),
                    barPercentage: 0.8,
                    categoryPercentage: 0.8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false, // No need for legend
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                        callbacks: {
                            label: function(context) {
                                // Tooltip now directly uses the raw count
                                return context.label + ': ' + context.parsed.y + ' Aplikasi';
                            }
                        }
                    }
                },
                scales: {
                    x: {
                        stacked: false,
                        title: {
                            display: true,
                            text: 'Kategori' // Updated title for X-axis
                        },
                        grid: {
                            display: false
                        },
                        ticks: {
                            autoSkip: false,
                            maxRotation: 45, // Rotate labels by 45 degrees
                            minRotation: 45, // Ensure they stay at 45 degrees
                            font: {
                                size: 12
                            }
                        },
                    },
                    y: {
                        stacked: false,
                        beginAtZero: true,
                        title: {
                            display: true, // Display Y-axis title
                            text: 'Jumlah Aplikasi' // Reverted Y-axis title
                        },
                        grid: {
                            display: false // Still hide grid lines for a cleaner look
                        },
                        ticks: {
                            display: false, // Hide Y-axis tick labels (numbers)
                            min: 0,
                            callback: function(value) {
                                // This callback is still here but display: false overrides it for visual ticks
                                if (Number.isInteger(value)) {
                                    return value;
                                }
                            }
                        },
                        suggestedMax: suggestedYMax // Use the dynamically determined max
                    }
                }
            }
        });

        // ====================================================================================
        // Logic to set canvas width to ensure all labels are visible and scrollable
        // ====================================================================================
        const chartCanvas = document.getElementById('monthlyRecapChart');
        const chartScrollContainer = document.getElementById('monthlyRecapChartContainer');
        const numLabels = categoryLabels.length;

        // Adjusted for category names and rotation. Increased minimum width per bar.
        const minimumBarDisplayWidth = 100;
        const calculatedCanvasWidth = numLabels * minimumBarDisplayWidth;

        // Ensure canvas width is at least container width to avoid shrinking on small data sets
        chartCanvas.style.width = `${Math.max(chartScrollContainer.clientWidth, calculatedCanvasWidth)}px`;
    }

    /**
     * Renders or updates the News Doughnut Chart.
     * @param {Array<string>} labels
     * @param {Array<number>} data
     */
    function renderNewsPieChart(labels, data) {
        const ctx = document.getElementById('newsPieChart').getContext('2d');
        if (newsPieChart) newsPieChart.destroy();

        newsPieChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                labels: labels,
                datasets: [{
                    data: data,
                    backgroundColor: COLORS,
                    hoverOffset: 4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });

        const legendContainer = document.getElementById('newsPieChartLegend');
        const totalNewsViewsElement = document.getElementById('totalNewsViews');
        const totalViews = data.reduce((sum, val) => sum + val, 0);
        totalNewsViewsElement.textContent = `${totalViews.toLocaleString('id-ID')} Kunjungan Total`;

        if (labels.length > 0) {
            legendContainer.innerHTML = '';
            labels.forEach((label, index) => {
                const color = COLORS[index % COLORS.length];
                const value = data[index];
                legendContainer.innerHTML += `
                    <div class="flex items-center mb-1">
                        <span class="block w-3 h-3 rounded-full mr-2" style="background-color: ${color};"></span>
                        <span class="text-gray-700">${label}</span>: <span class="ml-auto font-semibold">${value.toLocaleString('id-ID')}</span>
                    </div>
                `;
            });
        } else {
            legendContainer.innerHTML = '<div class="text-gray-500 text-center">Tidak ada data berita untuk grafik.</div>';
        }
    }

    /**
     * Updates the Most Visited Apps list.
     * @param {Array<Object>} apps - Array of app objects.
     */
    function updateMostVisitedAppsList(apps) {
        const listContainer = document.getElementById('mostVisitedAppsList');
        listContainer.innerHTML = '';

        // Limit to 10 apps
        const limitedApps = apps.slice(0, 10);

        if (limitedApps.length > 0) {
            limitedApps.forEach((app, index) => { // Added index for numbering
                // MENGGUNAKAN 'thumbnail_aplikasi' UNTUK GAMBAR
                const appThumbnail = app.thumbnail_aplikasi || 'https://placehold.co/40x40/cccccc/333333?text=App';
                // Handle cases where total_kunjungan might be null, undefined, or not a valid number
                const kunjunganCount = (app.total_kunjungan == null || isNaN(app.total_kunjungan))
                    ? 'N/A'
                    : app.total_kunjungan.toLocaleString('id-ID'); // Format number for readability

                listContainer.innerHTML += `
                    <li class="flex items-center space-x-3">
                        <span class="font-bold text-gray-700 w-6 text-right">${index + 1}.</span> <!-- Numbering -->
                        <img src="${appThumbnail}" alt="${app.nama_aplikasi} thumbnail" class="app-avatar">
                        <div class="flex-grow flex flex-col justify-center">
                            <p class="text-gray-800 font-semibold">${app.nama_aplikasi}</p>
                            <p class="text-gray-500 text-sm">${app.nama_pemilik}</p>
                        </div>
                        <div class="flex items-center ml-auto">
                            <span class="font-semibold text-gray-700 text-base">${kunjunganCount}</span>
                        </div>
                    </li>
                `;
            });
        } else {
            listContainer.innerHTML = '<li class="text-gray-500 text-center">Tidak ada aplikasi sering dikunjungi.</li>';
        }
    }

    /**
     * Updates the Popular Publishers list.
     * @param {Array<Object>} publishers - Array of publisher objects.
     */
    function updatePopularPublishersList(publishers) {
        const listContainer = document.getElementById('popularPublishersList');
        listContainer.innerHTML = '';

        if (publishers.length > 0) {
            publishers.forEach((publisher, index) => { // Added index for numbering
                const publisherLogo = publisher.publisher_logo || 'https://placehold.co/32x32/cccccc/333333?text=P';
                listContainer.innerHTML += `
                    <li class="flex items-center space-x-3">
                        <span class="font-bold text-gray-700 w-6 text-right">${index + 1}.</span> <!-- Numbering -->
                        <img src="${publisherLogo}" alt="${publisher.nama_pemilik} avatar" class="publisher-avatar">
                        <div class="flex-grow">
                            <p class="text-gray-800 font-semibold">${publisher.nama_pemilik}</p>
                        </div>
                        <p class="text-gray-500 text-sm">${publisher.total_unduhan_apps.toLocaleString('id-ID')} Kunjungan</p>
                    </li>
                `;
            });
        } else {
            listContainer.innerHTML = '<li class="text-gray-500 text-center">Tidak ada publisher terpopuler.</li>';
        }
    }

    /**
     * Updates the Latest News list.
     * @param {Array<Object>} news - Array of news article objects.
     */
    function updateLatestNewsList(news) {
        const listContainer = document.getElementById('latestNewsList');
        listContainer.innerHTML = '';

        if (news.length > 0) {
            news.forEach(beritaItem => {
                listContainer.innerHTML += `
                    <li>
                        <a href="{{ url('/admin/berita') }}/${beritaItem.id}" class="text-gray-800 font-semibold hover:text-[#AD1500]">${beritaItem.judul_berita}</a>
                        <p class="text-gray-500 text-xs">${beritaItem.tanggal_dibuat}</p>
                    </li>
                `;
            });
        } else {
            listContainer.innerHTML = '<li class="text-gray-500">Tidak ada berita terbaru untuk ditampilkan.</li>';
        }
    }

    /**
     * Fetches filtered dashboard data from the server via AJAX.
     * @param {string} month - The month (e.g., '01' for January).
     * @param {string} year - The year (e.g., '2024').
     */
    function fetchDashboardData(month, year) {
        fetch(`{{ route('admin.dashboard.data') }}?month=${month}&year=${year}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                // Update total users and uploaded apps counts
                // Using specific IDs or a more robust way to target these elements
                document.querySelector('h2.text-3xl.font-bold.text-gray-800:first-of-type').textContent = data.totalUsers;
                document.querySelector('h2.text-3xl.font-bold.text-gray-800:last-of-type').textContent = data.totalAplikasiDiunggah;

                renderMonthlyRecapChart(data.monthlyRecap.labels, data.monthlyRecap.datasets);
                renderNewsPieChart(data.newsChart.labels, data.newsChart.data);
                updateMostVisitedAppsList(data.mostVisitedApps);
                updatePopularPublishersList(data.popularPublishers);
                updateLatestNewsList(data.latestNews);
            })
            .catch(error => {
                console.error('Error fetching dashboard data:', error);
                // Instead of alert, you might want to show a more user-friendly message in the UI
                const errorMessageElement = document.createElement('div');
                errorMessageElement.className = 'text-red-500 bg-red-100 border border-red-400 rounded p-3 mt-4';
                errorMessageElement.textContent = 'Gagal memuat data dashboard. Silakan coba lagi.';
                document.querySelector('.p-6').prepend(errorMessageElement); // Add to top of content area
                setTimeout(() => errorMessageElement.remove(), 5000); // Remove after 5 seconds
            });
    }
</script>
@endsection
