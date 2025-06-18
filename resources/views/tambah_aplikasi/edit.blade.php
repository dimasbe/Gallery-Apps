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

            <div id="preview" class="mt-4 flex flex-wrap gap-4"></div>
            <div id="error-path_foto" class="text-red-500 text-xs mt-1 hidden"></div>

            {{-- Input Logo --}}
            <div class="mt-4">
                <label for="logo_input_visual" class="block text-sm font-medium text-gray-700">Logo</label>
                <div class="mt-1 flex items-center border border-gray-300 rounded-md shadow-sm overflow-hidden">
                    <input type="file" id="logo_input" name="logo" class="hidden" accept="image/*">
                    <label for="logo_input" id="logo-file-label" class="bg-red-700 text-white px-4 py-2 cursor-pointer hover:bg-red-800 text-sm font-semibold rounded-l-md transition-colors duration-200" style="flex-shrink: 0;">
                        Choose File
                    </label>
                </div>
                <div id="logo-preview-container" class="mt-4 flex flex-wrap gap-4"></div>
                <div id="error-logo" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            {{-- Nama Aplikasi --}}
            <div class="mt-4">
                <label for="nama_aplikasi" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                <input id="nama_aplikasi" name="nama_aplikasi" type="text" required value="{{ old('nama_aplikasi', $aplikasi->nama_aplikasi) }}" class="mt-1 block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                <div id="error-nama_aplikasi" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            {{-- Pemilik --}}
            <div class="mt-4">
                <label for="pemilik" class="block text-sm font-medium text-gray-700">Pemilik</label>
                <input id="pemilik" name="nama_pemilik" type="text" required value="{{ old('nama_pemilik', $aplikasi->nama_pemilik) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                <div id="error-nama_pemilik" class="text-red-500 text-xs mt-1 hidden"></div>
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
                    <div id="error-id_kategori" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                {{-- Tanggal Rilis --}}
                <div>
                    <label for="tanggal_rilis" class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <input id="tanggal_rilis" name="tanggal_rilis" type="date" 
                        value="{{ old('tanggal_rilis', optional($aplikasi->tanggal_rilis)->format('Y-m-d')) }}"
                        class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-4">
                {{-- Versi --}}
                <div>
                    <label for="versi" class="block text-sm font-medium text-gray-700">Versi</label>
                    <input id="versi" name="versi" type="text" value="{{ old('versi', $aplikasi->versi) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <div id="error-versi" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>

                {{-- Rating Konten --}}
                <div>
                    <label for="rating_konten" class="block text-sm font-medium text-gray-700">Rating Konten</label>
                    <input id="rating_konten" name="rating_konten" type="text" value="{{ old('rating_konten', $aplikasi->rating_konten) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                    <div id="error-rating_konten" class="text-red-500 text-xs mt-1 hidden"></div>
                </div>
            </div>

            {{-- Tautan Aplikasi --}}
            <div class="mt-4">
                <label for="tautan_aplikasi" class="block text-sm font-medium text-gray-700">Tautan Aplikasi</label>
                <input id="tautan_aplikasi" name="tautan_aplikasi" type="url" value="{{ old('tautan_aplikasi', $aplikasi->tautan_aplikasi) }}" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500">
                <div id="error-tautan_aplikasi" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            {{-- Deskripsi --}}
            <div class="mt-4">
                <label for="deskripsi" class="block text-sm font-medium text-gray-700">Deskripsi</label>
                <textarea name="deskripsi" id="deskripsi" rows="4" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" required>{{ old('deskripsi', $aplikasi->deskripsi) }}</textarea>
                <div id="error-deskripsi" class="text-red-500 text-xs mt-1 hidden"></div>
            </div>

            {{-- Fitur --}}
            <div class="mt-4 mb-6">
                <label for="fitur" class="block text-sm font-medium text-gray-700">Fitur</label>
                <textarea name="fitur" id="fitur" rows="4" class="block w-full px-3 py-2 border rounded-md focus:ring-red-500 focus:border-red-500" required>{{ old('fitur', $aplikasi->fitur) }}</textarea>
                <div id="error-fitur" class="text-red-500 text-xs mt-1 hidden"></div>
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
    const $ = (id) => document.getElementById(id);
    const $$ = (selector) => document.querySelectorAll(selector);

    const fotoAplikasiInput = $('foto_aplikasi');
    const previewContainer = $('preview');
    const logoInput = $('logo_input');
    const logoFileLabel = $('logo-file-label');
    const logoPreviewContainer = $('logo-preview-container');
    const submitButton = $('submitButton');
    const aplikasiForm = $('aplikasiForm');
    const generalErrorMessageContainer = $('generalErrorMessage');
    const generalErrorText = $('generalErrorText');
    const generalErrorDetailsList = $('generalErrorDetails');
    const storageBaseUrl = "{{ asset('storage') }}";
    const aplikasiId = "{{ $aplikasi->id }}"; // Dapatkan ID Aplikasi

    let filesArray = []; // Untuk file baru yang akan diunggah
    let existingPhotosData = []; // [{id: 1, path: 'path/to/foto1.jpg'}, ...] untuk foto lama

    let currentLogoFile = null;
    let existingLogoPath = "{{ $aplikasi->logo }}";
    let isLogoDeleted = false; // Flag untuk menandakan logo lama dihapus

    let initialFormState = {};
    let initialExistingPhotosIds = []; // Untuk deteksi perubahan pada foto lama
    let initialExistingLogoPath = "";

    const createPreviewElement = (src, isNewFile, dataObject, type = 'app_photo') => {
        const wrapper = document.createElement('div');
        wrapper.classList.add('relative', 'w-24', 'h-24');

        const img = document.createElement('img');
        img.src = src;
        img.classList.add('object-cover', 'w-full', 'h-full', 'rounded');

        const removeBtn = document.createElement('button');
        removeBtn.innerHTML = '✕';
        removeBtn.classList.add('absolute', 'top-0', 'right-0', 'bg-red-500', 'text-white', 'rounded-full', 'text-xs', 'w-5', 'h-5', 'flex', 'items-center', 'justify-center', 'shadow');
        removeBtn.type = 'button';

        removeBtn.onclick = async () => {
            if (type === 'app_photo') {
                if (isNewFile) {
                    filesArray = filesArray.filter(file => file !== dataObject);
                } else {
                    // Ini adalah foto lama, hapus langsung dari DB tanpa konfirmasi
                    const photoIdToDelete = dataObject.id;
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch(`/tambah_aplikasi/${aplikasiId}/foto/${photoIdToDelete}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        });
                        const data = await response.json();

                        if (response.ok && data.success) {
                            existingPhotosData = existingPhotosData.filter(photo => photo.id !== photoIdToDelete);
                            Swal.fire('Berhasil!', 'Foto berhasil dihapus.', 'success');
                        } else {
                            Swal.fire('Gagal!', data.message || 'Gagal menghapus foto.', 'error');
                        }
                    } catch (error) {
                        console.error('Error deleting photo:', error);
                        Swal.fire('Gagal!', 'Terjadi kesalahan jaringan saat menghapus foto.', 'error');
                    }
                }
                renderAppPhotosPreview();
            } else if (type === 'logo') {
                if (isNewFile) {
                    currentLogoFile = null;
                    logoInput.value = '';
                } else {
                    // Ini adalah logo lama, hapus langsung dari DB tanpa konfirmasi
                    try {
                        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                        const response = await fetch(`/tambah_aplikasi/${aplikasiId}/logo`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': csrfToken,
                                'Content-Type': 'application/json'
                            }
                        });
                        const data = await response.json();

                        if (response.ok && data.success) {
                            existingLogoPath = null;
                            isLogoDeleted = true; // Set flag
                            Swal.fire('Berhasil!', 'Logo berhasil dihapus.', 'success');
                        } else {
                            Swal.fire('Gagal!', data.message || 'Gagal menghapus logo.', 'error');
                        }
                    } catch (error) {
                        console.error('Error deleting logo:', error);
                        Swal.fire('Gagal!', 'Terjadi kesalahan jaringan saat menghapus logo.', 'error');
                    }
                }
                renderLogoPreview();
            }
            checkForChanges();
        };

        wrapper.appendChild(img);
        wrapper.appendChild(removeBtn);
        return wrapper;
    };

    const renderAppPhotosPreview = () => {
        previewContainer.innerHTML = '';
        existingPhotosData.forEach(photo => {
            previewContainer.appendChild(createPreviewElement(`${storageBaseUrl}/${photo.path_foto}`, false, photo, 'app_photo'));
        });
        filesArray.forEach(file => {
            const reader = new FileReader();
            reader.onload = e => previewContainer.appendChild(createPreviewElement(e.target.result, true, file, 'app_photo'));
            reader.readAsDataURL(file);
        });
    };

    const renderLogoPreview = () => {
        logoPreviewContainer.innerHTML = '';
        if (currentLogoFile) {
            const reader = new FileReader();
            reader.onload = e => logoPreviewContainer.appendChild(createPreviewElement(e.target.result, true, null, 'logo'));
            reader.readAsDataURL(currentLogoFile);
            logoFileLabel.textContent = 'Logo Terpilih';
        } else if (existingLogoPath && !isLogoDeleted) { // Hanya tampilkan jika ada dan belum dihapus
            logoPreviewContainer.appendChild(createPreviewElement(`${storageBaseUrl}/${existingLogoPath}`, false, null, 'logo'));
            logoFileLabel.textContent = 'Logo Terpilih';
        } else {
            logoFileLabel.textContent = 'Choose File';
        }
    };

    const clearErrors = () => {
        $$('[id^="error-"]').forEach(el => {
            el.textContent = '';
            el.classList.add('hidden');
        });
        generalErrorMessageContainer.classList.add('hidden');
        generalErrorDetailsList.innerHTML = '';
    };

    const checkForChanges = () => {
        let formChanged = false;

        // Check text/select/textarea inputs
        Array.from(aplikasiForm.elements).forEach(element => {
            if (element.name && !['file', 'submit', '_token', '_method'].includes(element.type) && initialFormState[element.name] !== element.value) {
                formChanged = true;
            }
        });

        // Check app photos changes (new files added)
        if (filesArray.length > 0) formChanged = true;

        // Check for changes in existing photos (count of retained photos)
        const currentExistingPhotoIds = existingPhotosData.map(photo => photo.id).sort().join(',');
        const initialExistingPhotoIdsStr = initialExistingPhotosIds.sort().join(',');
        if (currentExistingPhotoIds !== initialExistingPhotoIdsStr) {
            formChanged = true;
        }

        // Check logo changes
        if (currentLogoFile !== null) formChanged = true;
        // Jika logoPath berubah dari ada menjadi null (dihapus langsung), itu adalah perubahan
        else if (isLogoDeleted || (initialExistingLogoPath && !existingLogoPath)) { // Changed: initial exists, now it's null
            formChanged = true;
        }

        submitButton.disabled = !formChanged;
    };

    document.addEventListener('DOMContentLoaded', () => {
        @if($aplikasi->fotoAplikasi->isNotEmpty())
            @foreach($aplikasi->fotoAplikasi as $foto)
                existingPhotosData.push({ id: {{ $foto->id }}, path_foto: "{{ $foto->path_foto }}" });
            @endforeach
        @endif
        initialExistingPhotosIds = existingPhotosData.map(photo => photo.id); // Simpan ID awal

        renderAppPhotosPreview();
        renderLogoPreview();
        initialExistingLogoPath = existingLogoPath; // Simpan path logo awal

        Array.from(aplikasiForm.elements).forEach(element => {
            if (element.name && !['file', 'submit', '_token', '_method'].includes(element.type)) {
                initialFormState[element.name] = element.value;
            }
        });

        ['input', 'change', 'keyup', 'paste'].forEach(event => aplikasiForm.addEventListener(event, checkForChanges));
        submitButton.disabled = true; // Dinonaktifkan di awal
    });

    fotoAplikasiInput.addEventListener('change', (e) => {
        filesArray = filesArray.concat(Array.from(e.target.files));
        renderAppPhotosPreview();
        fotoAplikasiInput.value = '';
        checkForChanges();
    });

    logoInput.addEventListener('change', (e) => {
        currentLogoFile = e.target.files[0] || null;
        if (currentLogoFile) {
            isLogoDeleted = false; // Jika upload logo baru, batalkan status deleted
        }
        renderLogoPreview();
        checkForChanges();
    });

    aplikasiForm.addEventListener('submit', async function(e) {
        e.preventDefault();
        clearErrors();

        submitButton.disabled = true;
        submitButton.textContent = 'Menyimpan...';

        const formData = new FormData();
        Array.from(this.elements).forEach(element => {
            if (element.name && !['path_foto[]', 'logo', 'submit'].includes(element.name) && element.type !== 'submit') {
                if (!(element.type === 'date' && element.value === '')) {
                    formData.append(element.name, element.value);
                }
            }
        });

        // Handle Logo: hanya kirim file baru jika ada
        if (currentLogoFile) {
            formData.append('logo', currentLogoFile);
        }
        // Tidak perlu mengirim 'logo_deleted' lagi jika penghapusan logo sudah ditangani di backend
        // secara instan saat tombol 'X' diklik.
        // Jika logo_id di Aplikasi di set null oleh penghapusan instan, itu sudah cukup.
        // ATAU jika Anda ingin mengirim sinyal, tetap bisa:
        // if (isLogoDeleted && !currentLogoFile) {
        //     formData.append('logo_deleted_on_submit', '1');
        // }


        // Handle App Photos: Hanya kirim file baru
        filesArray.forEach(file => formData.append('path_foto[]', file));

        formData.append('_method', 'PUT');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        try {
            const response = await fetch(this.action, { method: 'POST', body: formData, headers: { 'X-CSRF-TOKEN': csrfToken } });
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
                 }).then(() => 
                    {
                        window.location.href = data.redirect;
                });
            } else {
                generalErrorText.textContent = data.message || 'Terjadi kesalahan saat menyimpan data.';
                if (data.errors) {
                    for (const key in data.errors) {
                        const errorKey = key.includes('path_foto') ? 'path_foto' : key;
                        const errorDiv = $(`error-${errorKey}`);
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
            submitButton.textContent = 'Simpan';
        }
    });
</script>
@endsection