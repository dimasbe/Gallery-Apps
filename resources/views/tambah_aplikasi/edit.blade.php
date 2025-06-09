@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-xl space-y-6">

        <div class="mb-6">
            <a href="{{ route('tambah_aplikasi.index') }}" class="flex items-center text-gray-600 hover:text-red-600 font-poppins text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                </svg>
                Kembali
            </a>
        </div>

        <h2 class="text-xl font-semibold text-gray-900 text-center">
            Edit Aplikasi
        </h2>

        <form class="mt-8 space-y-6" id="aplikasiForm" action="{{ route('tambah_aplikasi.update', $aplikasi->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- General error message container (for non-validation errors like network issues) --}}
            <div id="generalErrorMessage" class="hidden bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Gagal!</strong>
                <span class="block sm:inline" id="generalErrorText"></span>
                <ul id="generalErrorDetails" class="mt-2 list-disc list-inside text-sm"></ul>
            </div>

            {{-- Upload Foto Aplikasi --}}
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-gray-400">
                <input type="file" id="foto_aplikasi" name="path_foto[]" class="hidden" multiple accept="image/*">
                <label for="foto_aplikasi" class="flex flex-col items-center justify-center h-24">
                    <svg class="mx-auto h-12 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L28 28m0 0l4 4m4-24h8m-4-4v8m-12 4h.02" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="mt-2 text-sm text-gray-700 font-medium">Unggah Foto Aplikasi</span>
                </label>
            </div>

            <div id="preview" class="mt-4 flex flex-wrap gap-4">
                {{-- Preview foto aplikasi akan di-render oleh JavaScript --}}
            </div>
            <div id="error-path_foto" class="text-red-500 text-xs mt-1"></div>

            {{-- Input Logo --}}
            <div class="mt-4">
                <label for="logo_input_visual" class="block text-sm font-medium text-gray-700">Logo</label>
                <div class="mt-1 flex items-center border border-gray-300 rounded-md shadow-sm overflow-hidden">
                    {{-- Input file asli yang disembunyikan --}}
                    <input type="file" id="logo_input" name="logo" class="hidden" accept="image/*">

                    {{-- Tombol "Choose File" kustom --}}
                    <label for="logo_input" id="logo-file-label" class="bg-red-700 text-white px-4 py-2 cursor-pointer hover:bg-red-800 text-sm font-semibold rounded-l-md transition-colors duration-200" style="flex-shrink: 0;">
                        Choose File
                    </label>
                </div>
                <div id="logo-preview-container" class="mt-4 flex flex-wrap gap-4">
                    {{-- Preview logo akan di-render oleh JavaScript --}}
                </div>
                <div id="error-logo" class="text-red-500 text-xs mt-1"></div>
            </div>

            {{-- Nama Aplikasi --}}
            <div class="mt-4">
                <label for="nama_aplikasi" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                <input id="nama_aplikasi" name="nama_aplikasi" type="text" required value="{{ old('nama_aplikasi', $aplikasi->nama_aplikasi) }}" class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                <div id="error-nama_aplikasi" class="text-red-500 text-xs mt-1"></div>
            </div>

            {{-- Pemilik --}}
            <div class="mt-4">
                <label for="pemilik" class="block text-sm font-medium text-gray-700">Pemilik</label>
                <input id="pemilik" name="nama_pemilik" type="text" required value="{{ old('nama_pemilik', $aplikasi->nama_pemilik) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                <div id="error-nama_pemilik" class="text-red-500 text-xs mt-1"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                {{-- Kategori --}}
                <div>
                    <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="id_kategori" id="id_kategori" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" required>
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('id_kategori', $aplikasi->id_kategori) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div id="error-id_kategori" class="text-red-500 text-xs mt-1"></div>
                </div>

                {{-- Tanggal Rilis --}}
                <div>
                    <label for="tanggal_rilis" class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <input id="tanggal_rilis" name="tanggal_rilis" type="date" value="{{ old('tanggal_rilis', $aplikasi->tanggal_rilis) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <div id="error-tanggal_rilis" class="text-red-500 text-xs mt-1"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                {{-- Versi --}}
                <div>
                    <label for="versi" class="block text-sm font-medium text-gray-700">Versi</label>
                    <input id="versi" name="versi" type="text" value="{{ old('versi', $aplikasi->versi) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <div id="error-versi" class="text-red-500 text-xs mt-1"></div>
                </div>

                {{-- Rating Konten --}}
                <div>
                    <label for="rating_konten" class="block text-sm font-medium text-gray-700">Rating Konten</label>
                    <input id="rating_konten" name="rating_konten" type="text" value="{{ old('rating_konten', $aplikasi->rating_konten) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <div id="error-rating_konten" class="text-red-500 text-xs mt-1"></div>
                </div>
            </div>

            {{-- Tautan Aplikasi --}}
            <div class="mt-4">
                <label for="tautan_aplikasi" class="block text-sm font-medium text-gray-700">Tautan Aplikasi</label>
                <input id="tautan_aplikasi" name="tautan_aplikasi" type="url" value="{{ old('tautan_aplikasi', $aplikasi->tautan_aplikasi) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                <div id="error-tautan_aplikasi" class="text-red-500 text-xs mt-1"></div>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" required>{{ old('deskripsi', $aplikasi->deskripsi) }}</textarea>
                <div id="error-deskripsi" class="text-red-500 text-xs mt-1"></div>
            </div>

            {{-- Fitur --}}
            <div class="mt-4 mb-6">
                <label for="fitur" class="block text-sm font-medium text-gray-700">Fitur</label>
                <textarea name="fitur" id="fitur" rows="4" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" required>{{ old('fitur', $aplikasi->fitur) }}</textarea>
                <div id="error-fitur" class="text-red-500 text-xs mt-1"></div>
            </div>


            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('tambah_aplikasi.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit" id="submitButton" class="group relative flex justify-center py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition-all duration-200" disabled>
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const fotoAplikasiInput = document.getElementById('foto_aplikasi');
    const previewContainer = document.getElementById('preview'); // For multiple app photos
    const logoInput = document.getElementById('logo_input'); // Renamed from 'logo'
    const logoFileLabel = document.getElementById('logo-file-label');
    const logoPreviewContainer = document.getElementById('logo-preview-container');
    const submitButton = document.getElementById('submitButton');
    const aplikasiForm = document.getElementById('aplikasiForm');

    let filesArray = []; // Store File objects for newly selected app photos
    let existingPhotoPaths = []; // Store paths for existing app photos
    let currentLogoFile = null; // Store File object for newly selected logo
    let existingLogoPath = "{{ $aplikasi->logo ? asset('storage/' . $aplikasi->logo) : '' }}"; // Path for existing logo

    // Variables to track initial form state for change detection
    let initialFormState = {};
    let initialExistingPhotoPaths = [];
    let initialExistingLogoPath = "";

    // Get general message containers
    const generalErrorMessageContainer = document.getElementById('generalErrorMessage');
    const generalErrorText = document.getElementById('generalErrorText');
    const generalErrorDetailsList = document.getElementById('generalErrorDetails');

    // --- Function to check if form has changes and enable/disable button ---
    function checkForChanges() {
        let formChanged = false;

        // Check text/select/textarea inputs
        Array.from(aplikasiForm.elements).forEach(element => {
            if (element.name && element.type !== 'file' && element.type !== 'submit' && element.name !== '_token' && element.name !== '_method') {
                if (initialFormState[element.name] !== element.value) {
                    formChanged = true;
                }
            }
        });

        // Check for changes in app photos
        // If the number of current existing photos is different from initial, or new files added
        if (existingPhotoPaths.length !== initialExistingPhotoPaths.length || filesArray.length > 0) {
            formChanged = true;
        } else {
            // Check if any existing photo paths have been removed
            const initialSet = new Set(initialExistingPhotoPaths);
            const currentSet = new Set(existingPhotoPaths);
            if ([...initialSet].some(path => !currentSet.has(path))) {
                formChanged = true;
            }
        }


        // Check for changes in logo
        if (currentLogoFile !== null || existingLogoPath !== initialExistingLogoPath) {
            formChanged = true;
        }


        submitButton.disabled = !formChanged;
    }

    // --- Fungsi Bantuan untuk Render Preview ---
    function createImagePreview(src, isNewFile, pathOrFileObject) {
        const wrapper = document.createElement('div');
        wrapper.classList.add('relative', 'w-24', 'h-24');

        const img = document.createElement('img');
        img.src = src;
        img.classList.add('object-cover', 'w-full', 'h-full', 'rounded');

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '✕';
        removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'text-xs', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'shadow');
        removeBtn.type = 'button';

        if (isNewFile) {
            removeBtn.onclick = () => {
                filesArray = filesArray.filter(file => file !== pathOrFileObject); // pathOrFileObject di sini adalah objek File
                renderAppPhotosPreview();
                checkForChanges(); // Check for changes after removal
            };
        } else {
            removeBtn.onclick = () => {
                Swal.fire({
                    title: 'Yakin ingin menghapus foto ini?',
                    text: "Foto akan dihapus setelah Anda menyimpan perubahan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        existingPhotoPaths = existingPhotoPaths.filter(p => p !== pathOrFileObject); // pathOrFileObject di sini adalah string path
                        renderAppPhotosPreview();
                        checkForChanges(); // Check for changes after removal
                        Swal.fire('Terhapus!', 'Foto akan dihapus dari server setelah disimpan.', 'success');
                    }
                });
            };
        }

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        return wrapper;
    }

    function createLogoPreview(src, isNewFile) {
        logoPreviewContainer.innerHTML = ''; // Clear existing logo preview

        if (!src) {
            logoFileLabel.textContent = 'Choose File'; // Reset label
            return; // Jangan buat preview jika tidak ada src
        }

        const wrapper = document.createElement('div');
        wrapper.classList.add('relative', 'w-24', 'h-24');

        const img = document.createElement('img');
        img.src = src;
        img.classList.add('object-cover', 'w-full', 'h-full', 'rounded');

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '✕';
        removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'text-xs', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'shadow');
        removeBtn.type = 'button';
        removeBtn.onclick = () => {
            if (isNewFile) {
                currentLogoFile = null; // Hapus file yang baru dipilih
                logoInput.value = ''; // Reset input file
                createLogoPreview(''); // Hapus preview
            } else {
                Swal.fire({
                    title: 'Yakin ingin menghapus logo ini?',
                    text: "Logo akan dihapus setelah Anda menyimpan perubahan.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        existingLogoPath = null; // Hapus path logo lama
                        createLogoPreview(''); // Hapus preview
                        checkForChanges(); // Check for changes after removal
                        Swal.fire('Terhapus!', 'Logo akan dihapus dari server setelah disimpan.', 'success');
                    }
                });
            }
            checkForChanges(); // Check for changes after logo modification
        };

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        logoPreviewContainer.appendChild(wrapper);
        logoFileLabel.textContent = 'Logo Terpilih'; // Update label after a logo is present
    }

    // --- Render semua foto aplikasi (lama dan baru) ---
    function renderAppPhotosPreview() {
        previewContainer.innerHTML = ''; // Clear all existing previews

        // Render existing photos
        existingPhotoPaths.forEach(path => {
            const fullPath = `{{ asset('storage') }}/${path}`;
            previewContainer.appendChild(createImagePreview(fullPath, false, path));
        });

        // Render newly selected photos
        filesArray.forEach(file => {
            const reader = new FileReader();
            reader.onload = e => {
                previewContainer.appendChild(createImagePreview(e.target.result, true, file));
            };
            reader.readAsDataURL(file);
        });
    }

    // Function to clear all inline error messages
    function clearErrors() {
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.textContent = '';
            el.classList.add('hidden'); // Ensure it's hidden when cleared
        });
        generalErrorMessageContainer.classList.add('hidden');
        generalErrorDetailsList.innerHTML = '';
    }

    // --- Inisialisasi saat DOM siap ---
    document.addEventListener('DOMContentLoaded', () => {
        // Inisialisasi existingPhotoPaths dari Blade
        @if($aplikasi->fotoAplikasi->isNotEmpty())
            @foreach($aplikasi->fotoAplikasi as $foto)
                existingPhotoPaths.push("{{ $foto->path_foto }}");
            @endforeach
        @endif
        initialExistingPhotoPaths = [...existingPhotoPaths]; // Copy for initial state tracking

        renderAppPhotosPreview(); // Render foto aplikasi yang sudah ada

        // Render logo yang sudah ada
        if (existingLogoPath) {
            createLogoPreview(existingLogoPath, false);
        } else {
            logoFileLabel.textContent = 'Choose File';
        }
        initialExistingLogoPath = existingLogoPath; // Store initial logo path

        // Capture initial form state for text/select/textarea inputs
        Array.from(aplikasiForm.elements).forEach(element => {
            if (element.name && element.type !== 'file' && element.type !== 'submit' && element.name !== '_token' && element.name !== '_method') {
                initialFormState[element.name] = element.value;
            }
        });

        // Add event listeners to all form inputs to check for changes
        aplikasiForm.addEventListener('input', checkForChanges);
        aplikasiForm.addEventListener('change', checkForChanges);
        aplikasiForm.addEventListener('keyup', checkForChanges);
        aplikasiForm.addEventListener('paste', checkForChanges);

        // Initially disable the button
        submitButton.disabled = true;
    });

    // --- Event Listener untuk Foto Aplikasi ---
    fotoAplikasiInput.addEventListener('change', (e) => {
        const newFiles = Array.from(e.target.files);
        filesArray = filesArray.concat(newFiles); // Tambahkan ke array yang sudah ada
        renderAppPhotosPreview(); // Render ulang semua preview
        fotoAplikasiInput.value = ''; // Clear input untuk memungkinkan pemilihan ulang
        checkForChanges(); // Check for changes after file input change
    });

    // --- Event Listener untuk Logo ---
    logoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            currentLogoFile = file;
            const reader = new FileReader();
            reader.onload = event => {
                createLogoPreview(event.target.result, true); // Render preview logo baru
            };
            reader.readAsDataURL(file);
        } else {
            currentLogoFile = null;
            createLogoPreview(''); // Hapus preview jika tidak ada file yang dipilih
        }
        checkForChanges(); // Check for changes after file input change
    });

    // --- PENTING: Tangani form submission menggunakan AJAX (Fetch API) ---
    document.getElementById('aplikasiForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Mencegah pengiriman form tradisional

        clearErrors(); // Clear previous errors

        submitButton.disabled = true; // Nonaktifkan tombol
        submitButton.textContent = 'Menyimpan...'; // Ubah teks tombol

        const formData = new FormData(); // Buat FormData baru

        // Tambahkan semua input form secara manual kecuali file input yang akan dikelola JS
        Array.from(this.elements).forEach(element => {
            // Hindari file input 'path_foto[]' dan 'logo_input' karena akan ditambahkan secara manual
            // Juga hindari tombol submit
            if (element.name && element.name !== 'path_foto[]' && element.name !== 'logo' && element.type !== 'submit') {
                // Untuk input type="date", pastikan value-nya valid sebelum append
                if (element.type === 'date' && element.value === '') {
                    // Jangan append jika kosong, atau append null jika server bisa menanganinya
                    // formData.append(element.name, null);
                } else {
                    formData.append(element.name, element.value);
                }
            }
        });

        // 1. Tambahkan Logo ke FormData
        if (currentLogoFile) {
            // Jika ada logo baru yang dipilih
            formData.append('logo', currentLogoFile);
        } else if (existingLogoPath) {
            // Jika ada logo lama yang tidak dihapus (pertahankan)
            formData.append('logo_existing_path', existingLogoPath.replace('{{ asset('storage') }}/', '')); // Kirim hanya path relatif
        } else {
            // Jika logo dihapus atau tidak ada
            formData.append('logo_deleted', '1'); // Tell server logo was explicitly removed
        }

        // 2. Tambahkan File Foto Aplikasi Baru ke FormData
        filesArray.forEach((file) => {
            formData.append('path_foto[]', file);
        });

        // 3. Tambahkan Path Foto Aplikasi yang Sudah Ada (yang tidak dihapus) ke FormData
        existingPhotoPaths.forEach(path => {
            formData.append('existing_photos[]', path);
        });


        // Ambil CSRF token dari meta tag (pastikan meta tag ada di layout)
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(this.action, {
                method: 'POST', // Gunakan POST meskipun ada @method('PUT'), Laravel akan menanganinya
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken // Kirim CSRF token
                }
            });

            const data = await response.json(); // Parse respons sebagai JSON

            if (response.ok) { // Check if status is 2xx (successful response)
                if (data.success) {
                    Swal.fire({ // Show SweetAlert success popup
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = data.redirect; // Redirect
                    });
                } else {
                    // This case ideally shouldn't be reached if response.ok is true
                    // unless your server sends `success: false` with a 200 status.
                    // If it does, treat it as a general error.
                    generalErrorText.textContent = data.message || 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.';
                    generalErrorMessageContainer.classList.remove('hidden');
                }
            } else { // Handle non-2xx responses (e.g., 422 validation errors, 500 server errors)
                generalErrorText.textContent = data.message || 'Terjadi kesalahan saat menyimpan data.';
                if (data.errors) {
                    // Display inline errors for specific fields
                    for (const key in data.errors) {
                        // Laravel validation sometimes returns 'path_foto.0', 'path_foto.1', etc.
                        // Map these to 'path_foto' for the general error div for multiple images.
                        const errorKey = key.includes('path_foto') ? 'path_foto' : key;

                        const errorDiv = document.getElementById(`error-${errorKey}`);
                        if (errorDiv) {
                            errorDiv.textContent = data.errors[key].join(', ');
                            errorDiv.classList.remove('hidden'); // Show the error div
                        } else {
                            // If no specific div, add to general error details list
                            const listItem = document.createElement('li');
                            listItem.textContent = `${key}: ${data.errors[key].join(', ')}`;
                            generalErrorDetailsList.appendChild(listItem);
                        }
                    }
                }
                generalErrorMessageContainer.classList.remove('hidden'); // Show the general error container
            }
        } catch (error) {
            console.error('Error:', error);
            generalErrorText.textContent = 'Terjadi kesalahan jaringan atau sistem. Pastikan Anda terhubung ke internet dan coba lagi.';
            generalErrorMessageContainer.classList.remove('hidden'); // Show the general error container
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Simpan'; // Reset button text
        }
    });

</script>
@endsection