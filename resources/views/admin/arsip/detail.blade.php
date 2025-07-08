@extends('layouts.admin') 

@section('title', 'Detail Arsip') 

@section('content')
<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
    {{-- Konten halaman riwayat Anda di sini --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Detail Arsip</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.arsip.index') }}" class="hover:text-custom-primary-red">Arsip</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">

        {{-- Header: Kembali Button --}}
        <div class="mb-6">
            <a href="{{ route('admin.arsip.index') }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        {{-- NEW FLEX CONTAINER for App Info + Carousel --}}
        <div class="flex flex-col md:flex-row md:space-x-8 mb-8 px-6">
            {{-- Left Column: App Title, Info, Google Play Button --}}
            <div class="flex-1 md:w-1/2">
                <h1 class="text-3xl font-bold font-poppins text-gray-800 mb-1">{{ $aplikasi->nama_aplikasi }}</h1>
                <p class="text-gray-600 text-sm font-poppins mb-4">{{ $aplikasi->nama_pemilik }}</p>

                <div class="flex items-center space-x-4 mb-6">
                    {{-- Display the app logo --}}
                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="{{ $aplikasi->nama_aplikasi }} Icon" class="w-20 h-20 rounded-xl shadow-md flex-shrink-0">
                    {{-- Google Play Button --}}
                    <a href="{{ $aplikasi->tautan_aplikasi }}" target="_blank"
                        class="inline-flex items-center px-4 py-3 rounded-lg bg-white border border-gray-300 shadow-sm
                        hover:shadow-md hover:border-gray-400 transition-all duration-200 space-x-3">
                        {{-- Google Play Icon --}}
                        <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/Google_Play_Arrow_logo.svg"
                        alt="Google Play Icon Only"
                        class="h-7 w-7">
                        {{-- Text for Google Play --}}
                        <span class="text-sm text-gray-800 font-poppins">
                            Dapatkan di <br>
                            <strong class="font-bold">Google Play</strong>
                        </span>
                    </a>
                </div>
            </div>

            {{-- Right Column: Image Gallery (Carousel) --}}
            <div class="flex-1 md:w-1/2 relative overflow-hidden rounded-lg shadow-md mt-8 md:mt-0">
                <div id="gallery-carousel" class="flex transition-transform duration-300 ease-in-out" style="transform: translateX(0);">
                    {{-- Loop through aplikasi->fotoAplikasi to display images --}}
                    @forelse($aplikasi->fotoAplikasi as $key => $foto)
                        <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Screenshot {{ $key + 1 }}" class="w-full flex-shrink-0 object-cover rounded-lg cursor-pointer" style="max-height: 300px;" data-index="{{ $key }}">
                    @empty
                        <p class="p-4 text-gray-500">Tidak ada gambar yang tersedia.</p>
                    @endforelse
                </div>

                @if($aplikasi->fotoAplikasi->count() > 0)
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
                @endif
            </div>
        </div>

        {{-- Description/Features Section --}}
        <div class="mb-8 px-6"> {{-- Added px-6 for consistent padding --}}
            <h2 class="text-2xl font-bold font-poppins text-gray-800 mb-4">Deskripsi</h2>
            <div id="description-content" class="text-gray-700 font-poppins leading-relaxed overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 120px;">
                {{-- Display the description --}}
                <p>{!! nl2br(e($aplikasi->deskripsi)) !!}</p>
                @if($aplikasi->fitur)
                    <p class="mt-4">Fitur Utama:</p>
                    <ul class="list-disc list-inside mt-2">
                        {{-- Assuming 'fitur' is stored as a string with each feature on a new line or comma-separated --}}
                        @foreach(explode("\n", $aplikasi->fitur) as $feature)
                            @if(trim($feature))
                                <li>{{ trim($feature) }}</li>
                            @endif
                        @endforeach
                    </ul>
                @endif
            </div>
            <button id="read-more-btn" class="mt-4 text-red-600 hover:text-red-700 font-semibold font-poppins focus:outline-none">Baca Selengkapnya</button>
        </div>

        {{-- Additional Info Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 font-poppins text-sm mb-8 px-6"> {{-- Added px-6 --}}
            <div>
                <p class="font-semibold">Dirilis Tanggal</p>
                <p>{{ $aplikasi->tanggal_rilis->format('d F Y') }}</p>
            </div>
            <div>
                <p class="font-semibold">Diupdate Pada</p>
                <p>{{ $aplikasi->updated_at->format('d F Y') }}</p> 
            </div>
            <div>
                <p class="font-semibold">Versi</p>
                <p>{{ $aplikasi->versi }}</p>
            </div>
            <div>
                <p class="font-semibold">Rating Konten</p>
                <p>Rating {{ $aplikasi->rating_konten }}+ : {{ $aplikasi->rating_konten_deskripsi ?? 'Kekerasan tingkat menengah' }} </p> {{-- Assuming you might have a rating_konten_deskripsi field or default it --}}
            </div>
        </div>

        {{-- Rating and Reviews Section --}}
        <div class="rating-reviews-section px-6">
            <h2 class="text-2xl font-bold font-poppins text-gray-800 mb-4">Ulasan</h2>

            {{-- List of Reviews --}}
            <div id="reviews-content" class="reviews-list space-y-6 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 300px;">
                @forelse($aplikasi->ulasan as $ulasan)
                    <div class="flex items-start space-x-4">
                        <img src="{{ asset('images/ulasan.png') }}" alt="Avatar {{ $ulasan->user->name ?? 'Pengguna' }}" class="w-12 h-12 rounded-full object-cover shadow-sm">
                        <div>
                            <div class="flex items-center justify-between w-full">
                                <p class="font-semibold text-gray-800 font-poppins">{{ $ulasan->user->name ?? 'Pengguna Anonim' }}</p>
                                <span class="text-gray-500 text-xs font-poppins">{{ $ulasan->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-gray-700 text-sm mt-1 font-poppins">{{ $ulasan->komentar }}</p>
                        </div>
                    </div>
                @empty
                    <p class="text-gray-500">Belum ada ulasan untuk aplikasi ini.</p>
                @endforelse
            </div>

            <div class="text-left mt-8">
                <button id="toggle-reviews-btn" class="text-red-600 hover:text-red-700 font-semibold font-poppins focus:outline-none">Lihat Semua Ulasan</button>
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
            // Check if there are any images to prevent errors
            if (carouselImages.length === 0) return;

            // Calculate itemWidth dynamically based on the first child's actual width
            const itemWidth = carousel.children[0].offsetWidth;
            carousel.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }

        // Only add event listeners if there are images
        if (carouselImages.length > 0) {
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
                updateCarousel();
            });

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % carouselImages.length;
                updateCarousel();
            });
        }


        // Ensure carousel updates on window resize
        window.addEventListener('resize', updateCarousel);

        // Read More functionality for Description
        const descriptionContent = document.getElementById('description-content');
        const readMoreBtn = document.getElementById('read-more-btn');
        const initialDescriptionHeight = 120; // Corresponds to approx 4 lines of text

        // Check if description content overflows initially and set max-height
        // Use setTimeout to ensure scrollHeight is calculated after content is rendered
        setTimeout(() => {
            if (descriptionContent.scrollHeight > initialDescriptionHeight) {
                descriptionContent.style.maxHeight = `${initialDescriptionHeight}px`;
                descriptionContent.style.transition = 'max-height 0.3s ease-out';
                readMoreBtn.style.display = 'block'; // Ensure button is visible if content overflows
            } else {
                readMoreBtn.style.display = 'none'; // Hide button if content is short
            }
        }, 0);


        readMoreBtn.addEventListener('click', () => {
            if (descriptionContent.style.maxHeight === `${initialDescriptionHeight}px`) {
                descriptionContent.style.maxHeight = descriptionContent.scrollHeight + 'px';
                readMoreBtn.textContent = 'Baca Lebih Sedikit';
            } else {
                descriptionContent.style.maxHeight = `${initialDescriptionHeight}px`;
                readMoreBtn.textContent = 'Baca Selengkapnya';
            }
        });

        // Read More/Less functionality for Reviews
        const reviewsContent = document.getElementById('reviews-content');
        const toggleReviewsBtn = document.getElementById('toggle-reviews-btn');
        const initialReviewsHeight = 300;

        // Check if reviews content overflows initially and set max-height
        // Use setTimeout to ensure scrollHeight is calculated after content is rendered
        setTimeout(() => {
            if (reviewsContent.scrollHeight > initialReviewsHeight) {
                reviewsContent.style.maxHeight = `${initialReviewsHeight}px`;
                reviewsContent.style.transition = 'max-height 0.3s ease-out';
                toggleReviewsBtn.style.display = 'block'; 
            } else {
                toggleReviewsBtn.style.display = 'none'; 
            }
        }, 0);


        toggleReviewsBtn.addEventListener('click', () => {
            if (reviewsContent.style.maxHeight === `${initialReviewsHeight}px`) {
                reviewsContent.style.maxHeight = reviewsContent.scrollHeight + 'px';
                toggleReviewsBtn.textContent = 'Lihat Lebih Sedikit';
            } else {
                reviewsContent.style.maxHeight = `${initialReviewsHeight}px`;
                toggleReviewsBtn.textContent = 'Lihat Semua Ulasan';
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