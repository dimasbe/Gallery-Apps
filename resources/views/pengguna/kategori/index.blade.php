@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
    {{-- Konten Utama --}}
    <div class="flex flex-col">
        {{-- Pencarian --}}
        {{-- Form Pencarian --}}
        <div class="self-end relative max-w-lg flex items-center mb-6">
            <input type="text" id="searchInput" placeholder="Cari di sini..."
                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins">
            {{-- Tambahkan ID ke tombol pencarian --}}
            <button id="searchButton" class="absolute mr-1 right-0 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                </svg>
            </button>
        </div>

        {{-- Semua Kategori --}}
        <div>
            <div class="title flex gap-2">
                <a href="{{ url()->current() }}" class="font-semibold text-lg mb-4 cursor-pointer hover:underline">
                    Semua Kategori
                </a>
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24">
                    <g fill="none" stroke="#AD1500" stroke-linecap="round" stroke-linejoin="round" stroke-width="2">
                        <circle cx="17" cy="7" r="3" />
                        <circle cx="7" cy="17" r="3" />
                        <path d="M14 14h6v5a1 1 0 0 1-1 1h-4a1 1 0 0 1-1-1zM4 4h6v5a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1z" />
                    </g>
                </svg>
            </div>

            <div id="category-group" class="grid grid-cols-3 gap-2 overflow-hidden transition-all duration-300"
                style="max-height: 10rem;">
                @foreach ($aplikasiKategoris as $kategori)
                    <a href="{{ route('kategori.show', ['kategori' => $kategori->nama_kategori]) }}"
                        class="category-item bg-gray-100 text-center p-5 rounded-md hover:bg-gray-300">
                        {{ $kategori->nama_kategori }}
                    </a>
                @endforeach
            </div>

            {{-- Message for no search results --}}
            <div id="noResultsMessage" class="text-center text-gray-400 mt-4 hidden">
                Pencarian tidak tersedia.
            </div>

            <div class="relative mt-5 border-t-2 border-gray mb-10">
                <button id="toggle-button"
                    class="absolute left-1/2 -translate-x-1/2 -top-3 bg-white px-3 text-sm font-semibold hover:underline focus:outline-none">
                    Tampilkan Semua
                </button>
            </div>

        </div>
    </div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
    const categoryGroup = document.getElementById('category-group');
    const toggleButton = document.getElementById('toggle-button');
    const searchInput = document.getElementById('searchInput');
    const searchButton = document.getElementById('searchButton');
    const noResultsMessage = document.getElementById('noResultsMessage');
    const categoryItems = Array.from(document.querySelectorAll('.category-item'));

    let expanded = false;
    const initialMaxHeight = '10rem'; // Store the initial max-height as a string

    // Function to set the initial state of the category group and toggle button
    function initializeCategoryDisplay() {
        if (!expanded) {
            categoryGroup.style.maxHeight = initialMaxHeight;
            toggleButton.textContent = 'Tampilkan Semua';
        } else {
            // If already expanded, ensure it retains its expanded height
            categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px';
            toggleButton.textContent = 'Sembunyikan';
        }
        // Only show the toggle button if there are more items than fit in initialMaxHeight
        toggleButton.classList.toggle('hidden', categoryGroup.scrollHeight <= parseFloat(initialMaxHeight) * 16); // Convert rem to px (1rem = 16px default)
    }

    function filterCategories() {
        const searchTerm = searchInput.value.toLowerCase().trim();
        let foundResults = false;
        let visibleItemsCount = 0;

        categoryItems.forEach(item => {
            const categoryName = item.textContent.toLowerCase();
            if (categoryName.includes(searchTerm)) {
                item.style.display = ''; // Show item
                foundResults = true;
                visibleItemsCount++;
            } else {
                item.style.display = 'none'; // Hide item
            }
        });

        if (!foundResults && searchTerm.length > 0) {
            noResultsMessage.classList.remove('hidden'); // Show 'no results' message
        } else {
            noResultsMessage.classList.add('hidden'); // Hide 'no results' message
        }

        // Adjust toggle button visibility and category group height based on search
        if (searchTerm.length === 0) {
            // When search is empty, reset to initial display logic
            initializeCategoryDisplay();
        } else {
            // When searching, always show all filtered results and hide the toggle button
            categoryGroup.style.maxHeight = 'none'; // Allow content to dictate height
            toggleButton.classList.add('hidden'); // Hide toggle button during search
            expanded = true; // Treat as expanded so toggle button shows "Sembunyikan" if it reappears
        }
    }

    // Event listeners
    searchInput.addEventListener('input', filterCategories);
    searchButton.addEventListener('click', filterCategories); // Keep for explicit button click

    toggleButton.addEventListener('click', () => {
        if (expanded) {
            categoryGroup.style.maxHeight = initialMaxHeight;
            toggleButton.textContent = 'Tampilkan Semua';
        } else {
            categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px';
            toggleButton.textContent = 'Sembunyikan';
        }
        expanded = !expanded;
    });

    // Initial setup on page load
    initializeCategoryDisplay(); // Set the initial state
    filterCategories(); // Apply filter in case search input has pre-filled value
});
</script>
@endsection