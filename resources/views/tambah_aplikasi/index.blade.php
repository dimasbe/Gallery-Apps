@extends('layouts.app')

@section('content')
<div class="mb-10 bg-white mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4 sm:mb-0">Daftar Aplikasi Anda</h1>
        <a href='{"{{ route('user_login.aplikasi.create') }}"}" class="bg-red-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-3xl font-semibold shadow-lg hover:bg-red-700 transition-all duration-300 transform hover:scale-105" aria-label="Tambah Aplikasi Baru">
            +
        </a>
    </div>
    
    <div class="mb-10 bg-white p-6 rounded-xl shadow-md">
        <h2 class="text-xl font-semibold text-gray-800 mb-4">8 Aplikasi yang Sudah Anda Tambahkan</h2>
        <div class="flex space-x-4 overflow-x-auto pb-2">
            <button class="px-6 py-2 bg-red-600 text-white rounded-full text-sm font-semibold whitespace-nowrap shadow-md hover:bg-red-700 transition-colors duration-200 flex items-center">
                Semua
            </button>
            <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap hover:bg-gray-200 transition-colors duration-200 shadow-sm">Pending</button>
            <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap hover:bg-gray-200 transition-colors duration-200 shadow-sm">Terima</button>
            <button class="px-6 py-2 bg-gray-100 text-gray-700 rounded-full text-sm font-medium whitespace-nowrap hover:bg-gray-200 transition-colors duration-200 shadow-sm">Tolak</button>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-7">
        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Gaming</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Mobile Legends" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Mobile Legends</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Gaming</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Genshin Impact" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Genshin Impact</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Puzzle</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Candy Crush" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Candy Crush</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Edukasi</span>
            <img src="{{ asset('images/ruangguru.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Ruangguru" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Ruangguru</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Travel</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Traveloka" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Traveloka</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Keuangan</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Akulaku" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Akulaku</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Game</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Ludo King" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Ludo King</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
            <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">Belanja</span>
            <img src="{{ asset('images/mobilelegends.png') }}" onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Gambar+Tidak+Tersedia';" alt="Shopee" class="w-full h-44 object-cover object-center">
            <div class="p-5">
                <h3 class="font-bold text-gray-900 text-lg mb-2">Shopee</h3>
                <p class="text-xs text-gray-500 mb-4">Upload: 2023-10-26</p>
                <p class="text-xs text-gray-500 mb-4">Verifikasi: 2023-10-26</p>
                <div class="flex justify-between items-center mt-auto">
                    <div class="flex items-center text-sm text-gray-600">
                            <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.683-1.539 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.565-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.929 8.72c-.783-.57-.381-1.81.588-1.81h3.462a1 1 0 00.95-.69l1.07-3.292z"></path>
                        </svg>
                    </div>
                    <div class="flex space-x-3">
                        <button class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                            </svg>
                        </button>
                        <button class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection