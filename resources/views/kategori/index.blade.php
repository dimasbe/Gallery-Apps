@extends('layouts.app');

@section('content')
    {{-- Konten Utama --}}
    <div class="flex flex-col">
        {{-- Pencarian --}}
        {{-- Form Pencarian --}}
        <div class="self-end relative max-w-lg flex items-center">
            <input type="text" placeholder="Cari di sini..."
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
                <h2 class="font-semibold text-lg mb-4">
                    Semua Kategori
                </h2>
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
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Permainan</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Belanja</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Pendidikan</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Olahraga</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Fashion</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Kesehatan</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Teknologi</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Kuliner</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Travel</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Fotografi</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Musik</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Finansial</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Bisnis</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Hobi</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Kecantikan</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Lingkungan</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Games</a>
                <a href="" class="bg-gray-200 text-center p-2 rounded-md hover:bg-gray-300">Komunitas</a>
            </div>
            <div class="relative mt-5 border-t-2 border-black mb-10">
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
    document.addEventListener('DOMContentLoaded', function () {
        const categoryGroup = document.getElementById('category-group');
        const toggleButton = document.getElementById('toggle-button');
        let expanded = false;

        toggleButton.addEventListener('click', () => {
            console.log('click')
            if (expanded) {
                categoryGroup.style.maxHeight = '10rem'; // collapse
                toggleButton.textContent = 'Tampilkan Semua';
            } else {
                categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px'; // expand
                toggleButton.textContent = 'Sembunyikan';
            }
            expanded = !expanded;
        });
    });
</script>