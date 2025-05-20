@extends('layouts.app')

@section('content')
{{-- Landing Page --}}
<section class="w-full flex items-start justify-center p-6 md:p-0 m-0">
<div class="max-w-7xl w-full px-3 py-2 grid grid-cols-1 md:grid-cols-2 gap-10 items-center">
        {{-- Text Kiri --}}
        <div>
        <h2 class="text-4xl md:text-4xl font-bold font-poppins text-[#1b1b18] dark:text-white mb-4">
    Selamat Datang di <br>
    <span class="text-[#AD1500]">GalleryApps</span>
</h2>
<p class="text-base md:text-lg text-gray-500 dark:text-gray-200 leading-relaxed mb-4 font-poppins">
            Temukan aplikasi terbaik yang sesuai kebutuhanmu lewat ulasan mendalam,
            fitur unggulan, dan link unduh resmi. <br>
            Semua cepat, spesifik, dan terpercaya di satu platform.
            </p>

            {{-- Form Pencarian --}}
            <div class="relative max-w-md">
                <input type="text" placeholder="Cari di sini..." class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
                    </svg>
                </button>
            </div>
        </div>

        {{-- Gambar Laptop Kanan --}}
        <div class="flex justify-center">
            <img src="{{ asset('images/laptop.png') }}">
        </div>

    </div>
</section>

