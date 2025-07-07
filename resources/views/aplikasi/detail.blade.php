@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    <div class="w-full max-w-7xl">

        {{-- Header: Kembali Button --}}
        <div class="mb-6">
            <a href="{{ url()->previous() }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
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
                <p class="text-gray-600 text-sm font-poppins mt-2 mb-2">{{ $aplikasi->nama_pemilik }}</p>

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
        <div class="mb-8 px-6">
            <div class="flex items-center space-x-2 mb-4">
                <h2 class="text-2xl font-bold font-poppins text-gray-800">Deskripsi</h2>
                <button id="deskripsiToggleBtn"
                        type="button"
                        class="transition-transform duration-300 transform text-gray-800 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div id="deskripsiShort" class="text-gray-700 font-poppins leading-relaxed">
                {!! \Illuminate\Support\Str::words(strip_tags($aplikasi->deskripsi), 50, '...') !!}
            </div>
            <div id="deskripsiFull" class="text-gray-700 font-poppins leading-relaxed hidden">
                {!! nl2br(e($aplikasi->deskripsi)) !!}
            </div>
        </div>

        {{-- Fitur Section --}}
        <div class="mb-8 px-6">
            <div class="flex items-center space-x-2 mb-4">
                <h2 class="text-2xl font-bold font-poppins text-gray-800">Fitur</h2>
                <button id="fiturToggleBtn"
                        type="button"
                        class="transition-transform duration-300 transform text-gray-800 hover:text-red-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
            <div id="fiturShort" class="text-gray-700 font-poppins leading-relaxed">
                {!! \Illuminate\Support\Str::words(strip_tags($aplikasi->fitur), 50, '...') !!}
            </div>
            <div id="fiturFull" class="text-gray-700 font-poppins leading-relaxed hidden">
                {!! nl2br(e($aplikasi->fitur)) !!}
            </div>
        </div>

        {{-- Additional Info Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 font-poppins text-sm mb-8 px-6">
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
                <p>{{ $aplikasi->rating_konten }}+ : {{ $aplikasi->rating_konten_deskripsi ?? 'Kekerasan tingkat menengah' }} </p>
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

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Carousel functionality
        const carousel = document.getElementById('gallery-carousel');
        const carouselImages = carousel.querySelectorAll('img');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        let currentIndex = 0;

        function updateCarousel() {
            if (carouselImages.length > 0) {
                const itemWidth = carouselImages[0].offsetWidth;
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
        updateCarousel();

        // Functionality for Deskripsi and Fitur toggles
        const deskripsiToggleBtn = document.getElementById('deskripsiToggleBtn');
        const deskripsiShort = document.getElementById('deskripsiShort');
        const deskripsiFull = document.getElementById('deskripsiFull');
        const deskripsiSvg = deskripsiToggleBtn ? deskripsiToggleBtn.querySelector('svg') : null;

        const fiturToggleBtn = document.getElementById('fiturToggleBtn');
        const fiturShort = document.getElementById('fiturShort');
        const fiturFull = document.getElementById('fiturFull');
        const fiturSvg = fiturToggleBtn ? fiturToggleBtn.querySelector('svg') : null;

        // Function to toggle content visibility
        function toggleContent(shortEl, fullEl, svgEl) {
            if (fullEl.classList.contains('hidden')) {
                // Show full content
                shortEl.classList.add('hidden');
                fullEl.classList.remove('hidden');
                if (svgEl) {
                    svgEl.classList.add('rotate-90');
                }
            } else {
                // Show short content
                fullEl.classList.add('hidden');
                shortEl.classList.remove('hidden');
                if (svgEl) {
                    svgEl.classList.remove('rotate-90');
                }
            }
        }

        if (deskripsiToggleBtn) {
            deskripsiToggleBtn.addEventListener('click', () => {
                toggleContent(deskripsiShort, deskripsiFull, deskripsiSvg);
            });
        }

        if (fiturToggleBtn) {
            fiturToggleBtn.addEventListener('click', () => {
                toggleContent(fiturShort, fiturFull, fiturSvg);
            });
        }

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
            event.stopPropagation();
            currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
            updateModalImage();
        });

        modalNextBtn.addEventListener('click', (event) => {
            event.stopPropagation();
            currentIndex = (currentIndex + 1) % carouselImages.length;
            updateModalImage();
        });
    });
</script>
@endsection