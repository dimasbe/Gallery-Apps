@extends('layouts.app')

@section('content')
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
                    <a href="{{ route('kategori.show', ['nama_kategori' => $kategori->nama_kategori]) }}"
                        class="category-item bg-gray-100 text-center p-2 rounded-md hover:bg-gray-300">
                        {{ $kategori->nama_kategori }}
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
@endsection {{-- Penutup section content --}}

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const categoryGroup = document.getElementById('category-group');
        const toggleButton = document.getElementById('toggle-button');
        const searchInput = document.getElementById('searchInput');
        const searchButton = document.getElementById('searchButton');
        const noResultsMessage = document.getElementById('noResultsMessage');
        const categoryItems = Array.from(document.querySelectorAll('.category-item'));

        let expanded = false;
        const initialMaxHeight = '10rem';

        function filterCategories() {
            const searchTerm = searchInput.value.toLowerCase().trim();
            let foundResults = false;

            categoryItems.forEach(item => {
                const categoryName = item.textContent.toLowerCase();
                if (categoryName.includes(searchTerm)) {
                    item.style.display = '';
                    foundResults = true;
                } else {
                    item.style.display = 'none';
                }
            });

            if (!foundResults && searchTerm.length > 0) {
                noResultsMessage.classList.remove('hidden');
            } else {
                noResultsMessage.classList.add('hidden');
            }

            // Atur ulang tampilan kategori dan tombol toggle saat search term kosong
            if (searchTerm.length === 0) { // Hanya jika search term kosong
                noResultsMessage.classList.add('hidden'); // Sembunyikan pesan no results
                // Tampilkan semua item kategori jika search term kosong
                categoryItems.forEach(item => {
                    item.style.display = '';
                });

                toggleButton.classList.remove('hidden'); // Tampilkan kembali tombol toggle
                if (!expanded) {
                    categoryGroup.style.maxHeight = initialMaxHeight; // Kembali ke max-height awal jika tidak diperluas
                    toggleButton.textContent = 'Tampilkan Semua'; // Reset teks tombol
                } else {
                    categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px'; // Sesuaikan tinggi jika sedang expanded
                    toggleButton.textContent = 'Sembunyikan'; // Reset teks tombol
                }
            } else { // Jika ada search term
                toggleButton.classList.add('hidden'); // Sembunyikan tombol toggle
                categoryGroup.style.maxHeight = 'none'; // Biarkan tinggi menyesuaikan konten
            }
        }

        // HAPUS BARIS INI untuk menonaktifkan filter saat mengetik:
        // searchInput.addEventListener('input', filterCategories);

        // Tambahkan event listener untuk tombol pencarian (Filter hanya saat tombol diklik)
        searchButton.addEventListener('click', filterCategories);

        // Event listener untuk tombol "Tampilkan Semua/Sembunyikan"
        toggleButton.addEventListener('click', () => {
            if (expanded) {
                categoryGroup.style.maxHeight = initialMaxHeight;
                toggleButton.textContent = 'Tampilkan Semua';
            } else {
                categoryItems.forEach(item => {
                    item.style.display = ''; // Pastikan semua item terlihat saat memperluas
                });
                categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px';
                toggleButton.textContent = 'Sembunyikan';
            }
            expanded = !expanded;
        });

        // Panggil filterCategories saat halaman dimuat untuk inisialisasi awal.
        // Ini memastikan bahwa jika ada teks di input dari refresh atau riwayat browser,
        // filter akan diterapkan, atau semua kategori ditampilkan jika input kosong.
        filterCategories();
    });
</script>
@endpush