{{-- Section Kategori --}}
<section class="">
<div class="max-w-7xl mx-auto px-2 mt-10">
        <h2 class="text-2xl md:text-2xl font-semibold text-center text-[#1b1b18] font-poppins mb-2">
            KATEGORI
        </h2>
        <p class="text-center text-gray-500 font-poppins mb-7">
            Temukan Aplikasi yang Anda Inginkan
        </p>
        <div class="mx-auto border-b-2 border-gray-300 w-400 mb-6"></div>
        <div class="mx-auto w-fit grid grid-cols-2 md:grid-cols-3 gap-x-20 gap-y-6">
            {{-- Kategori Item --}}
            <div class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('images/permainan.png') }}"class="w-full h-[200px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded-full mb-2">
                        <img src="{{ asset('images/icon_permainan.png') }}" class="w-6 h-6">
                    </div>
                    <p class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-70 text-white px-20 py-2 rounded-full text-base font-bold font-poppins shadow">
                        Permainan
                    </p>

                </div>
            </div>

            <div class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('images/belanja.png') }}" class="w-full h-[200px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded-full mb-2">
                        <img src="{{ asset('images/icon_belanja.png') }}" class="w-6 h-6">
                    </div>
                    <p class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-70 text-white px-20 py-2 rounded-full text-base font-bold font-poppins shadow">
                        Belanja
                    </p>
                </div>
            </div>

            <div class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('images/pendidikan.png') }}" class="w-full h-[200px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded-full mb-2">
                        <img src="{{ asset('images/icon_pendidikan.png') }}" class="w-6 h-6">
                    </div>
                    <p class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-70 text-white px-20 py-2 rounded-full text-base font-bold font-poppins shadow">
                        Pendidikan
                    </p>
                </div>
            </div>

            <div class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('images/olahraga.png') }}" class="w-full h-[200px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded-full mb-2">
                        <img src="{{ asset('images/icon_olahraga.png') }}" class="w-6 h-6">
                    </div>
                    <p class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-70 text-white px-20 py-2 rounded-full text-base font-bold font-poppins shadow">
                        Olahraga
                    </p>
                </div>
            </div>

            <div class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('images/fashion.png') }}" class="w-full h-[200px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded-full mb-2">
                        <img src="{{ asset('images/icon_fashion.png') }}" class="w-6 h-6">
                    </div>
                    <p class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-70 text-white px-20 py-2 rounded-full text-base font-bold font-poppins shadow">
                        Fashion
                    </p>
                </div>
            </div>

            <div class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md">
                <img src="{{ asset('images/kesehatan.png') }}" class="w-full h-[200px] object-cover">
                <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                    <div class="bg-white p-2 rounded-full mb-2">
                        <img src="{{ asset('images/icon_kesehatan.png') }}" class="w-6 h-6">
                    </div>
                    <p class="absolute bottom-3 left-1/2 transform -translate-x-1/2 bg-white bg-opacity-70 text-white px-20 py-2 rounded-full text-base font-bold font-poppins shadow">
                        Kesehatan
                    </p>
                </div>
            </div>
        </div>

        <div class="text-center mt-12">
    <a href="#" class="inline-block bg-[#AD1500] hover:bg-[#8F1000] text-white px-4 py-2 rounded-full font-poppins shadow-md transition text-ms">
        Lihat semua kategori
    </a>
</div>

    </div>
</section>

{{-- Section Aplikasi Terpopuler --}}
<section class="mt-20">
  <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
    <div class="col-span-1 bg-gray-100 border border-[#D9D9D9] rounded-xl p-6 flex flex-col justify-center h-full min-h-[300px] shadow-xl">
        <div class="text-center">
          <h2 class="text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4">
            Aplikasi Terpopuler
          </h2>
          <p class="text-gray-500 font-poppins">
            Jelajahi berbagai aplikasi terpopuler yang paling sering dicari dan digunakan oleh pengguna lainnya di sini!
          </p>
          <a href="#" class="mt-3 inline-block bg-[#AD1500] hover:bg-[#8F1000] text-white px-3 py-2 rounded-full font-poppins shadow-md transition text-ms">
            Lihat semua aplikasi
          </a>
        </div>
      </div>
            <div class="col-span-1 lg:col-span-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                {{-- Item 1 --}}
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/township.png') }}" alt="Township" class="w-full h-32 object-cover rounded-t-xl">
                     <div class="pt-4 flex items-start space-x-3">
                    <img src="{{ asset('images/icon_township.png') }}" alt="Icon Township" class="w-10 h-10 rounded-md object-cover">
            <div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Township</h3>
            <p class="text-gray-600 text-xs">Playrix</p>
            <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z"/>
                </svg>
                <span class="text-gray-700 text-xs">4.7</span>
            </div>
        </div>
    </div>
</div>

                {{-- Item 2 --}}
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/mobilelegends.png') }}" alt="Township" class="w-full h-32 object-cover rounded-t-xl">
                     <div class="pt-4 flex items-start space-x-3">
                    <img src="{{ asset('images/icon_ml.png') }}" alt="Icon Township" class="w-10 h-10 rounded-md object-cover">
            <div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Mobile Legends</h3>
            <p class="text-gray-600 text-xs">Playrix</p>
            <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z"/>
                </svg>
                <span class="text-gray-700 text-xs">4.7</span>
            </div>
        </div>
    </div>
</div>

                {{-- Item 3 --}}
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/tokopedia.png') }}" alt="Township" class="w-full h-32 object-cover rounded-t-xl">
                     <div class="pt-4 flex items-start space-x-3">
                    <img src="{{ asset('images/icon_tokopedia.png') }}" alt="Icon Township" class="w-10 h-10 rounded-md object-cover">
            <div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Tokopedia</h3>
            <p class="text-gray-600 text-xs">Playrix</p>
            <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z"/>
                </svg>
                <span class="text-gray-700 text-xs">4.7</span>
            </div>
        </div>
    </div>
</div>

                {{-- Item 4 --}}
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/ruangguru.png') }}" alt="Township" class="w-full h-32 object-cover rounded-t-xl">
                     <div class="pt-4 flex items-start space-x-3">
                    <img src="{{ asset('images/icon_ruangguru.png') }}" alt="Icon Township" class="w-10 h-10 rounded-md object-cover">
            <div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Ruang Guru</h3>
            <p class="text-gray-600 text-xs">Playrix</p>
            <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z"/>
                </svg>
                <span class="text-gray-700 text-xs">4.7</span>
            </div>
        </div>
    </div>
</div>

                {{-- Item 5 --}}
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/ruangguru.png') }}" alt="Township" class="w-full h-32 object-cover rounded-t-xl">
                     <div class="pt-4 flex items-start space-x-3">
                    <img src="{{ asset('images/icon_ruangguru.png') }}" alt="Icon Township" class="w-10 h-10 rounded-md object-cover">
            <div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Ruang Guru</h3>
            <p class="text-gray-600 text-xs">Playrix</p>
            <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z"/>
                </svg>
                <span class="text-gray-700 text-xs">4.7</span>
            </div>
        </div>
    </div>
</div>

                {{-- Item 6 --}}
                <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px]">
                    <img src="{{ asset('images/ruangguru.png') }}" alt="Township" class="w-full h-32 object-cover rounded-t-xl">
                     <div class="pt-4 flex items-start space-x-3">
                    <img src="{{ asset('images/icon_ruangguru.png') }}" alt="Icon Township" class="w-10 h-10 rounded-md object-cover">
            <div>
            <h3 class="font-semibold text-gray-800 text-sm mb-1">Ruang Guru</h3>
            <p class="text-gray-600 text-xs">Playrix</p>
            <div class="flex items-center mt-2">
                <svg class="w-4 h-4 text-yellow-500 fill-current mr-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20">
                    <path d="M10 15l-5.878 3.09 1.176-6.545L.587 7.646l6.545-.952L10 1l2.868 5.694 6.545.952-4.765 4.099 1.176 6.545z"/>
                </svg>
                <span class="text-gray-700 text-xs">4.7</span>
            </div>
        </div>
    </div>
