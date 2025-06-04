@extends('layouts.app')

@section('content')
    {{-- Konten Utama --}}
    <div class="flex flex-col">
        {{-- Search Form --}}
        <form action="{{ route('kategori.index') }}" method="GET" class="mb-10 flex justify-end gap-2">
            <div class="relative w-full max-w-lg">
                <input type="text" name="search" placeholder="Cari kategori..."
                    class="w-full py-3 px-6 pr-16 bg-white bg-opacity-25 backdrop-filter backdrop-blur-lg border border-opacity-20 border-white text-gray-800 placeholder-gray-600 rounded-xl shadow-lg focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-opacity-70 transition-all duration-300 ease-in-out text-lg" {{-- Changed focus:ring-blue-400 to focus:ring-red-700 --}}
                    value="{{ request('search') }}">
                <button type="submit"
                        class="absolute right-2 top-1/2 -translate-y-1/2 p-3 bg-red-700 hover:bg-red-600 text-white rounded-lg shadow-md focus:outline-none focus:ring-2 focus:ring-red-700 focus:ring-offset-2 focus:ring-offset-white focus:ring-offset-opacity-70 transition-all duration-200 ease-in-out"> {{-- Ensure button focus ring is also red-700 --}}
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </form>
        {{-- End Search Form --}}

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

            {{-- Status Pencarian --}}
            @if ($search && !$search_found)
                <div class="bg-gray-100 text-center p-6 rounded-md hover:bg-gray-300" role="alert">
                    <p class="font-bold">Pencarian Tidak Ditemukan</p>
                    <p>Maaf, kategori dengan kata kunci "<strong>{{ $search }}</strong>" tidak ditemukan.</p>
                </div>
            @endif
            {{-- End Status Pencarian --}}

            <div id="category-group" class="grid grid-cols-3 gap-2 overflow-hidden transition-all duration-300"
                style="max-height: 10rem;">
                {{-- Loop through the categories passed from the controller --}}
                @foreach ($categories as $category)
                    <a href="{{ route('kategori.show', ['slug' => Str::slug($category->nama_kategori)]) }}"
                        class="bg-gray-100 text-center p-2 rounded-md hover:bg-gray-300">
                        {{ $category->nama_kategori }}
                    </a>
                @endforeach
            </div>
            <div class="relative mt-5 border-t-2 border-gray mb-10 gap-8">
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
        let expanded = false;

        toggleButton.addEventListener('click', () => {
            console.log('click'); // For debugging
            if (expanded) {
                categoryGroup.style.maxHeight = '10rem'; // collapse to initial height
                toggleButton.textContent = 'Tampilkan Semua';
            } else {
                categoryGroup.style.maxHeight = categoryGroup.scrollHeight + 'px'; // expand to full height
                toggleButton.textContent = 'Sembunyikan';
            }
            expanded = !expanded;
        });
    });
</script>