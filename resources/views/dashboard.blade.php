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
        <form action="{{ route('search') }}" method="GET" class="relative max-w-md">
            <input
            type="text"
            name="q"
            placeholder="Cari di sini..."
            value="{{ request('q') }}"
            class="w-full pl-4 pr-10 py-2 border border-gray-300 rounded-full shadow-sm focus:outline-none focus:border-[#E0E6EA] text-sm text-gray-800 font-poppins"
            autocomplete="off"
            >
            <button type="submit" class="absolute right-2 top-1/2 transform -translate-y-1/2 bg-[#AD1500] text-white p-2 rounded-full hover:bg-[#8F1000]" aria-label="Cari">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M16 10a6 6 0 11-12 0 6 6 0 0112 0z" />
            </svg>
            </button>
        </form>
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
            {{-- Mengulang Kategori secara Dinamis --}}
            <div class="mx-auto w-fit grid grid-cols-2 md:grid-cols-3 gap-x-20 gap-y-6">
                @forelse ($kategoriAplikasi as $kategori)
                <a href="{{ route('kategori.show', ['nama_kategori' => $kategori->nama_kategori]) }}" class="w-[300px] mx-auto relative rounded-xl overflow-hidden shadow-md group">
                    @php
                        // Ambil foto thumbnail dari aplikasi pertama di kategori ini
                        $thumbnailApp = $kategori->aplikasi->first();
                        $categoryImage = '';
                        if ($thumbnailApp && $thumbnailApp->fotoAplikasi->first()) {
                            $categoryImage = asset('storage/' . $thumbnailApp->fotoAplikasi->first()->path_foto);
                        } else {
                            $categoryImage = 'https://placehold.co/300x200/cccccc/333333?text=Kategori'; // Placeholder jika tidak ada aplikasi/foto
                        }
                    @endphp
                    <img src="{{ $categoryImage }}" class="w-full h-[200px] object-cover">
                    <div class="absolute inset-0 bg-black bg-opacity-40 flex flex-col items-center justify-center text-white">
                        {{-- PERUBAHAN DI SINI: Gaya untuk teks kategori agar konsisten dan jelas --}}
                        <p class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-gradient-to-r from-white/90 to-white text-[#1b1b18] w-64 py-2 rounded-full text-base font-bold font-poppins shadow-lg transition-all duration-300 group-hover:from-gray-100 group-hover:to-white group-hover:scale-105 whitespace-nowrap overflow-hidden text-ellipsis text-center">
                            {{ $kategori->nama_kategori }}
                        </p>
                    </div>
                </a>
                @empty
                <div class="col-span-full text-center text-gray-500">
                    Tidak ada kategori aplikasi yang tersedia saat ini.
                </div>
                @endforelse
            </div>

            <div class="text-center mt-12">
                <a href="/kategori"
                    class="inline-block bg-[#AD1500] hover:bg-[#8F1000] text-white px-4 py-2 rounded-full font-poppins shadow-md transition text-ms">
                    Lihat semua kategori
                </a>
            </div>
        </div>
    </section>

    {{-- Section Aplikasi Terpopuler --}}
    <section class="mt-20">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Kolom Kiri: Judul dan Deskripsi --}}
                <div
                    class="col-span-1 bg-gray-100 border border-[#D9D9D9] rounded-xl p-6 flex flex-col justify-center h-full min-h-[300px] shadow-xl">
                    <div class="text-center">
                        <h2 class="text-2xl md:text-3xl font-semibold text-[#1b1b18] font-poppins mb-4">
                            Aplikasi Terpopuler
                        </h2>
                        <p class="text-gray-500 font-poppins">
                            Jelajahi berbagai aplikasi terpopuler yang paling sering dicari dan digunakan oleh pengguna
                            lainnya di sini!
                        </p>
                        {{-- Pastikan rute 'aplikasi.populer' sudah terdefinisi di web.php --}}
                        <a href="{{ route('aplikasi.populer') }}"
                            class="mt-3 inline-block bg-[#AD1500] hover:bg-[#8F1000] text-white px-3 py-2 rounded-full font-poppins shadow-md transition text-ms">
                            Lihat semua aplikasi
                        </a>
                    </div>
                </div>

                {{-- Kolom Kanan: Daftar Aplikasi Terpopuler --}}
                <div class="col-span-1 lg:col-span-3 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                    {{-- Loop melalui aplikasi terpopuler yang diterima dari controller --}}
                    @forelse ($aplikasiPopuler as $aplikasi)
                    {{-- Membungkus seluruh kartu aplikasi dengan tag <a> untuk menjadikannya dapat diklik --}}
                    {{-- Arahkan ke rute detail aplikasi menggunakan ID aplikasi --}}
                    <a href="{{ route('aplikasi.detail', $aplikasi->id) }}" class="block">
                        <div class="bg-gray-100 border border-[#D9D9D9] rounded-xl overflow-hidden shadow-xl p-6 flex flex-col justify-center min-h-[200px] hover:shadow-2xl transition-shadow duration-300">
                            @php
                                // Ambil gambar cover pertama dari relasi fotoAplikasi sebagai "foto thumbnail"
                                // Jika tidak ada fotoAplikasi, gunakan gambar placeholder.
                                $coverImage = $aplikasi->fotoAplikasi->first() ? asset('storage/' . $aplikasi->fotoAplikasi->first()->path_foto) : 'https://placehold.co/400x200/cccccc/333333?text=Cover+App';

                                // Ambil gambar ikon dari kolom 'logo' sebagai "logo pemilik"
                                // Jika tidak ada logo, gunakan gambar placeholder.
                                // Menggunakan 'nama_pemilik' untuk alt text ikon.
                                $iconImage = $aplikasi->logo ? asset('storage/' . $aplikasi->logo) : 'https://placehold.co/40x40/cccccc/333333?text=Icon';
                            @endphp

                            {{-- Foto Thumbnail Aplikasi (Cover Image) --}}
                            <img src="{{ $coverImage }}" alt="{{ $aplikasi->nama_aplikasi }} Thumbnail" class="w-full h-32 object-cover">
                            <div class="pt-4 flex items-start space-x-3">
                                {{-- Logo Pemilik (Icon Aplikasi) --}}
                                <img src="{{ $iconImage }}" alt="Logo {{ $aplikasi->nama_pemilik }}" class="w-10 h-10 rounded-md object-cover">
                                <div>
                                    {{-- Nama Aplikasi --}}
                                    <h3 class="font-semibold text-gray-800 text-sm mb-1">{{ $aplikasi->nama_aplikasi }}</h3>
                                    {{-- Nama Pemilik/Pengembang --}}
                                    <p class="text-gray-600 text-xs">{{ $aplikasi->nama_pemilik }}</p>
                                </div>
                            </div>
                        </div>
                    </a>
                    @empty
                    {{-- Pesan jika tidak ada aplikasi terpopuler --}}
                    <div class="col-span-full text-center text-gray-500">
                        Tidak ada aplikasi terpopuler yang tersedia saat ini.
                    </div>
                    @endforelse
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
            {{-- Flex container untuk berita, ditambahkan justify-center agar item terpusat --}}
            {{-- Gunakan kelas 'gap-4' untuk spasi antar item, lebih modern dari 'space-x-4' --}}
            <div class="flex flex-wrap justify-center gap-4">
                {{-- Loop melalui koleksi $beritas yang dikirim dari controller --}}
                @forelse($beritas as $berita)
                    {{-- Berita Item --}}
                    <div class="bg-white rounded-xl shadow-md w-80 sm:w-96 flex-shrink-0">
                        {{-- Menggunakan accessor thumbnail_url dari model Berita --}}
                        {{-- Tambahkan fallback image dengan 'onerror' jika gambar tidak ditemukan --}}
                        <img src="{{ $berita->thumbnail_url }}"
                            alt="{{ $berita->judul_berita }}"
                            class="w-full h-40 object-cover rounded-t-xl"
                            onerror="this.onerror=null;this.src='https://via.placeholder.com/600x400?text=No+Image';">
                        <div class="p-4">
                            <h3 class="font-semibold text-gray-800 text-lg mb-1">{{ $berita->judul_berita }}</h3>
                            {{-- Memformat tanggal menggunakan Carbon dengan lokal Indonesia --}}
                            <p class="text-gray-600 text-sm mb-2">
                                {{ \Carbon\Carbon::parse($berita->tanggal_dibuat)->locale('id')->isoFormat('D MMMM YYYY') }}
                            </p>
                            {{-- Menggunakan accessor ringkasan dari model Berita --}}
                            {{-- **PERBAIKAN DI SINI: Tambahkan style="word-wrap: break-word;"** --}}
                            <p class="text-gray-700 text-sm mb-3" style="word-wrap: break-word;">
                                {{ $berita->ringkasan }}
                            </p>
                            {{-- Link ke detail berita menggunakan rute bernama 'berita.show' --}}
                            <a href="{{ route('berita.show', $berita->id) }}" class="text-blue-600 hover:underline">
                                Baca Selengkapnya
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- Pesan jika tidak ada berita yang ditemukan --}}
                    <p class="text-center text-gray-500">Belum ada berita terbaru untuk ditampilkan.</p>
                @endforelse
            </div>

            {{-- Panah navigasi dihilangkan sesuai permintaan --}}
            {{-- <div class="absolute top-1/2 -left-14 transform -translate-y-1/2 cursor-pointer"> ... </div> --}}
            {{-- <div class="absolute top-1/2 -right-14 transform -translate-y-1/2 cursor-pointer"> ... </div> --}}
        </div>

        {{-- Titik-titik paginasi/indikator dihilangkan karena Anda hanya menampilkan 3 item dan tanpa panah navigasi --}}
        {{-- <div class="flex justify-center mt-4"> ... </div> --}}

        {{-- Tombol "Lihat semua berita" --}}
        <div class="flex justify-center mt-8">
            <a href="{{ route('berita.index') }}"
                class="inline-block bg-[#AD1500] hover:bg-[#8F1000] text-white px-6 py-3 rounded-full font-poppins shadow-md transition text-base">
                Lihat Semua Berita
            </a>
        </div>
    </div>
</section>

@endsection