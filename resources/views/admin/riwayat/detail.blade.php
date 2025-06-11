@extends('layouts.admin')

@section('title', 'Detail Riwayat Aplikasi') {{-- Judul halaman tetap relevan dengan riwayat --}}

@section('content')
<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
    {{-- Header dan Breadcrumbs --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Detail Aplikasi</h1> {{-- Ubah dari "Detail" saja --}}
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-red-700">Beranda</a>
                        <span class="mx-2 text-red-700 text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.riwayat.index') }}" class="hover:text-red-700">Riwayat</a> {{-- Sesuaikan rute jika berbeda --}}
                        <span class="mx-2 text-red-700 text-base">&bull;</span>
                    </li>
                    <li class="text-red-700" aria-current="page">Detail</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">

        {{-- Header: Kembali Button --}}
        <div class="mb-6">
            <a href="{{ route('admin.riwayat.index') }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>
        
        {{-- Display Rejected Status --}} 
        @if($aplikasi->status_verifikasi === \App\Enums\StatusTypeEnum::DITOLAK->value && $aplikasi->alasan_penolakan) 
        <div class="bg-red-50 border-l-4 border-red-500 text-red-800 p-4 rounded-lg shadow-md flex items-center transform transition duration-300 hover:scale-[1.01] mb-6"> 
            <svg class="h-6 w-6 text-red-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /> 
            </svg> 
            <div> 
                <h3 class="font-bold text-red-900 mb-1">Catatan Ditolak:</h3> 
                <p class="text-sm">{{ $aplikasi->alasan_penolakan }}</p> 
            </div> 
        </div> 
        @endif 
            
        {{-- Display Accepted Status (NEW ADDITION) --}} 
        @if($aplikasi->status_verifikasi === \App\Enums\StatusTypeEnum::DITERIMA->value) 
        <div class="bg-green-50 border-l-4 border-green-500 text-green-800 p-4 rounded-lg shadow-md flex items-center transform transition duration-300 hover:scale-[1.01] mb-6"> 
            <svg class="h-6 w-6 text-green-600 mr-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"> 
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /> 
            </svg> 
            <div> 
                <h3 class="font-bold text-green-900 mb-1">Terima</h3> 
                <p class="text-sm">Aplikasi ini telah "diterima".</p> 
            </div> 
        </div> 
        @endif

        {{-- NEW FLEX CONTAINER for App Info + Carousel --}}
        <div class="flex flex-col md:flex-row md:space-x-8 mb-8 px-6">
            {{-- Left Column: App Title, Info, Google Play Button --}}
            <div class="flex-1 md:w-1/2">
                <h1 class="text-3xl font-bold font-poppins text-gray-800 mb-1">{{ $aplikasi->nama_aplikasi }}</h1>
                <p class="text-gray-600 text-sm font-poppins mb-4">
                    {{ $aplikasi->user->name ?? $aplikasi->nama_pemilik ?? 'N/A' }}
                </p>

                <div class="flex items-center space-x-4 mb-6">
                    <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="{{ $aplikasi->nama_aplikasi }} Logo" class="w-20 h-20 rounded-xl shadow-md flex-shrink-0 object-contain">
                    <div class="flex items-center space-x-4">
                    </div>
                </div>

                {{-- Google Play Button --}}
                @if($aplikasi->tautan_aplikasi)
                <a href="{{ $aplikasi->tautan_aplikasi }}" target="_blank"
                   class="inline-flex items-center px-4 py-3 rounded-lg bg-white border border-gray-300 shadow-sm
                                 hover:shadow-md hover:border-gray-400 transition-all duration-200 space-x-3">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/d/d0/Google_Play_Arrow_logo.svg"
                                 alt="Google Play Icon Only"
                                 class="h-7 w-7">
                    <span class="text-sm text-gray-800 font-poppins">
                        Dapatkan di <br>
                        <strong class="font-bold">Google Play</strong>
                    </span>
                </a>
                @endif
            </div>

            {{-- Right Column: Image Gallery (Carousel) --}}
            <div class="flex-1 md:w-1/2 relative overflow-hidden rounded-lg shadow-md mt-8 md:mt-0">
                <div id="gallery-carousel" class="flex transition-transform duration-300 ease-in-out" style="transform: translateX(0);">
                    @forelse($aplikasi->fotoAplikasi as $index => $foto)
                        <img src="{{ asset('storage/' . $foto->path_foto) }}" alt="Screenshot {{ $index + 1 }}" class="w-full flex-shrink-0 object-cover rounded-lg cursor-pointer" style="max-height: 300px;" data-index="{{ $index }}">
                    @empty
                        <p class="text-gray-500 text-center py-4 w-full">Tidak ada tangkapan layar yang tersedia.</p>
                    @endforelse
                </div>

                @if($aplikasi->fotoAplikasi->count() > 1) {{-- Hanya tampilkan tombol jika ada lebih dari 1 gambar --}}
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
        <div class="mb-8 px-6"> {{-- Tambahkan kembali px-6 untuk konsistensi --}}
            <h2 class="text-2xl font-bold font-poppins text-gray-800 mb-4">Deskripsi</h2>
            <div id="description-content" class="text-gray-700 font-poppins leading-relaxed overflow-hidden transition-all duration-300 ease-in-out" style="max-height: 120px;">
                <p>{{ $aplikasi->deskripsi }}</p>
                @if($aplikasi->fitur) {{-- Hanya tampilkan bagian fitur jika ada data fitur --}}
                    <p class="mt-4">Fitur Utama:</p>
                    {{-- Asumsi fitur adalah teks biasa. Jika berupa list, mungkin perlu di-parse --}}
                    <p>{{ $aplikasi->fitur }}</p>
                @endif
            </div>
            <button id="read-more-btn" class="mt-4 text-red-600 hover:text-red-700 font-semibold font-poppins focus:outline-none">Baca Selengkapnya</button>
        </div>

        {{-- Additional Info Section --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 text-gray-700 font-poppins text-sm mb-8 px-6"> {{-- Tambahkan kembali px-6 --}}
            <div>
                <p class="font-semibold">Dirilis Tanggal</p>
                <p>{{ \Carbon\Carbon::parse($aplikasi->tanggal_rilis)->format('d F Y') }}</p>
            </div>
            <div>
                <p class="font-semibold">Diupdate Pada</p>
                <p>{{ $aplikasi->tanggal_update ? \Carbon\Carbon::parse($aplikasi->tanggal_update)->format('d F Y') : '-' }}</p>
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

        {{-- Admin Action Buttons (Jika masih dibutuhkan di halaman riwayat) --}}
        {{-- Jika ini halaman "Riwayat", kemungkinan tombol aksi seperti Verifikasi/Tolak
             sudah tidak relevan karena aplikasi sudah diverifikasi.
             Namun, tombol Arsip/Unarchive mungkin masih relevan untuk pengelolaan.
             Saya akan mengembalikan bagian ini sesuai permintaan awal, dengan penyesuaian jika statusnya sudah tidak PENDING. --}}

        @if($aplikasi->status_verifikasi === \App\Enums\StatusTypeEnum::PENDING->value)
        <div class="bg-white shadow-xl rounded-2xl p-6 sm:p-8 flex flex-col sm:flex-row items-center justify-between gap-4 transform transition duration-300 hover:scale-[1.01]">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 sm:mb-0">Aksi Verifikasi</h2>
            <div class="flex flex-wrap gap-4 justify-center sm:justify-end">
                <form action="{{ route('admin.riwayat.verify', $aplikasi->id) }}" method="POST" class="w-full sm:w-auto">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="diterima">
                    <button type="submit" class="w-full px-8 py-3 bg-green-600 text-white font-semibold rounded-lg shadow-md hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-opacity-75 transition duration-200 ease-in-out">
                        Verifikasi Aplikasi
                    </button>
                </form>
                <button type="button" onclick="showRejectModal()" class="w-full sm:w-auto px-8 py-3 bg-red-600 text-white font-semibold rounded-lg shadow-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition duration-200 ease-in-out">
                    Tolak Aplikasi
                </button>
            </div>
        </div>

        {{-- Reject Modal --}}
        <div id="rejectModal" class="fixed inset-0 bg-gray-600 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-xl p-8 w-full max-w-md shadow-2xl animate-fade-in-up">
                <h3 class="text-2xl font-bold mb-6 text-red-700 text-center">Tolak Aplikasi</h3>
                <form action="{{ route('admin.riwayat.reject', $aplikasi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="status" value="ditolak">
                    <div class="mb-6">
                        <label for="alasan_penolakan" class="block text-gray-700 text-base font-semibold mb-2">Alasan Penolakan:</label>
                        <textarea id="alasan_penolakan" name="alasan_penolakan" rows="5" class="shadow-sm appearance-none border border-gray-300 rounded-lg w-full py-3 px-4 text-gray-700 leading-tight focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-transparent resize-none" placeholder="Masukkan alasan penolakan aplikasi..." required></textarea>
                    </div>
                    <div class="flex justify-end gap-4">
                        <button type="button" onclick="hideRejectModal()" class="px-6 py-2.5 bg-gray-300 text-gray-800 font-semibold rounded-lg hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 transition duration-200 ease-in-out">Batal</button>
                        <button type="submit" class="px-6 py-2.5 bg-red-600 text-white font-semibold rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-75 transition duration-200 ease-in-out">Tolak</button>
                    </div>
                </form>
            </div>
        </div>
        @elseif($aplikasi->status_verifikasi === \App\Enums\StatusTypeEnum::DITOLAK->value && $aplikasi->alasan_penolakan)
        @endif
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

{{-- Inline CSS for custom scrollbar and animations --}}
<style>
    .hide-scrollbar::-webkit-scrollbar {
        display: none; /* For Chrome, Safari, and Opera */
    }
    .hide-scrollbar {
        -ms-overflow-style: none; /* For Internet Explorer and Edge */
        scrollbar-width: none; /* For Firefox */
    }
    @keyframes fadeInFromTop {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .animate-fade-in-up {
        animation: fadeInFromTop 0.3s ease-out forwards;
    }
</style>

{{-- Inline JavaScript for carousel and modal --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Carousel functionality
        const carousel = document.getElementById('gallery-carousel');
        const carouselImages = carousel.querySelectorAll('img');
        const prevBtn = document.getElementById('prev-btn');
        const nextBtn = document.getElementById('next-btn');
        let currentIndex = 0;

        function updateCarousel() {
            if (carouselImages.length === 0) return; // Prevent error if no images
            const itemWidth = carouselImages[0].offsetWidth; // Get width of first image
            carousel.style.transform = `translateX(-${currentIndex * itemWidth}px)`;
        }

        if (prevBtn && nextBtn) { // Only add event listeners if buttons exist
            prevBtn.addEventListener('click', () => {
                currentIndex = (currentIndex - 1 + carouselImages.length) % carouselImages.length;
                updateCarousel();
            });

            nextBtn.addEventListener('click', () => {
                currentIndex = (currentIndex + 1) % carouselImages.length;
                updateCarousel();
            });
        }


        window.addEventListener('resize', updateCarousel);
        updateCarousel(); // Initial call to set correct position on load

        // Read More functionality for Description
        const descriptionContent = document.getElementById('description-content');
        const readMoreBtn = document.getElementById('read-more-btn');
        const initialDescriptionHeight = 120; // Corresponds to approx 4 lines of text

        // Check if content overflows and adjust button visibility
        function checkOverflow() {
            // Temporarily set height to auto to get full scrollHeight
            descriptionContent.style.maxHeight = 'none';
            const isOverflowing = descriptionContent.scrollHeight > initialDescriptionHeight;
            descriptionContent.style.maxHeight = isOverflowing ? `${initialDescriptionHeight}px` : 'none';
            readMoreBtn.style.display = isOverflowing ? 'block' : 'none';
            readMoreBtn.textContent = 'Baca Selengkapnya';
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

        // Initial check and re-check on window resize
        window.addEventListener('resize', checkOverflow);
        checkOverflow();


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
            if (carouselImages.length > 0) {
                modalImage.src = carouselImages[currentIndex].src;
            }
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

        // For Reject Modal (if still used)
        window.showRejectModal = function() {
            document.getElementById('rejectModal').classList.remove('hidden');
        }

        window.hideRejectModal = function() {
            document.getElementById('rejectModal').classList.add('hidden');
        }
    });
</script>
@endsection