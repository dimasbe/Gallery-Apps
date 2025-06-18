@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-800">Edit Berita</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="flex items-center">
                        <a href="{{ route('admin.berita.index') }}" class="hover:text-custom-primary-red">Berita</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Edit</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        {{-- Hapus blok validasi error dan flash error bawaan Laravel,
             karena akan ditangani oleh SweetAlert dan AJAX --}}
        {{--
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                {{ session('error') }}
            </div>
        @endif
        --}}

        {{-- Menambahkan id="beritaEditForm" untuk diakses oleh JavaScript --}}
        <form id="beritaEditForm" action="{{ route('admin.berita.update', $berita) }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PUT')

            <div>
                <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                <input type="text" name="judul_berita" id="judul_berita"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    value="{{ old('judul_berita', $berita->judul_berita) }}" required>
                {{-- Area untuk menampilkan error validasi dari AJAX --}}
                <p id="error-judul_berita" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori_id" id="kategori_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    required>
                    <option value="" disabled {{ old('kategori_id', $berita->kategori_id ?? '') == '' ? 'selected' : '' }}>-- Pilih Kategori --</option>
                    @foreach ($kategori as $item)
                        <option value="{{ $item->id }}"
                            {{ old('kategori_id', $berita->kategori_id ?? '') == $item->id ? 'selected' : '' }}>
                            {{ $item->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                {{-- Area untuk menampilkan error validasi dari AJAX --}}
                <p id="error-kategori_id" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div>
                <label for="thumbnail" class="block text-sm font-medium text-gray-700">Unggah Thumbnail Berita</label>
                <input type="file" name="thumbnail" id="thumbnail"
                    class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none"
                    accept="image/*" onchange="previewImage(event, 'thumbnail-preview')">
                <p id="error-thumbnail" class="text-red-500 text-xs mt-1"></p>

                @php
                    // Ambil objek foto berita yang bertipe 'thumbnail'
                    $currentThumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
                    // Tentukan path gambar yang akan ditampilkan, default ke placeholder jika tidak ada
                    $thumbnailSrc = $currentThumbnail ? asset('storage/' . $currentThumbnail->nama_gambar) : 'https://placehold.co/100x100?text=No+Thumbnail';
                @endphp

                <div id="thumbnail-preview" class="mt-2">
                    <img src="{{ $thumbnailSrc }}"
                         alt="Current Thumbnail" class="w-24 h-24 object-cover rounded-md">
                </div>
            </div>

            <div>
                <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                <textarea name="isi_berita" id="isi_berita" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    required>{{ old('isi_berita', $berita->isi_berita) }}</textarea>
                {{-- Area untuk menampilkan error validasi dari AJAX --}}
                <p id="error-isi_berita" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.berita.index') }}"
                    class="inline-flex justify-center py-2 px-5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit" id="updateButton"
                    class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                    Perbarui
                </button>
            </div>
        </form>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk preview gambar, sudah ada di kode Anda
    function previewImage(event, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = '';

        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover rounded-md mt-2">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('beritaEditForm');
        const updateButton = document.getElementById('updateButton');

        form.addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir standar

            // Hapus pesan error validasi sebelumnya
            document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');

            const formData = new FormData(form);

            // Penting: Jika Anda menggunakan @method('PUT'), FormData tidak otomatis menyertakan _method.
            // Anda harus menambahkannya secara manual untuk AJAX POST request yang disimulasikan sebagai PUT.
            formData.append('_method', 'PUT');

            updateButton.disabled = true; // Nonaktifkan tombol
            updateButton.textContent = 'Memperbarui...'; // Ubah teks tombol

            try {
                const response = await fetch(form.action, {
                    method: 'POST', // Method harus POST karena kita menambahkan _method=PUT di body
                    body: formData,
                    headers: {
                        'Accept': 'application/json', // Memberi tahu server kita mengharapkan JSON
                        // 'X-CSRF-TOKEN' sudah di handle oleh @csrf di dalam form, tapi lebih aman jika tetap ditambahkan di sini.
                        // Namun FormData akan otomatis menyertakan token CSRF jika ada di form HTML.
                        // Jika Anda tidak menggunakan @csrf di form, baris ini harus diaktifkan:
                        // 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect; // Redirect ke halaman index berita
                        }
                    });
                } else {
                    // Tangani kesalahan, termasuk validasi (status 422)
                    let errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                    
                    if (data.errors) {
                        // Jika ada error validasi dari Laravel, tampilkan di bawah input masing-masing
                        Object.entries(data.errors).forEach(([key, value]) => {
                            const errorElement = document.getElementById(`error-${key}`);
                            if (errorElement) {
                                errorElement.textContent = value.join(', ');
                            }
                        });
                        // Untuk SweetAlert, gabungkan semua pesan error validasi
                        errorMessage = Object.values(data.errors).flat().join('\n');
                    }

                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage
                    });
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan!',
                    text: 'Tidak dapat terhubung ke server. Silakan coba lagi.'
                });
            } finally {
                updateButton.disabled = false; // Aktifkan kembali tombol
                updateButton.textContent = 'Perbarui'; // Kembalikan teks tombol
            }
        });
    });
</script>
@endsection