@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-xl space-y-6">
        <h2 class="text-xl font-semibold text-gray-900 text-center">
            Tambah Aplikasi
        </h2>

        <form class="mt-8 space-y-6" id="aplikasiForm" action="{{ route('tambah_aplikasi.store') }}" method="POST" enctype="multipart/form-data">
            @csrf {{-- PENTING: Untuk CSRF Token --}}

            {{-- Input Foto Aplikasi Multiple --}}
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-gray-400">
                <input type="file" id="foto_aplikasi" name="path_foto[]" class="hidden" multiple accept="image/*">
                <label for="foto_aplikasi" class="flex flex-col items-center justify-center h-24">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L40 32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="mt-2 text-sm text-gray-700 font-medium">
                        Unggah Foto Aplikasi
                    </span>
                </label>
            </div>
            <div id="preview" class="mt-4 flex flex-wrap gap-4"></div>

            {{-- Input Logo --}}
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" accept="image/*">
            </div>

            {{-- Input Teks Lainnya --}}
            <div>
                <label for="nama_aplikasi" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                <div class="mt-1">
                    <input id="nama_aplikasi" name="nama_aplikasi" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>
            {{-- ... (input lainnya) ... --}}
            <div>
                <label for="pemilik" class="block text-sm font-medium text-gray-700">Pemilik</label>
                <div class="mt-1">
                    <input id="pemilik" name="nama_pemilik" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="id_kategori" id="id_kategori"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $item) {{-- Hapus 's' jika variabel di controller adalah $kategori --}}
                            <option value="{{ $item->id }}" {{ old('id_kategori') == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label for="tanggal_rilis" class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <div class="mt-1 relative">
                        <input id="tanggal_rilis" name="tanggal_rilis" type="date" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="versi" class="block text-sm font-medium text-gray-700">Versi</label>
                    <div class="mt-1">
                        <input id="versi" name="versi" type="text" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    </div>
                </div>
                <div>
                    <label for="rating_konten" class="block text-sm font-medium text-gray-700">Rating Konten</label>
                    <div class="mt-1">
                        <input id="rating_konten" name="rating_konten" type="text" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                    </div>
                </div>
            </div>

            <div>
                <label for="tautan_aplikasi" class="block text-sm font-medium text-gray-700">Tautan Aplikasi</label>
                <div class="mt-1">
                    <input id="tautan_aplikasi" name="tautan_aplikasi" type="url" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required></textarea>
            </div>

            <div class="mb-6">
                <label for="fitur" class="block text-sm font-medium text-gray-700">Fitur</label>
                <textarea name="fitur" id="fitur" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm" required></textarea>
            </div>


            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('tambah_aplikasi.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit" id="submitButton" class="group relative flex justify-center py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition-all duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

{{-- PENTING: Pastikan SweetAlert2 diimpor. Ini bisa di <head> atau di akhir <body> --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const fotoAplikasiInput = document.getElementById('foto_aplikasi');
    const previewContainer = document.getElementById('preview');
    let filesArray = []; // Store File objects for photos

    fotoAplikasiInput.addEventListener('change', (e) => {
        const newFiles = Array.from(e.target.files);
        filesArray = filesArray.concat(newFiles);
        renderPreview();
        fotoAplikasiInput.value = ''; // Clear input to allow re-selection
    });

    function renderPreview() {
        previewContainer.innerHTML = ''; // Clear existing previews

        filesArray.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = e => {
                const wrapper = document.createElement('div');
                wrapper.classList.add('relative', 'w-24', 'h-24');

                const img = document.createElement('img');
                img.src = e.target.result;
                img.classList.add('object-cover', 'w-full', 'h-full', 'rounded');

                const removeBtn = document.createElement('button');
                removeBtn.innerHTML = '✕';
                removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'text-xs', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'shadow');
                removeBtn.type = 'button'; // Prevent form submission
                removeBtn.onclick = () => {
                    filesArray.splice(index, 1); // Remove file from array
                    renderPreview(); // Re-render preview
                };

                wrapper.appendChild(img);
                wrapper.appendChild(removeBtn);
                previewContainer.appendChild(wrapper);
            };
            reader.readAsDataURL(file);
        });
    }

    // PENTING: Tangani form submission menggunakan AJAX (Fetch API)
    document.getElementById('aplikasiForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Mencegah pengiriman form tradisional

        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true; // Nonaktifkan tombol
        submitButton.textContent = 'Menyimpan...'; // Ubah teks tombol

        const formData = new FormData(this); // Ambil semua data form

        // Tambahkan setiap file dari filesArray ke objek FormData (untuk multiple files)
        // PENTING: Pastikan nama field ini ('path_foto[]') cocok dengan 'path_foto.*' di StoreAplikasiRequest
        filesArray.forEach((file) => {
            formData.append('path_foto[]', file);
        });

        // Ambil CSRF token dari meta tag (pastikan meta tag ada di layout)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Kirim CSRF token
                }
            });

            // PENTING: Periksa apakah respons adalah JSON yang valid
            if (!response.ok) {
                // Jika status bukan 2xx (misal 422, 500), coba baca sebagai JSON jika memungkinkan,
                // jika tidak, lemparkan error umum.
                const errorData = await response.json().catch(() => null); // Coba parse JSON, kalau gagal jadi null
                if (errorData) {
                    throw errorData; // Lempar data error dari server
                } else {
                    throw new Error(`Server responded with status: ${response.status} ${response.statusText}`);
                }
            }

            const data = await response.json(); // Parse respons sebagai JSON

            if (data.success) {
                Swal.fire({ // Tampilkan SweetAlert sukses
                    icon: 'success',
                    title: 'Berhasil!',
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = data.redirect; // Redirect ke halaman index
                });
            } else {
                let errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                if (data.errors) {
                    errorMessage += '\n\nDetail Kesalahan:\n';
                    for (const key in data.errors) {
                        errorMessage += `- ${data.errors[key].join(', ')}\n`;
                    }
                }
                Swal.fire({ // Tampilkan SweetAlert error
                    icon: 'error',
                    title: 'Gagal!',
                    text: errorMessage,
                    confirmButtonText: 'OK'
                });
            }
        } catch (error) {
            console.error('Error:', error); // Log error ke konsol browser
            let displayMessage = 'Terjadi kesalahan saat berkomunikasi dengan server. Silakan coba lagi.';
            if (error && error.message) {
                // Jika error berasal dari server (misal dari throw errorData)
                displayMessage = error.message;
                if (error.errors) { // Jika ada error validasi dari server
                    displayMessage += '\n\nDetail Kesalahan:\n';
                    for (const key in error.errors) {
                        displayMessage += `- ${error.errors[key].join(', ')}\n`;
                    }
                }
            }

            Swal.fire({ // Tampilkan SweetAlert error umum
                icon: 'error',
                title: 'Error Jaringan / Sistem!',
                text: displayMessage,
                confirmButtonText: 'OK'
            });
        } finally {
            submitButton.disabled = false; // Aktifkan kembali tombol
            submitButton.textContent = 'Simpan'; // Kembalikan teks tombol
        }
    });

    // Menampilkan nama file yang dipilih untuk input logo
    document.getElementById('logo').addEventListener('change', function() {
        var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        document.getElementById('file-chosen').textContent = fileName;
    });

</script>
@endsection