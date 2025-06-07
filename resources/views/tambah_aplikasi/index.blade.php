@extends('layouts.app')

@section('content')

@if (session('alert.config'))
    <script>
        Swal.fire(@json(session('alert.config')));
    </script>
@endif

<div class="mb-10 bg-white mx-auto px-4 py-8 sm:px-6 lg:px-8">
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
        <h1 class="text-2xl font-semibold text-gray-900 mb-4 sm:mb-0">Daftar Aplikasi Anda</h1>
        <a href="{{ route('tambah_aplikasi.create') }}" class="bg-red-600 text-white rounded-full w-12 h-12 flex items-center justify-center text-3xl font-semibold shadow-lg hover:bg-red-700 transition-all duration-300 transform hover:scale-105" aria-label="Tambah Aplikasi Baru">
            +
        </a>
    </div>

    <div class="mb-10 bg-white p-6 rounded-xl shadow-md">
        {{-- Tampilkan jumlah aplikasi secara dinamis --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">{{ $aplikasi->count() }} Aplikasi yang Sudah Anda Tambahkan</h2>
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
        {{-- Lakukan loop untuk setiap aplikasi dari database --}}
        @forelse ($aplikasi as $app)
            <div class="bg-white rounded-xl shadow-lg overflow-hidden relative border border-gray-100 transform hover:scale-102 transition-transform duration-300 ease-in-out">
                {{-- Tampilkan kategori jika ada, atau teks default --}}
                <span class="absolute top-3 right-3 bg-red-500 text-white text-xs px-3 py-1 rounded-full font-semibold shadow-md">
                    {{ $app->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}
                </span>
                {{-- Gambar logo aplikasi --}}
                <img src="{{ asset('storage/' . $app->logo) }}"
                     onerror="this.onerror=null;this.src='https://via.placeholder.com/400x200/F3F4F6/6B7280?text=Logo+Tidak+Tersedia';"
                     alt="{{ $app->nama_aplikasi }}"
                     class="w-full h-44 object-cover object-center">
                <div class="p-5">
                    <h3 class="font-bold text-gray-900 text-lg mb-2">{{ $app->nama_aplikasi }}</h3>
                    {{-- Format tanggal upload (created_at) --}}
                    <p class="text-xs text-gray-500 mb-4">Upload: {{ $app->created_at->format('d-m-Y') }}</p>
                    <p class="text-xs text-gray-500 mb-4">Verifikasi: {{ $app->tanggal_verifikasi ? $app->tanggal_verifikasi->format('Y-m-d') : 'Menunggu' }}</p>

                    <div class="flex justify-between items-center mt-auto">
                        <div class="flex items-center text-sm text-gray-600">
                            @if($app->rating_konten)
                                <span>Rating: {{ $app->rating_konten }}</span>
                            @endif
                        </div>
                        <div class="flex space-x-3">
                            {{-- Tombol Edit --}}
                            <a href="{{ route('tambah_aplikasi.edit', $app->id) }}" class="text-blue-600 hover:text-blue-800 transition-colors duration-200 p-1 rounded-full hover:bg-blue-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50" aria-label="Edit Aplikasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                </svg>
                            </a>
                            {{-- Tombol Hapus (dengan form untuk DELETE request) --}}
                            <button type="button" onclick="confirmDelete('{{ $app->id }}')" class="text-red-600 hover:text-red-800 transition-colors duration-200 p-1 rounded-full hover:bg-red-50 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-opacity-50" aria-label="Hapus Aplikasi">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>

                            {{-- Form tersembunyi untuk delete --}}
                            <form id="delete-form-{{ $app->id }}" action="{{ route('tambah_aplikasi.destroy', $app->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-10 text-gray-500">
                <p>Belum ada aplikasi yang ditambahkan.</p>
                <p>Klik tombol "+" di atas untuk menambahkan aplikasi baru.</p>
            </div>
        @endforelse
    </div>
</div>

{{-- SweetAlert2 (Pastikan sudah diimpor di layout atau di sini) --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk konfirmasi hapus dengan SweetAlert
    function confirmDelete(aplikasiId) {
        Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Anda tidak akan bisa mengembalikan ini!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('delete-form-' + aplikasiId).submit();
            }
        });
    }
</script>
@endsection