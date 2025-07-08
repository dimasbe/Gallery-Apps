@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-1000 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
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
            <div id="error-path_foto" class="text-red-500 text-xs mt-1"></div>

            {{-- Input Logo --}}
            <div>
                <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-700 file:text-white hover:file:bg-red-100 hover:file:text-black" accept="image/*">
                <div id="logo-preview-container" class="mt-4">
                    @if($aplikasi->logo)
                        <div class="relative w-24 h-24">
                            <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo Aplikasi" class="object-cover w-full h-full rounded">
                            <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center shadow remove-existing-logo" data-logo-path="{{ $aplikasi->logo }}">✕</button>
                        </div>
                    @endif
                </div>
                <div id="error-logo" class="text-red-500 text-xs mt-1"></div>
            </div>

            {{-- Input Teks Lainnya --}}
            <div>
                <label for="nama_aplikasi" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                <div class="mt-1">
                    <input id="nama_aplikasi" name="nama_aplikasi" type="text" value="{{ old('nama_aplikasi', $aplikasi->nama_aplikasi) }}" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>
                <div id="error-nama_aplikasi" class="text-red-500 text-xs mt-1"></div>
            </div>
            <div>
                <label for="pemilik" class="block text-sm font-medium text-gray-700">Pemilik</label>
                <div class="mt-1">
                    <input id="pemilik" name="nama_pemilik" type="text" value="{{ old('nama_pemilik', $aplikasi->nama_pemilik) }}" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>
                <div id="error-nama_pemilik" class="text-red-500 text-xs mt-1"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="id_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <select name="id_kategori" id="id_kategori"
                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                        <option value="">Pilih Kategori</option>
                        @foreach($kategori as $item)
                            <option value="{{ $item->id }}" {{ old('id_kategori', $aplikasi->id_kategori) == $item->id ? 'selected' : '' }}>
                                {{ $item->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                    <div id="error-id_kategori" class="text-red-500 text-xs mt-1"></div>
                </div>

                <div>
                    <label for="tanggal_rilis" class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <div class="mt-1 relative">
                        <input id="tanggal_rilis" name="tanggal_rilis" type="date" value="{{ old('tanggal_rilis', optional($aplikasi->tanggal_rilis)->format('Y-m-d')) }}" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div id="error-tanggal_rilis" class="text-red-500 text-xs mt-1"></div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="versi" class="block text-sm font-medium text-gray-700">Versi</label>
                    <div class="mt-1">
                        <input id="versi" name="versi" type="number"
                               value="{{ old('versi', $aplikasi->versi) }}"
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div id="error-versi" class="text-red-500 text-xs mt-1"></div>
                </div>
                <div>
                    <label for="rating_konten" class="block text-sm font-medium text-gray-700">Rating Konten</label>
                    <div class="mt-1">
                        <input id="rating_konten" name="rating_konten" type="text"
                               value="{{ old('rating_konten', $aplikasi->rating_konten) }}"
                               class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');" onblur="if(this.value && !this.value.endsWith('+')) this.value = this.value + '+'">
                    </div>
                    <div id="error-rating_konten" class="text-red-500 text-xs mt-1"></div>
                </div>
            </div>

            <div>
                <label for="tautan_aplikasi" class="block text-sm font-medium text-gray-700">Tautan Aplikasi</label>
                <div class="mt-1">
                    <input id="tautan_aplikasi" name="tautan_aplikasi" type="url" value="{{ old('tautan_aplikasi', $aplikasi->tautan_aplikasi) }}" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>
                <div id="error-tautan_aplikasi" class="text-red-500 text-xs mt-1"></div>
            </div>

            <div class="mb-6">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">{{ old('deskripsi', $aplikasi->deskripsi) }}</textarea>
                <div id="error-deskripsi" class="text-red-500 text-xs mt-1"></div>
            </div>

            <div class="mb-6">
                <label for="fitur" class="block text-sm font-medium text-gray-700">Fitur</label>
                <textarea name="fitur" id="fitur" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">{{ old('fitur', $aplikasi->fitur) }}</textarea>
                <div id="error-fitur" class="text-red-500 text-xs mt-1"></div>
            </div>


            <div class="flex items-center justify-end space-x-4">
                <a href="{{ route('tambah_aplikasi.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                    Batal
                </a>
                <button type="submit" id="submitButton" class="group relative flex justify-center py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition-all duration-200">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    const fotoAplikasiInput = document.getElementById('foto_aplikasi');
    const previewContainer = document.getElementById('preview');
    let filesArray = []; // Store File objects for new photos
    let existingPhotos = @json($aplikasi->path_foto ? json_decode($aplikasi->path_foto) : []); // Store paths of existing photos

    // Get general message containers
    const generalErrorMessageContainer = document.getElementById('generalErrorMessage');
    const generalErrorText = document.getElementById('generalErrorText');
    const generalErrorDetailsList = document.getElementById('generalErrorDetails');

    // Populate filesArray with existing photos for consistent handling
    // We'll treat existing photos as "files" in the array for rendering, but they won't be re-uploaded.
    // They will be handled by sending their paths if they remain, or removed if the user deletes them.
    existingPhotos.forEach(path => {
        filesArray.push({
            name: path.substring(path.lastIndexOf('/') + 1),
            size: 0, // Placeholder
            type: 'image/jpeg', // Placeholder
            isExisting: true, // Custom property to mark it as an existing file
            path: path // Store the original path
        });
    });

    fotoAplikasiInput.addEventListener('change', (e) => {
        const newFiles = Array.from(e.target.files);
        filesArray = filesArray.concat(newFiles);
        renderPreview();
        fotoAplikasiInput.value = ''; // Clear input to allow re-selection
    });

    function renderPreview() {
        previewContainer.innerHTML = ''; // Clear existing previews

        filesArray.forEach((file, index) => {
            const wrapper = document.createElement('div');
            wrapper.classList.add('relative', 'w-24', 'h-24');

            const img = document.createElement('img');
            img.src = file.isExisting ? `{{ asset('storage') }}/${file.path}` : URL.createObjectURL(file);
            img.classList.add('object-cover', 'w-full', 'h-full', 'rounded');

            const removeBtn = document.createElement('button');
            removeBtn.innerHTML = '✕';
            removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'text-xs', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'shadow');
            removeBtn.type = 'button'; // Prevent form submission
            removeBtn.onclick = () => {
                // If it's an existing file, we need to handle its removal on the server
                if (file.isExisting) {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'removed_photos[]';
                    hiddenInput.value = file.path; // Send the path of the photo to be removed
                    document.getElementById('aplikasiForm').appendChild(hiddenInput);
                }

                filesArray.splice(index, 1); // Remove file from array
                renderPreview(); // Re-render preview
            };

            wrapper.appendChild(img);
            wrapper.appendChild(removeBtn);
            previewContainer.appendChild(wrapper);
        });
    }

    // Call renderPreview on page load to display existing photos
    document.addEventListener('DOMContentLoaded', renderPreview);


    // Logo handling
    const logoInput = document.getElementById('logo');
    const logoPreviewContainer = document.getElementById('logo-preview-container');
    let logoFile = null; // To store the new logo file

    // Initialize logo preview with existing logo if available
    if ("{{ $aplikasi->logo }}") {
        logoPreviewContainer.innerHTML = `
            <div class="relative w-24 h-24">
                <img src="{{ asset('storage/' . $aplikasi->logo) }}" alt="Logo Aplikasi" class="object-cover w-full h-full rounded">
                <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center shadow remove-current-logo" data-logo-path="{{ $aplikasi->logo }}">✕</button>
            </div>
        `;
    }

    logoInput.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            logoFile = file;
            const reader = new FileReader();
            reader.onload = (e) => {
                logoPreviewContainer.innerHTML = `
                    <div class="relative w-24 h-24">
                        <img src="${e.target.result}" alt="New Logo" class="object-cover w-full h-full rounded">
                        <button type="button" class="absolute top-0 right-0 bg-red-500 text-white rounded-full text-xs w-5 h-5 flex items-center justify-center shadow remove-new-logo">✕</button>
                    </div>
                `;
                // Add event listener for the new remove button
                document.querySelector('.remove-new-logo').onclick = () => {
                    logoFile = null;
                    logoInput.value = ''; // Clear the input
                    logoPreviewContainer.innerHTML = '';
                };
            };
            reader.readAsDataURL(file);
        } else {
            logoFile = null;
            logoPreviewContainer.innerHTML = ''; // Clear preview if no file selected
        }
    });

    // Handle removal of existing logo
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('remove-existing-logo')) {
            const logoPath = e.target.dataset.logoPath;
            const hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'remove_logo'; // Indicate that the existing logo should be removed
            hiddenInput.value = logoPath;
            document.getElementById('aplikasiForm').appendChild(hiddenInput);

            logoPreviewContainer.innerHTML = ''; // Clear preview
            logoFile = null; // Ensure no new logo is selected either
            logoInput.value = ''; // Clear the input field
        }
    });


    // Function to clear all inline error messages
    function clearErrors() {
        // Clear all divs whose ID starts with 'error-'
        document.querySelectorAll('[id^="error-"]').forEach(el => {
            el.textContent = '';
            el.classList.add('hidden'); // Ensure it's hidden when cleared
        });
        generalErrorMessageContainer.classList.add('hidden');
        generalErrorDetailsList.innerHTML = '';
        generalErrorText.textContent = ''; // Clear the general error text as well
    }

    document.getElementById('aplikasiForm').addEventListener('submit', async function(e) {
        e.preventDefault(); // Prevent traditional form submission

        clearErrors(); // Clear previous errors

        let hasClientErrors = false; // Flag to track client-side errors

        // --- Client-Side Validation for Each Field ---

        // Validasi Foto Aplikasi (minimal 1 file total, new or existing)
        const pathFotoErrorDiv = document.getElementById('error-path_foto');
        const activePhotosCount = filesArray.filter(file => !file.isExisting || (file.isExisting && !document.querySelector(`input[name="removed_photos[]"][value="${file.path}"]`))).length;

        if (activePhotosCount === 0) {
            pathFotoErrorDiv.textContent = 'Minimal satu foto aplikasi harus ada.';
            pathFotoErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Nama Aplikasi
        const namaAplikasiInput = document.getElementById('nama_aplikasi');
        const namaAplikasiErrorDiv = document.getElementById('error-nama_aplikasi');
        if (namaAplikasiInput.value.trim() === '') {
            namaAplikasiErrorDiv.textContent = 'Nama Aplikasi tidak boleh kosong.';
            namaAplikasiErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Pemilik
        const pemilikInput = document.getElementById('pemilik');
        const pemilikErrorDiv = document.getElementById('error-nama_pemilik');
        if (pemilikInput.value.trim() === '') {
            pemilikErrorDiv.textContent = 'Nama Pemilik tidak boleh kosong.';
            pemilikErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Kategori
        const kategoriSelect = document.getElementById('id_kategori');
        const kategoriErrorDiv = document.getElementById('error-id_kategori');
        if (kategoriSelect.value === '' || kategoriSelect.value === 'Pilih Kategori') {
            kategoriErrorDiv.textContent = 'Kategori harus dipilih.';
            kategoriErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Tanggal Rilis
        const tanggalRilisInput = document.getElementById('tanggal_rilis');
        const tanggalRilisErrorDiv = document.getElementById('error-tanggal_rilis');
        if (tanggalRilisInput.value.trim() === '') {
            tanggalRilisErrorDiv.textContent = 'Tanggal Rilis tidak boleh kosong.';
            tanggalRilisErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Versi
        const versiInput = document.getElementById('versi');
        const versiValue = parseInt(versiInput.value, 10);
        const versiErrorDiv = document.getElementById('error-versi');
        if (isNaN(versiValue) || versiValue <= 0) {
            versiErrorDiv.textContent = 'Versi aplikasi tidak boleh 0. Harap masukkan nilai lebih dari 0.';
            versiErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Rating Konten
        const ratingKontenInput = document.getElementById('rating_konten');
        const ratingKontenErrorDiv = document.getElementById('error-rating_konten');
        if (ratingKontenInput.value.trim() === '') {
            ratingKontenErrorDiv.textContent = 'Rating Konten tidak boleh kosong.';
            ratingKontenErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        } else if (!/^\d+\+?$/.test(ratingKontenInput.value.trim())) {
            ratingKontenErrorDiv.textContent = 'Format Rating Konten tidak valid (contoh: "3+", "7+").';
            ratingKontenErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Tautan Aplikasi
        const tautanAplikasiInput = document.getElementById('tautan_aplikasi');
        const tautanAplikasiErrorDiv = document.getElementById('error-tautan_aplikasi');
        if (tautanAplikasiInput.value.trim() === '') {
            tautanAplikasiErrorDiv.textContent = 'Tautan Aplikasi tidak boleh kosong.';
            tautanAplikasiErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        } else {
            try {
                new URL(tautanAplikasiInput.value.trim());
            } catch (_) {
                tautanAplikasiErrorDiv.textContent = 'Format Tautan Aplikasi tidak valid.';
                tautanAplikasiErrorDiv.classList.remove('hidden');
                hasClientErrors = true;
            }
        }

        // Validasi Deskripsi
        const deskripsiTextarea = document.getElementById('deskripsi');
        const deskripsiErrorDiv = document.getElementById('error-deskripsi');
        if (deskripsiTextarea.value.trim() === '') {
            deskripsiErrorDiv.textContent = 'Deskripsi tidak boleh kosong.';
            deskripsiErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Fitur
        const fiturTextarea = document.getElementById('fitur');
        const fiturErrorDiv = document.getElementById('error-fitur');
        if (fiturTextarea.value.trim() === '') {
            fiturErrorDiv.textContent = 'Fitur tidak boleh kosong.';
            fiturErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }

        // Validasi Logo (only if no existing logo and no new file selected)
        const currentLogoPath = "{{ $aplikasi->logo }}";
        const logoErrorDiv = document.getElementById('error-logo');
        const removeLogoInput = document.querySelector('input[name="remove_logo"]');

        if (!currentLogoPath && !logoFile) { // No existing logo, and no new logo file selected
             logoErrorDiv.textContent = 'Logo aplikasi harus diunggah.';
             logoErrorDiv.classList.remove('hidden');
             hasClientErrors = true;
        } else if (currentLogoPath && removeLogoInput && !logoFile) { // Existing logo marked for removal, but no new logo selected
            logoErrorDiv.textContent = 'Jika logo lama dihapus, logo baru harus diunggah.';
            logoErrorDiv.classList.remove('hidden');
            hasClientErrors = true;
        }


        // If there are any client-side errors, stop form submission
        if (hasClientErrors) {
            const submitButton = document.getElementById('submitButton');
            submitButton.disabled = false;
            submitButton.textContent = 'Simpan Perubahan';
            return; // Stop the function here
        }

        // If no client-side errors, proceed with server submission
        const submitButton = document.getElementById('submitButton');
        submitButton.disabled = true;
        submitButton.textContent = 'Menyimpan Perubahan...'; // Show loading text

        const formData = new FormData(this);

        // Append only new files for path_foto[]
        filesArray.forEach((file) => {
            if (!file.isExisting) {
                formData.append('path_foto[]', file);
            }
        });

        // Add logo file if a new one is selected
        if (logoFile) {
            formData.append('logo', logoFile);
        }

        // Remove the 'path_foto' and 'logo' fields that might be empty or contain old data
        // because we are manually appending the files to formData.
        // This is important to avoid sending empty file inputs if no new files are chosen.
        formData.delete('path_foto[]');
        formData.delete('logo');


        // Manually append existing photos that were NOT removed
        const keptPhotos = filesArray.filter(file => file.isExisting && !document.querySelector(`input[name="removed_photos[]"][value="${file.path}"]`));
        keptPhotos.forEach(file => {
            formData.append('existing_path_foto[]', file.path);
        });
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(this.action, {
                method: 'POST', // Method is PUT, but FormData with files needs POST
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    // 'Content-Type': 'multipart/form-data' is NOT set manually
                    // as fetch with FormData handles it automatically
                }
            });

            const data = await response.json(); // Always try to parse as JSON

            if (response.ok) { // Check if status is 2xx (successful response)
                if (data.success) {
                    Swal.fire({ // Show SweetAlert success popup
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    }).then(() => {
                        window.location.href = data.redirect; // Redirect
                    });
                } else {
                    generalErrorText.textContent = data.message || 'Terjadi kesalahan yang tidak terduga. Silakan coba lagi.';
                    generalErrorMessageContainer.classList.remove('hidden');
                }
            } else { // Handle non-2xx responses (e.g., 422 validation errors, 500 server errors)
                generalErrorText.textContent = data.message || 'Terjadi kesalahan saat menyimpan data.';
                if (data.errors) {
                    // Display inline errors for specific fields
                    for (const key in data.errors) {
                        const errorIdKey = key.includes('path_foto') ? 'path_foto' : key;
                        const errorDiv = document.getElementById(`error-${errorIdKey}`);
                        if (errorDiv) {
                            errorDiv.textContent = data.errors[key].join(', ');
                            errorDiv.classList.remove('hidden');
                        } else {
                            const listItem = document.createElement('li');
                            listItem.textContent = `${key}: ${data.errors[key].join(', ')}`;
                            generalErrorDetailsList.appendChild(listItem);
                        }
                    }
                }
                generalErrorMessageContainer.classList.remove('hidden');
            }
        } catch (error) {
            console.error('Error:', error);
            generalErrorText.textContent = 'Terjadi kesalahan jaringan atau sistem. Pastikan Anda terhubung ke internet dan coba lagi.';
            generalErrorMessageContainer.classList.remove('hidden');
        } finally {
            submitButton.disabled = false;
            submitButton.textContent = 'Simpan Perubahan'; // Reset button text
        }
    });

    // Event listener for rating_konten input to ensure format
    document.addEventListener('DOMContentLoaded', function() {
        const ratingKontenInput = document.getElementById('rating_konten');

        ratingKontenInput.addEventListener('input', function() {
            this.value = this.value.replace(/[^0-9]/g, '');
        });

        ratingKontenInput.addEventListener('blur', function() {
            if (this.value.trim() !== '' && !this.value.endsWith('+')) {
                this.value = this.value + '+';
            }
        });

        ratingKontenInput.addEventListener('focus', function() {
            if (this.value.endsWith('+')) {
                this.value = this.value.slice(0, -1);
            }
        });
    });
</script>
@endsection