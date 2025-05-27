@extends('layouts.app')

@section('content')
<section class="max-w-7xl mx-auto p-6">
<div class="mb-2 -mt-6">
    <a href="{{ url()->previous() }}" class="text-black hover:text-gray-700 flex items-center">
        <svg class="w-4 h-4 mr-1" fill="none" stroke="#AD1500" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Kembali
    </a>
</div>


    {{-- Image Banner Berita Utama --}}
    <div class="mb-8 rounded-lg overflow-hidden shadow-lg">
        <img src="{{ asset('images/berita2.png') }}" alt="Update Fitur Upload Baru" class="w-full h-[400px] object-cover">
    </div>

    {{-- Konten Artikel Utama --}}
    <article class="bg-white rounded-lg shadow-md p-8">
        <h1 class="text-4xl font-bold text-gray-900 mb-4">
            Update Fitur Upload Baru!
        </h1>

        <div class="flex items-center text-gray-600 text-sm mb-6">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
            <span class="mr-4">Admin Galery Apps</span>
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span>5 Mei 2025</span>
        </div>

        <div class="prose max-w-none text-gray-800 leading-relaxed">
            <p class="mb-4">
                Mulai Mei 2025, platform kami resmi merilis fitur upload terbaru yang dirancang untuk memberikan pengalaman lebih cepat, aman, dan praktis bagi pengguna. Kini, proses unggah file menjadi lebih efisien dengan dukungan multi-upload yang memungkinkan pengguna mengirim banyak file sekaligus.
            </p>
            <p class="mb-4">
                Selain itu, kecepatan unggah meningkat hingga 40% dari versi sebelumnya. Demi keamanan, setiap file yang diunggah akan dipindai secara otomatis menggunakan sistem perlindungan terbaru. Fitur ini juga dilengkapi tampilan yang responsif untuk perangkat mobile, serta mendukung drag and drop, pratinjau file sebelum dikirim, dan notifikasi real-time setelah upload berhasil. Pembaruan ini diharapkan dapat meningkatkan kenyamanan pengguna dalam mengelola dokumen dan konten digital sehari-hari.
            </p>
            <p>
                Dengan pembaruan ini, pengguna tidak hanya mendapatkan kecepatan dan keamanan, tetapi juga kontrol penuh atas proses unggah. Sistem akan memberikan peringatan jika ada file yang rusak, duplikat, atau melebihi batas ukuran yang ditentukan. Pengguna juga dapat menjadwalkan unggahan untuk waktu tertentu, memudahkan dalam manajemen konten yang lebih terorganisir. Integrasi dengan penyimpanan cloud memungkinkan file langsung tersimpan ke akun pribadi pengguna, menjadikan proses lebih terhubung dan efisien. Kami percaya fitur ini akan menjadi solusi unggah yang andal bagi kebutuhan personal maupun profesional.
            </p>
        </div>
    </article>

    {{-- Bagian Berita Terkait dan Tag Populer --}}
    <div class="mt-12 grid grid-cols-1 md:grid-cols-3 gap-8">
        {{-- Kolom Berita Terkait --}}
        <div class="md:col-span-2">
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Berita Terkait</h2>
            <div class="space-y-6">
                {{-- Berita Terkait Item 1 --}}
                <div class="flex items-center bg-white rounded-lg shadow-md p-4">
                    <img src="{{ asset('images/berita1.png') }}" alt="Update Fitur Dashboard" class="w-24 h-24 object-cover rounded-lg mr-4">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Update Fitur Dashboard Baru</h3>
                        <p class="text-gray-600 text-sm mb-2">21 Maret 2022</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Lihat Selengkapnya</a>
                    </div>
                </div>

                {{-- Berita Terkait Item 2 --}}
                <div class="flex items-center bg-white rounded-lg shadow-md p-4">
                    <img src="{{ asset('images/berita3.png') }}" alt="Peluncuran Fitur Notifikasi" class="w-24 h-24 object-cover rounded-lg mr-4">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Peluncuran Fitur Notifikasi</h3>
                        <p class="text-gray-600 text-sm mb-2">01 April 2025</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Lihat Selengkapnya</a>
                    </div>
                </div>

                {{-- Berita Terkait Item 3 --}}
                <div class="flex items-center bg-white rounded-lg shadow-md p-4">
                    <img src="{{ asset('images/berita2.png') }}" alt="Update Fitur Dashboard 2" class="w-24 h-24 object-cover rounded-lg mr-4">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Update Fitur Dashboard Baru (2)</h3>
                        <p class="text-gray-600 text-sm mb-2">21 Maret 2023</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Lihat Selengkapnya</a>
                    </div>
                </div>

                {{-- Berita Terkait Item 4 --}}
                <div class="flex items-center bg-white rounded-lg shadow-md p-4">
                    <img src="{{ asset('images/berita1.png') }}" alt="Peluncuran Fitur 2" class="w-24 h-24 object-cover rounded-lg mr-4">
                    <div>
                        <h3 class="font-semibold text-gray-800 text-lg mb-1">Peluncuran Fitur (2)</h3>
                        <p class="text-gray-600 text-sm mb-2">01 April 2020</p>
                        <a href="#" class="text-blue-500 hover:underline text-sm font-semibold">Lihat Selengkapnya</a>
                    </div>
                </div>

                {{-- Link Lihat Selengkapnya untuk semua berita terkait --}}
                <div class="text-center mt-6">
                    <a href="#" class="text-blue-500 hover:underline font-semibold">Lihat Selengkapnya</a>
                </div>
            </div>
        </div>

        {{-- Kolom Tag Populer --}}
        <div>
            <h2 class="text-2xl font-semibold text-gray-900 mb-6">Tag Populer</h2>
            <div class="bg-white rounded-lg shadow-md p-6">
                <div class="flex flex-wrap gap-2">
                    {{-- Tag Populer - Warna Merah #AD1500 --}}
                    <a href="#" class="inline-block bg-[#AD1500] text-white text-xs font-semibold px-4 py-2 rounded-full hover:opacity-90 transition-opacity duration-200">#update</a>
                    {{-- Tag Populer - Warna Abu-abu --}}
                    <a href="#" class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-300 transition-colors duration-200">#aplikasi</a>
                    <a href="#" class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-300 transition-colors duration-200">#upload</a>
                    <a href="#" class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-300 transition-colors duration-200">#populer</a>
                    <a href="#" class="inline-block bg-gray-200 text-gray-800 text-xs font-semibold px-4 py-2 rounded-full hover:bg-gray-300 transition-colors duration-200">#fitur</a>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
