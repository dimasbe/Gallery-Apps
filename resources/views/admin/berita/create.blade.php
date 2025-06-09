@extends('layouts.admin')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-800">Berita</h1>
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
                    <li class="text-custom-primary-red" aria-current="page">Tambah</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <h1 class="text-2xl font-bold mb-6 text-red-800 text-center">Formulir Berita</h1>

        {{-- FORM MULAI --}}
        <form id="beritaForm" action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div>
                <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
                <input type="text" name="judul_berita" id="judul_berita"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    value="{{ old('judul_berita') }}">
                {{-- Area untuk menampilkan error validasi dari AJAX --}}
                <p id="error-judul_berita" class="text-red-500 text-xs mt-1"></p>
                {{-- Hapus @error di sini jika Anda ingin sepenuhnya mengandalkan AJAX untuk pesan error --}}
                {{-- Jika tetap ada, Laravel akan mengisi ini jika ada pengiriman non-AJAX atau jika Anda tidak menghapus pesan error AJAX secara manual --}}
            </div>

            <div>
                <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
                <select name="kategori_id" id="kategori_id"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    <option value="">Pilih Kategori</option>
                    @foreach($kategori as $item)
                        <option value="{{ $item->id }}" {{ old('kategori_id') == $item->id ? 'selected' : '' }}>
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
                {{-- Area untuk menampilkan error validasi dari AJAX --}}
                <p id="error-thumbnail" class="text-red-500 text-xs mt-1"></p>
                <div id="thumbnail-preview" class="mt-2"></div> {{-- Pastikan ini ada untuk preview --}}
            </div>

            <div>
                <label for="isi_berita" class="block text-sm font-medium text-gray-700">Isi Berita</label>
                <textarea name="isi_berita" id="isi_berita" rows="4"
                    class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                    >{{ old('isi_berita') }}</textarea>
                {{-- Area untuk menampilkan error validasi dari AJAX --}}
                <p id="error-isi_berita" class="text-red-500 text-xs mt-1"></p>
            </div>

            <div class="pt-6 flex justify-end space-x-4">
                <a href="{{ route('admin.berita.index') }}"
                    class="inline-flex justify-center py-2 px-5 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit" id="submitButton"
                    class="inline-flex justify-center py-2 px-5 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-800 hover:bg-red-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-800">
                    Simpan
                </button>
            </div>
        </form>

        {{-- FORM SELESAI --}}
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Fungsi untuk preview gambar (jika Anda memiliki input thumbnail)
    function previewImage(event, previewId) {
        const previewContainer = document.getElementById(previewId);
        previewContainer.innerHTML = ''; // Clear previous preview

        if (event.target.files && event.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function (e) {
                previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover rounded-md mt-2">`;
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('beritaForm');
        const submitButton = document.getElementById('submitButton');

        form.addEventListener('submit', async function(event) {
            event.preventDefault(); // Mencegah pengiriman formulir standar

            // Hapus pesan error validasi sebelumnya dari elemen <p> di bawah input
            document.querySelectorAll('[id^="error-"]').forEach(el => el.textContent = '');
            // Hapus juga kelas error jika Anda menambahkan di input (optional)
            document.querySelectorAll('.border-red-500').forEach(el => {
                el.classList.remove('border-red-500');
                el.classList.add('border-gray-300');
            });


            const formData = new FormData(form);

            submitButton.disabled = true; // Nonaktifkan tombol
            submitButton.textContent = 'Menyimpan...'; // Ubah teks tombol

            try {
                const response = await fetch(form.action, {
                    method: form.method,
                    body: formData,
                    headers: {
                        'Accept': 'application/json', // Memberi tahu server kita mengharapkan JSON
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Sertakan token CSRF
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        if (data.redirect) {
                            window.location.href = data.redirect; // Redirect ke halaman index berita
                        } else {
                            // Opsional: jika tidak ada redirect, mungkin clear form atau reload
                            form.reset();
                            // Hapus preview thumbnail jika ada
                            const thumbnailPreview = document.getElementById('thumbnail-preview');
                            if (thumbnailPreview) {
                                thumbnailPreview.innerHTML = '';
                            }
                        }
                    });
                } else {
                    // Tangani kesalahan
                    if (response.status === 422 && data.errors) {
                        // Ini adalah error validasi, tampilkan hanya di bawah form
                        Object.entries(data.errors).forEach(([key, value]) => {
                            const errorElement = document.getElementById(`error-${key}`);
                            if (errorElement) {
                                errorElement.textContent = value.join(', ');
                                // Opsional: tambahkan kelas error ke input
                                const inputElement = document.getElementById(key);
                                if (inputElement) {
                                    inputElement.classList.add('border-red-500');
                                    inputElement.classList.remove('border-gray-300');
                                }
                            }
                        });
                        // TIDAK MEMANGGIL Swal.fire() di sini
                    } else {
                        // Ini adalah error server lainnya (misal 500) atau error yang tidak memiliki 'errors'
                        let errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage
                        });
                    }
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan!',
                    text: 'Tidak dapat terhubung ke server. Silakan coba lagi.'
                });
            } finally {
                submitButton.disabled = false; // Aktifkan kembali tombol
                submitButton.textContent = 'Simpan'; // Kembalikan teks tombol
            }
        });
    });
</script>
@endsection