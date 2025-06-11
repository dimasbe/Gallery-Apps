@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    {{-- Main content wrapper. Removed max-w-4xl, bg-white, p-6, rounded-lg, shadow-md from this div previously. --}}
    <div class="w-full max-w-7xl">

        {{-- Header: Kembali Button --}}
        {{-- Removed px-6 here to allow it to align with the overall section padding (px-4) --}}
        <div class="mb-6">
            <a href="{{ route('tambah_aplikasi.index') }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                kembali
            </a>
        </div>

        <div class="flex flex-col md:flex-row md:space-x-8 mb-8 px-6">
            {{-- Left Column: App Title, Info, Google Play Button --}}
            <div class="flex-1 md:w-1/2">
                <h1 class="text-3xl font-bold font-poppins text-gray-800 mt-2 mb-3">{{ $aplikasi->nama_aplikasi }}</h1>
                <p class="text-gray-600 text-sm font-poppins mt-2 mb-3">{{ $aplikasi->nama_pemilik }}</p>

                <div class="flex items-center space-x-8 mb-8">
                    {{-- Logo --}}
                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="{{ $aplikasi->nama_aplikasi }} Logo" class="w-20 h-20 rounded-xl shadow-md flex-shrink-0">

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

            <div class="flex-1 md:w-1/2 relative overflow-hidden rounded-lg shadow-md mt-8 md:mt-0">
                <div id="gallery-carousel" class="flex transition-transform duration-300 ease-in-out" style="transform: translateX(0);">
                    @foreach ($fotoAplikasi as $index => $foto)
                        <img src="{{ asset('storage/' . $foto->path_foto) }}"
                            alt="Screenshot {{ $index + 1 }}"
                            class="w-full flex-shrink-0 object-cover rounded-lg cursor-pointer"
                            style="max-height: 300px;"
                            data-index="{{ $index }}">
                    @endforeach
                </div>

                <button id="prev-btn" class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-75 hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button id="next-btn" class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-gray-800 text-white p-2 rounded-full opacity-75 hover:opacity-100 transition-opacity">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Deskripsi Section --}}
        <div class="mb-8 px-6"> {{-- Added px-6 for consistent padding --}}
            <div class="flex items-center space-x-2 mb-4">
                <h2 class="text-2xl font-bold font-poppins text-gray-800">Deskripsi</h2>
                <button id="deskripsiButton"
                        type="button"
                        class="transition-transform duration-300 transform text-gray-800 hover:text-red-600"
                        data-bs-toggle="modal"
                        data-bs-target="#deskripsiModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div class="text-gray-700 font-poppins leading-relaxed">
                {{ \Illuminate\Support\Str::words(strip_tags($aplikasi->deskripsi), 50, '...') }}
            </div>
        </div>

        {{-- Fitur Section --}}
        <div class="mb-8 px-6"> {{-- Added px-6 for consistent padding --}}
            <div class="flex items-center space-x-2 mb-4">
                <h2 class="text-2xl font-bold font-poppins text-gray-800">Fitur</h2>
                <button id="fiturButton"
                        type="button"
                        class="transition-transform duration-300 transform text-gray-800 hover:text-red-600"
                        data-bs-toggle="modal"
                        data-bs-target="#fiturModal">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 rotate-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div class="text-gray-700 font-poppins leading-relaxed">
                {{ \Illuminate\Support\Str::words(strip_tags($aplikasi->fitur), 50, '...') }}
            </div>
        </div>

        {{-- Modal Deskripsi --}}
        <div class="modal fade" id="deskripsiModal" tabindex="-1" aria-labelledby="deskripsiModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content font-poppins">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deskripsiModalLabel">Deskripsi Lengkap</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        {!! nl2br(e($aplikasi->deskripsi)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Fitur --}}
        <div class="modal fade" id="fiturModal" tabindex="-1" aria-labelledby="fiturModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content font-poppins">
                    <div class="modal-header">
                        <h5 class="modal-title" id="fiturModalLabel">Fitur Lengkap</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                    </div>
                    <div class="modal-body">
                        {!! nl2br(e($aplikasi->fitur)) !!}
                    </div>
                </div>
            </div>
        </div>

        {{-- Additional Info Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 font-poppins text-sm mb-8 px-6"> {{-- Added px-6 for consistent padding --}}
            <div>
                <p class="font-semibold">Dirilis Tanggal</p>
                <p>{{ \Carbon\Carbon::parse($aplikasi->tanggal_rilis)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="font-semibold">Diupdate Pada</p>
                <p>{{ \Carbon\Carbon::parse($aplikasi->tanggal_update)->translatedFormat('d F Y') }}</p>
            </div>
            <div>
                <p class="font-semibold">Versi</p>
                <p>{{ $aplikasi->versi }}</p>
            </div>
            <div>
                <p class="font-semibold">Rating Konten</p>
                <p>{{ $aplikasi->rating_konten }}</p>
            </div>
        </div>

        {{-- Reviews Section --}}
        <div class="rating-reviews-section px-6"> {{-- Added px-6 for consistent padding --}}
            <h2 class="text-2xl font-bold font-poppins text-gray-800 mb-4">Ulasan</h2>

            {{-- Review Input Form --}}
            <div class="mb-6">
                <p class="font-semibold text-gray-700 mb-2 font-poppins">Beri Ulasan:</p>
                <div class="flex items-center space-x-3">
                    <input type="text" placeholder="Tulis ulasan..." class="flex-grow border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:border-red-500 text-sm font-poppins">
                    <button class="bg-[#AD1500] text-white px-6 py-2 rounded-lg hover:bg-[#8C1200] transition-colors font-poppins text-sm">
                        Kirim
                    </button>
                </div>
            </div>

            {{-- List of Reviews --}}
            <div id="reviews-content" class="reviews-list space-y-6 overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 300px;">
                {{-- Example Review 1 --}}
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/ulasan.png') }}" alt="Avatar Kim Sohun" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    <div>
                        <div class="flex items-center justify-between w-full">
                            <p class="font-semibold text-gray-800 font-poppins">Kim Sohun</p>
                            <span class="text-gray-500 text-xs font-poppins">5 jam yang lalu</span>
                        </div>
                        <p class="text-gray-700 text-sm mt-1 font-poppins">Gamenya seru banget, fitur-fiturnya juga lengkap</p>
                    </div>
                </div>

                {{-- Example Review 2 --}}
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/ulasan.png') }}" alt="Avatar Kim Sohun" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    <div>
                        <div class="flex items-center justify-between w-full">
                            <p class="font-semibold text-gray-800 font-poppins">Lee Minho</p>
                            <span class="text-gray-500 text-xs font-poppins">12 Maret 2024</span>
                        </div>
                        <p class="text-gray-700 text-sm mt-1 font-poppins">Aplikasi nya mantap, seru banget, Sukses selalu</p>
                    </div>
                </div>

                {{-- Example Review 3 --}}
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/ulasan.png') }}" alt="Avatar Kim Sohun" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    <div>
                        <div class="flex items-center justify-between w-full">
                            <p class="font-semibold text-gray-800 font-poppins">UI</p>
                            <span class="text-gray-500 text-xs font-poppins">13 April 2024</span>
                        </div>
                        <p class="text-gray-700 text-sm mt-1 font-poppins">Gamenya seru banget, fitur-fiturnya juga lengkap</p>
                    </div>
                </div>

                {{-- Example Review 4 --}}
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/ulasan.png') }}" alt="Avatar Kim Sohun" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    <div>
                        <div class="flex items-center justify-between w-full">
                            <p class="font-semibold text-gray-800 font-poppins">Lee Jongsuk</p>
                            <span class="text-gray-500 text-xs font-poppins">01 April 2024</span>
                        </div>
                        <p class="text-gray-700 text-sm mt-1 font-poppins">Aplikasi nya mantap, seru banget, Sukses selalu</p>
                    </div>
                </div>

                {{-- Example Review 5 --}}
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/ulasan.png') }}" alt="Avatar Kim Sohun" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    <div>
                        <div class="flex items-center justify-between w-full">
                            <p class="font-semibold text-gray-800 font-poppins">Dimas Bagus</p>
                            <span class="text-gray-500 text-xs font-poppins">15 April 2024</span>
                        </div>
                        <p class="text-gray-700 text-sm mt-1 font-poppins">Aplikasi nya lumayan oke, tapi dari segi tampilan kurang</p>
                    </div>
                </div>

                {{-- Example Review 6 --}}
                <div class="flex items-start space-x-4">
                    <img src="{{ asset('images/ulasan.png') }}" alt="Avatar Kim Sohun" class="w-12 h-12 rounded-full object-cover shadow-sm">
                    <div>
                        <div class="flex items-center justify-between w-full">
                            <p class="font-semibold text-gray-800 font-poppins">Ari Sandi</p>
                            <span class="text-gray-500 text-xs font-poppins">23 Desember 2025</span>
                        </div>
                        <p class="text-gray-700 text-sm mt-1 font-poppins">Aplikasi nya mantap seru banget</p>
                    </div>
                </div>
            </div>

            <div class="text-left mt-8">
                <button id="toggle-reviews-btn" class="text-red-600 hover:text-red-700 font-semibold font-poppins focus:outline-none">Lihat Semua Ulasan</button>
            </div>
        </div>

    </div>
</section>

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

{{-- Bootstrap JS Bundle --}}
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Carousel functionality
        const carousel = document.getElementById('gallery-carousel');
        const carouselImages = carousel.querySelectorAll('img');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        let currentIndex = 0;

        function updateCarousel() {
            if (carouselImages.length > 0) { // Ensure there are images before calculating width
                const itemWidth = carouselImages[0].offsetWidth; // Use carouselImages[0] instead of carousel.children[0] for robustness
                carousel.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
            }
        }

        prevBtn.addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
            updateCarousel();
        });

        nextBtn.addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % carouselImages.length;
            updateCarousel();
        });

        window.addEventListener('resize', updateCarousel);
        // Initial carousel update in case images are loaded before DOMContentLoaded
        updateCarousel();


        // Modal Toggle Functionality (for Deskripsi and Fitur)
        const modals = [
            { modalId: 'deskripsiModal', buttonId: 'deskripsiButton' },
            { modalId: 'fiturModal', buttonId: 'fiturButton' }
        ];

        modals.forEach(({ modalId, buttonId }) => {
            const modalElement = document.getElementById(modalId); // Renamed to modalElement to avoid conflict
            const button = document.getElementById(buttonId);
            const svg = button ? button.querySelector('svg') : null; // Check if button exists before querying svg

            if (modalElement && button && svg) {
                // Initialize Bootstrap Modal instance
                const bsModal = new bootstrap.Modal(modalElement, {
                    backdrop: true // Allow closing by clicking outside
                });

                // Add event listener to the button to show the modal (though data-bs-toggle handles this)
                // This part is mainly for the SVG rotation
                modalElement.addEventListener('shown.bs.modal', () => {
                    svg.classList.add('rotate-90');
                });

                modalElement.addEventListener('hidden.bs.modal', () => {
                    svg.classList.remove('rotate-90');
                });
            }
        });

        // Reviews Toggle Functionality
        const reviewsContent = document.getElementById('reviews-content');
        const toggleReviewsBtn = document.getElementById('toggle-reviews-btn');
        const initialReviewsHeight = 300;

        // Use a small delay to ensure content is rendered and scrollHeight is accurate
        setTimeout(() => {
            if (reviewsContent.scrollHeight > initialReviewsHeight) {
                reviewsContent.style.maxHeight = `${initialReviewsHeight}px`;
                reviewsContent.style.transition = 'max-height 0.3s ease-out';
                toggleReviewsBtn.style.display = 'block';
            } else {
                toggleReviewsBtn.style.display = 'none';
            }
        }, 100); // Increased delay slightly

        toggleReviewsBtn.addEventListener('click', () => {
            if (reviewsContent.style.maxHeight === `${initialReviewsHeight}px`) {
                reviewsContent.style.maxHeight = reviewsContent.scrollHeight + 'px';
                toggleReviewsBtn.textContent = 'Lihat Lebih Sedikit';
            } else {
                reviewsContent.style.maxHeight = `${initialReviewsHeight}px`;
                toggleReviewsBtn.textContent = 'Lihat Semua Ulasan';
            }
        });

        // Image Modal Pop-up (Fullscreen Image Viewer)
        const imageModal = document.getElementById('image-modal');
        const modalImage = document.getElementById('modal-image');
        const closeModalBtn = document.getElementById('close-modal-btn');
        const modalPrevBtn = document.getElementById('modal-prev-btn');
        const modalNextBtn = document.getElementById('modal-next-btn');

        carouselImages.forEach((image, index) => {
            image.addEventListener('click', () => {
                currentIndex = index;
                updateModalImage();
                imageModal.classList.remove('hidden');
            });
        });

        function updateModalImage() {
            modalImage.src = carouselImages[currentIndex].src;
        }

        closeModalBtn.addEventListener('click', () => {
            imageModal.classList.add('hidden');
        });

        imageModal.addEventListener('click', (event) => {
            if (event.target === imageModal) {
                imageModal.classList.add('hidden');
            }
        });

        modalPrevBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent closing modal if clicking on button
            currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
            updateModalImage();
        });

        modalNextBtn.addEventListener('click', (event) => {
            event.stopPropagation(); // Prevent closing modal if clicking on button
            currentIndex = (currentIndex + 1) % carouselImages.length;
            updateModalImage();
        });
    });
</script>
@endsection