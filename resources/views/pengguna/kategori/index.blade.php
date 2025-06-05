@extends('layouts.app')

@section('content')
    {{-- Konten Utama --}}
    <div class="flex flex-col">
        {{-- Pencarian --}}
        {{-- Form Pencarian --}}
        <div class="self-end relative max-w-lg flex items-center mb-6"> {{-- Added mb-6 for spacing --}}
            <input type="text" id="searchInput" placeholder="Cari di sini..."
                class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins">
            <button class="absolute mr-1 right-0 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]">
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
                <h2 class="font-semibold text-lg mb-4">Semua Kategori</h2>
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
                    {{-- Pastikan nama rute dan parameter sudah benar --}}
                    <a href="{{ route('kategori.show', ['nama' => $kategori->nama_kategori]) }}"
                        class="category-item bg-gray-100 text-center p-2 rounded-md hover:bg-gray-300">{{ $kategori->nama_kategori }}
                    </a>
                @endforeach
            </div>

            {{-- Message for no search results --}}
            <div id="noResultsMessage" class="text-center text-gray-600 mt-4 hidden">
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

    </footer>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryGroup = document.getElementById('category-group');
        const toggleButton = document.getElementById('toggle-button');
        const searchInput = document.getElementById('searchInput');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const categoryItems = Array.from(document.querySelectorAll('.category-item')); // Get all category links

        let expanded = false;
        const initialMaxHeight = '10rem'; // Store initial max-height

        // Function to update the visibility of categories based on search input
        function filterCategories() {
            const searchTerm = searchInput.value.toLowerCase();
            let foundResults = false;

            categoryItems.forEach(item => {
                const categoryName = item.textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    item.style.display = 'block'; // Show the item
                    foundResults = true;
                } else {
                    item.style.display = 'none'; // Hide the item
                }
            });

            // Show/hide no results message
            if (!foundResults && searchTerm.length > 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }

            // Adjust toggle button and max-height based on search
            if (searchTerm.length > 0) {
                toggleButton.classList.add('hidden'); // Hide toggle button during search
                categoryGroup.style.maxHeight = 'none'; // Show all filtered results
            } else {
                toggleButton.classList.remove('hidden'); // Show toggle button when search is clear
                // Reset max-height and expanded state when search is cleared
                categoryGroup.style.maxHeight = initialMaxHeight;
                toggleButton.textContent = 'Tampilkan Semua';
                expanded = false;
            }
        }

        // Event listener for search input
        searchInput.addEventListener('input', filterCategories);

        // Event listener for the "Tampilkan Semua/Sembunyikan" button
        toggleButton.addEventListener('click', () => {
            if (expanded) {
                categoryGroup.style.maxHeight = initialMaxHeight; // collapse
                toggleButton.textContent = 'Tampilkan Semua';
            } else {
                categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px'; // expand
                toggleButton.textContent = 'Sembunyikan';
            }
            expanded = !expanded;
        });
    });
</script>