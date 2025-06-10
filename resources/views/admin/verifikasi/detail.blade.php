@extends('layouts.admin') {{-- Memastikan halaman ini menggunakan layout admin Anda --}}

@section('title', 'Detail Verifikasi') {{-- INI YANG SAYA UBAH MENJADI 'Detail Arsip' UNTUK KONSISTENSI --}}

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    {{-- Konten halaman riwayat Anda di sini --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Detail</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.verifikasi') }}" class="hover:text-custom-primary-red">Verifikasi</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>
    
    <div class="bg-white shadow-md rounded-lg p-6">

        {{-- Header: Kembali Button --}}
        {{-- Removed px-6 here to allow it to align with the overall section padding (px-4) --}}
        <div class="mb-6">
        <a href="{{ route('admin.verifikasi') }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- NEW FLEX CONTAINER for App Info + Carousel --}}
        {{-- This container now holds the left (app info) and right (carousel) columns. --}}
        {{-- px-6 is applied here to give consistent horizontal padding for these two columns. --}}
        <div class="flex flex-col md:flex-row md:space-x-8 mb-8 px-6">
            {{-- Left Column: App Title, Info, Google Play Button --}}
            <div class="flex-1 md:w-1/2">
                <h1 class="text-3xl font-bold font-poppins text-gray-800 mb-1">{{ $aplikasi['nama_aplikasi'] }}</h1>
                <p class="text-gray-600 text-sm font-poppins mb-4">{{ $aplikasi['nama_pemilik'] }}</p>

                <div class="flex items-center space-x-4 mb-6">
                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="{{ $aplikasi->nama_aplikasi }} Logo" class="w-20 h-20 rounded-xl shadow-md flex-shrink-0">
                    <div class="flex items-center space-x-4">
                        {{-- Rating --}}
                        <div class="flex flex-col items-start">
                            <div class="flex items-center">
                                <span class="text-gray-700 text-base font-poppins font-semibold">3,8</span>
                                <svg class="w-4 h-4 text-yellow-400 fill-current ml-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z" />
                                </svg>
                            </div>
                            <span class="text-gray-600 text-xs font-poppins">37,2 jt ulasan</span>
                        </div>

                        {{-- Separator --}}
                        <div class="h-10 w-px bg-gray-300"></div>

                        {{-- Downloads --}}
                        <div class="flex flex-col items-start">
                            <span class="text-gray-700 text-base font-poppins font-semibold">500 jt+</span>
                            <span class="text-gray-600 text-xs font-poppins">download</span>
                        </div>

                        {{-- Separator --}}
                        <div class="h-10 w-px bg-gray-300"></div>

                        {{-- Age Rating --}}
                        <div class="flex flex-col items-start">
                            <span class="text-gray-700 text-base font-poppins font-semibold">12+</span>
                            <span class="text-gray-600 text-xs font-poppins">rating 12+</span>
                        </div>
                    </div>
                </div>

                {{-- Google Play Button - Updated to match the provided image --}}
                <a href="https://play.google.com/store/apps/details?id=com.mobile.legends" target="_blank"
                   class="inline-flex items-center px-4 py-3 rounded-lg bg-white border border-gray-300 shadow-sm
                                 hover:shadow-md hover:border-gray-400 transition-all duration-200 space-x-3">
                    {{-- Google Play Icon --}}
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/Google_Play_Arrow_logo.svg"
                                 alt="Google Play Icon Only"
                                 class="h-7 w-7"> {{-- Adjusted size to match image --}}

                    {{-- Text for Google Play --}}
                    <span class="text-sm text-gray-800 font-poppins">
                        Dapatkan di <br>
                        <strong class="font-bold">Google Play</strong>
                    </span>
                </a>
            </div>

            {{-- Right Column: Image Gallery (Carousel) --}}
            {{-- Added mt-8 for mobile spacing, md:mt-0 to remove it on larger screens --}}
            <div class="flex-1 md:w-1/2 relative overflow-hidden rounded-lg shadow-md mt-8 md:mt-0">
                <div id="gallery-carousel" class="flex transition-transform duration-300 ease-in-out" style="transform: translateX(0);">
                    {{-- Reduced max-height for smaller appearance --}}
                    {{-- Added data-index attribute to each image for easy lookup in JS --}}
                    @foreach($aplikasi->fotoAplikasi as $index => $foto)
                        <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Screenshot {{ $index + 1 }}" class="w-full flex-shrink-0 object-cover rounded-lg cursor-pointer" style="max-height: 300px;" data-index="{{ $index }}">
                    @endforeach
                </div>

                <button id="prev-btn" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-75 hover:opacity-100 transition-opacity hover:bg-white hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="next-btn" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-75 hover:opacity-100 transition-opacity hover:bg-white hover:text-gray-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Description/Features Section --}}
        {{-- Removed px-6 here --}}
        <div class="mb-8">
            <h2 class="text-2xl font-bold font-poppins text-gray-800 mb-4">Deskripsi</h2>
            <div id="description-content" class="text-gray-700 font-poppins leading-relaxed overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 120px;">
                <p>{{ $aplikasi['deskripsi'] }}</p>
                <p class="mt-4">Fitur Utama:</p>
                {{ $aplikasi['fitur'] }}
                {{-- <ul class="list-disc list-inside mt-2"> 
                    <li>Pertempuran MOBA 5v5 Klasik</li>
                    <li>Berbagai Pahlawan unik</li>
                    <li>Kontrol mudah untuk perangkat seluler</li>
                    <li>Pertandingan cepat dan efisien</li>
                    <li>Strategi tim yang seru</li>
                    <li>Grafik memukau dan efek visual imersif</li>
                    <li>Pembaruan rutin</li>
                    <li>Komunitas aktif</li>
                    <li>Sistem peringkat kompetitif</li>
                    <li>Dukungan multi-bahasa</li>
                </ul>
                <p class="mt-4">Mobile Legends: Bang Bang terus menjadi game yang sangat diminati, menawarkan pengalaman MOBA yang seru dan kompetitif langsung di perangkat seluler Anda.</p> --}}
            </div>
            <button id="read-more-btn" class="mt-4 text-red-600 hover:text-red-700 font-semibold font-poppins focus:outline-none">Baca Selengkapnya</button>
        </div>

        {{-- Additional Info Section --}}
        {{-- Removed px-6 here --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 font-poppins text-sm mb-8">
            <div>
                <p class="font-semibold">Dirilis Tanggal</p>
                <p>{{ $aplikasi['tanggal_rilis'] }}</p>
            </div>
            <div>
                <p class="font-semibold">Diupdate Pada</p>
                <p>{{ $aplikasi['tanggal_update'] }}</p>
            </div>
            <div>
                <p class="font-semibold">Versi</p>
                <p>{{ $aplikasi['versi'] }}</p>
            </div>
            <div>
                <p class="font-semibold">Rating Konten</p>
                <p>{{ $aplikasi['rating_konten'] }}</p>
            </div>
        </div>

    </div>
</div>

{{-- Image Modal Pop-up --}}
<div id="image-modal" class="fixed inset-0 bg-black bg-opacity-75 flex items-center justify-center z-50 hidden">
    <button id="close-modal-btn" class="absolute top-4 right-4 text-white text-3xl font-bold">&times;</button>
    <div class="relative">
        <img id="modal-image" src="" alt="Enlarged Screenshot" class="max-w-full max-h-[90vh] rounded-lg shadow-lg object-contain">
        <button id="modal-prev-btn" class="absolute left-4 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full opacity-75 hover:opacity-100 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </button>
        <button id="modal-next-btn" class="absolute right-4 top-1/2 transform -translate-y-1/2 bg-gray-800 text-white p-3 rounded-full opacity-75 hover:opacity-100 transition-opacity">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
            </svg>
        </button>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Carousel functionality
        const carousel = document.getElementById('gallery-carousel');
        const carouselImages = carousel.querySelectorAll('img'); // Get all images in the carousel
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        let currentIndex = 0;

        function updateCarousel() {
            // Calculate itemWidth dynamically based on the first child's actual width
            // This ensures responsiveness if image sizes change or screen resizes
            const itemWidth = carousel.children[0].offsetWidth;
            carousel.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
            updateCarousel();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % carouselImages.length;
            updateCarousel();
        });

        // Ensure carousel updates on window resize
        window.addEventListener('resize', updateCarousel);

        // Read More functionality for Description
        const descriptionContent = document.getElementById('description-content');
        const readMoreBtn = document.getElementById('read-more-btn');
        const initialDescriptionHeight = 120; // Corresponds to approx 4 lines of text

        // Check if description content overflows initially and set max-height
        if (descriptionContent.scrollHeight > initialDescriptionHeight) {
            descriptionContent.style.maxHeight = `${initialDescriptionHeight}px`;
            descriptionContent.style.transition = 'max-height 0.3s ease-out';
            readMoreBtn.style.display = 'block'; // Ensure button is visible if content overflows
        } else {
            readMoreBtn.style.display = 'none'; // Hide button if content is short
        }

        readMoreBtn.addEventListener('click', () => {
            if (descriptionContent.style.maxHeight === `${initialDescriptionHeight}px`) {
                descriptionContent.style.maxHeight = descriptionContent.scrollHeight + 'px';
                readMoreBtn.textContent = 'Baca Lebih Sedikit';
            } else {
                descriptionContent.style.maxHeight = `${initialDescriptionHeight}px`;
                readMoreBtn.textContent = 'Baca Selengkapnya';
            }
        });

        // Image Modal Functionality
        const imageModal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const modalPrevBtn = document.getElementById('modal-prev-btn');
        const modalNextBtn = document.getElementById('modal-next-btn');

        // Open modal when any carousel image is clicked
        carouselImages.forEach((image, index) => {
            image.addEventListener('click', () => {
                currentIndex = index; // Set current index to the clicked image's index
                updateModalImage();
                imageModal.classList.remove('hidden');
            });
        });

        // Update modal image based on currentIndex
        function updateModalImage() {
            modalImage.src = carouselImages[currentIndex].src;
        }

        // Close modal when close button is clicked
        closeModalBtn.addEventListener('click', () => {
            imageModal.classList.add('hidden');
        });

        // Close modal when clicking outside the image (on the overlay)
        imageModal.addEventListener('click', (event) => {
            if (event.target === imageModal) {
                imageModal.classList.add('hidden');
            }
        });

        // Modal navigation buttons
        modalPrevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
            updateModalImage();
        });

        modalNextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % carouselImages.length;
            updateModalImage();
        });
    });
</script>
@endsection