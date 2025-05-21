@extends('layouts.app')

@section('content')
<section class="w-full flex items-start justify-center pt-4 md:pt-6 pb-6 md:pb-10 px-4">
    <div class="max-w-7xl w-full">

        {{-- Header: Form Pencarian di kanan atas, judul di kiri bawah --}}
        <div class="mb-4">
            <div class="flex justify-end mb-2">
                {{-- Form Pencarian --}}
                <form action="{{ route('search') }}" method="GET" class="ml-auto">
                    <div class="relative max-w-md">
                        <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari di sini..."
                            class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins">
                        <button type="submit"
                            class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                            </svg>
                        </button>
                    </div>
                </form>
            </div>

            {{-- Judul Halaman --}}
            <h2 class="text-2xl md:text-3xl font-bold font-poppins text-[#1b1b18] dark:text-white">
                Hasil Pencarian
            </h2>
        </div>

        {{-- Info Kata Kunci --}}
        @if(request()->has('q') && request()->q != '')
            <p class="text-sm text-gray-500 mb-4 font-poppins">
                Menampilkan hasil untuk: <span class="font-semibold text-[#AD1500]">"{{ request()->q }}"</span>
            </p>
        @endif

        {{-- Grid Hasil --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
            @for($i = 1; $i <= 6; $i++)
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/township.png') }}" alt="Township"
                        class="w-full h-32 object-cover rounded-t-xl">

                    <div class="pt-4 flex items-start space-x-3">
                        <img src="{{ asset('images/township.png') }}" alt="Icon Township"
                            class="w-10 h-10 rounded-md object-cover">

                        <div>
                            <h3 class="font-semibold text-gray-800 text-sm mb-1 font-poppins">
                                Nama Aplikasi {{ $i }}
                            </h3>
                            <p class="text-gray-600 text-xs font-poppins">Developer App {{ $i }}</p>

                            <div class="flex items-center mt-2">
                                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                                    <path
                                        d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z" />
                                </svg>
                                <span class="text-gray-700 text-xs">4.7</span>
                            </div>
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        {{-- Pesan jika kosong (aktifkan nanti jika ada data dari controller) --}}
        {{-- 
        <p class="text-center text-gray-400 mt-10 font-poppins">
            Tidak ada hasil ditemukan untuk kata kunci tersebut.
        </p>
        --}}
    </div>
</section>
{{-- Footer --}}
<footer class="w-full bg-white mt-20 px-4 py-8">
    <div class="max-w-7xl mx-auto px-2 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Bagian Tentang Aplikasi --}}
            <div class="text-left">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo Galerry Apps"
                        class="w-12 h-12 rounded-full object-cover" />
                </div>
                <p class="text-gray-600 text-sm">
                    Galerry Apps adalah platform gratis untuk berbagai aplikasi buatan pengguna, tempat di mana siapa
                    saja bisa mengunggah, menjelajahi, dan menemukan karya digital dari komunitas kreatif di seluruh
                    Indonesia.
                </p>
            </div>

            {{-- Bagian Alamat --}}
            <div class="text-left">
                <h3 class="font-semibold text-lg text-gray-800 mb-4">Alamat</h3>
                <ul class="text-gray-600 text-sm">
                    <li class="flex items-start mb-2">
                        <img src="/images/iconmaps.png" alt="Lokasi" class="w-5 h-5 mr-2 flex-shrink-0" />
                        <span>Perum Permata Regency 1 Blok 10 no 28<br />Ngijo Karangploso Malang</span>
                    </li>
                    <li class="flex items-center mb-2">
                        <img src="/images/icon_email.png" alt="Email" class="w-5 h-5 mr-2 flex-shrink-0" />
                        <span>galerryapps@gmail.com</span>
                    </li>
                    <li class="flex items-center">
                        <img src="/images/icon_telepon.png" alt="Telepon" class="w-5 h-5 mr-2 flex-shrink-0" />
                        <span>(+62) 82132560566</span>
                    </li>
                </ul>
            </div>

            {{-- Bagian Sosial Media --}}
            <div class="text-left">
                <h3 class="font-semibold text-lg text-gray-800 mb-4"></h3>
                <div class="flex space-x-4">
                    <a href="#" class="text-[#AD1500] hover:opacity-80" aria-label="Facebook">
                        <img src="/images/icon_facebook.png" alt="Facebook" class="w-6 h-6" />
                    </a>
                    <a href="#" class="text-[#AD1500] hover:opacity-80" aria-label="Twitter">
                        <img src="/images/icon_twitter.png" alt="Twitter" class="w-6 h-6" />
                    </a>
                    <a href="#" class="text-[#AD1500] hover:opacity-80" aria-label="Instagram">
                        <img src="/images/icon_instagram.png" alt="Instagram" class="w-6 h-6" />
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Border garis full width + copyright --}}
    <div class="border-t border-gray-200 w-full">
        <div class="max-w-7xl mx-auto px-2 py-2 text-gray-500 text-xs flex justify-between">
            <div>2025 Hummatech All Rights Reserved</div>
            <div>Copyright By GalerryApp</div>
        </div>
    </div>
</footer>
@endsection