</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Section Berita Terbaru --}}
<section class="mt-20">
    <div class="max-w-7xl mx-auto px-2">
        <h2 class="text-2xl md:text-3xl font-semibold text-center text-[#1b1b18] font-poppins mb-4">
            BERITA
        </h2>
        <p class="text-center text-gray-500 font-poppins mb-4">
            Lihat Berita Terbaru Kami
        </p>
        <div class="mx-auto border-b-2 border-gray-300 w-400 mb-6"></div>
        <div class="relative">
            <div class="flex overflow-x-auto space-x-4 scroll-smooth snap-x snap-mandatory">
                {{-- Berita Item 1 --}}
                <div class="bg-white rounded-xl shadow-md w-80 sm:w-96 flex-shrink-0 snap-start">
                    <img src="{{ asset('images/berita1.png') }}" alt="Update Fitur Upload Baru!" class="w-full h-40 object-cover rounded-t-xl">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Update Fitur Upload Baru!</h3>
                        <p class="text-gray-600 text-sm mb-2">5 Mei 2025</p>
                        <p class="text-gray-700 text-sm mb-3">Kini upload aplikasi jadi lebih cepat dan aman dengan sistem verifikasi terbaru...</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Baca Selengkapnya</a>
                    </div>
                </div>

                {{-- Berita Item 2 --}}
                <div class="bg-white rounded-xl shadow-md w-80 sm:w-96 flex-shrink-0 snap-start">
                    <img src="{{ asset('images/berita3.png') }}" alt="Maintenance Server" class="w-full h-40 object-cover rounded-t-xl">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Maintenance Server</h3>
                        <p class="text-gray-600 text-sm mb-2">5 Mei 2025</p>
                        <p class="text-gray-700 text-sm mb-3">Akan ada perawatan sistem pada pukul 22.00 - 01.00 WIB, mohon persiapkan diri...</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Baca Selengkapnya</a>
                    </div>
                </div>

                {{-- Berita Item 3 --}}
                <div class="bg-white rounded-xl shadow-md w-80 sm:w-96 flex-shrink-0 snap-start">
                    <img src="{{ asset('images/berita2.png') }}" alt="Maintenance Server" class="w-full h-40 object-cover rounded-t-xl">
                    <div class="p-4">
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Maintenance Server</h3>
                        <p class="text-gray-600 text-sm mb-2">5 Mei 2025</p>
                        <p class="text-gray-700 text-sm mb-3">Akan ada perawatan sistem pada pukul 22.00 - 01.00 WIB, mohon persiapkan diri...</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Baca Selengkapnya</a>
                    </div>
                </div>

                {{-- Tambahkan lebih banyak item berita di sini jika ada --}}
            </div>
            <div class="absolute top-1/2 -left-14 transform -translate-y-1/2 cursor-pointer">
                <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </div>
            <div class="absolute top-1/2 -right-14 transform -translate-y-1/2 cursor-pointer">
                <svg class="w-6 h-6 text-gray-500 hover:text-gray-700" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
            </div>
        </div>
        <div class="flex justify-center mt-4">
            <span class="inline-block w-3 h-3 bg-gray-300 rounded-full mx-1 cursor-pointer hover:bg-gray-500"></span>
            <span class="inline-block w-3 h-3 bg-gray-500 rounded-full mx-1 cursor-pointer hover:bg-gray-700"></span>
            <span class="inline-block w-3 h-3 bg-gray-300 rounded-full mx-1 cursor-pointer hover:bg-gray-500"></span>
            {{-- Tambahkan lebih banyak span sesuai jumlah item berita --}}
        </div>
    </div>
</section>

{{-- Footer --}}
<footer class="w-full bg-white mt-20 px-4 py-8">
    <div class="max-w-7xl mx-auto px-2 py-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Bagian Tentang Aplikasi --}}
            <div class="text-left">
                <div class="flex items-center mb-4">
                    <img src="{{ asset('images/logo2.png') }}" alt="Logo Galerry Apps" class="w-12 h-12 rounded-full object-cover" />
                </div>
                <p class="text-gray-600 text-sm">
                    Galerry Apps adalah platform gratis untuk berbagai aplikasi buatan pengguna, tempat di mana siapa saja bisa mengunggah, menjelajahi, dan menemukan karya digital dari komunitas kreatif di seluruh Indonesia.
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

    {{-- Border garis full width + copyright yang lebih pendek --}}
    <div class="border-t border-gray-200 w-full">
        <div class="max-w-7xl mx-auto px-2 py-2 text-gray-500 text-xs flex justify-between">
            <div>2025 Hummatech All Rights Reserved</div>
            <div>Copyright By GalerryApp</div>
        </div>
    </div>
</footer>

@endsection
