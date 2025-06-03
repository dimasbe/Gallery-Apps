@extends('layouts.admin')

@section('content')
    <div class="container mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Berita</h1>

        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-error mb-4">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="judul_berita" class="form-label">Judul Berita</label>
                <input type="text" name="judul_berita" id="judul_berita" class="form-input" value="{{ old('judul_berita', $berita->judul_berita) }}" required>
                @error('judul_berita')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="penulis" class="form-label">Penulis</label>
                <input type="text" name="penulis" id="penulis" class="form-input" value="{{ old('penulis', $berita->penulis) }}" required>
                @error('penulis')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="isi_berita" class="form-label">Isi Berita</label>
                <textarea name="isi_berita" id="isi_berita" class="form-textarea" rows="10" required>{{ old('isi_berita', $berita->isi_berita) }}</textarea>
                @error('isi_berita')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="kategori_ids" class="form-label">Kategori</label>
                <select name="kategori_ids[]" id="kategori_ids" class="form-select" multiple required>
                    <option value="">Pilih Kategori</option>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}" {{ in_array($kategori->id, old('kategori_ids', $selectedKategoris)) ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
                @error('kategori_ids')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                @error('kategori_ids.*')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <div class="form-group">
                <label for="thumbnail" class="form-label">Thumbnail Berita (Biarkan kosong jika tidak ingin mengubah)</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-input" accept="image/*" onchange="previewImage(event, 'thumbnail-preview')">
                @error('thumbnail')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                <div id="thumbnail-preview" class="image-preview-container mt-2">
                    @php
                        $currentThumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
                    @endphp
                    @if ($currentThumbnail)
                        <div class="image-preview">
                            <img src="{{ asset('storage/' . $currentThumbnail->nama_gambar) }}" alt="Current Thumbnail">
                        </div>
                    @else
                        <div class="image-preview">
                            <img src="https://placehold.co/100x100/A0AEC0/FFFFFF?text=No+Thumbnail" alt="No Thumbnail">
                        </div>
                    @endif
                </div>
            </div>

            <div class="form-group">
                <label class="form-label">Gambar Tambahan</label>
                <div id="existing-additional-images" class="image-preview-container mb-4">
                    @foreach ($berita->fotoBeritas->where('tipe', 'tambahan') as $foto)
                        <div class="existing-image-item" id="existing-image-{{ $foto->id }}">
                            <img src="{{ asset('storage/' . $foto->nama_gambar) }}" alt="{{ $foto->keterangan_gambar ?? 'Gambar Tambahan' }}">
                            <p class="text-xs text-gray-600 mb-1">{{ $foto->keterangan_gambar }}</p>
                            <button type="button" class="remove-image-btn" onclick="markImageForDeletion({{ $foto->id }})">X</button>
                        </div>
                    @endforeach
                </div>

                <div id="additional-images-container">
                    </div>
                <button type="button" class="btn btn-secondary mt-4" onclick="addAdditionalImageField()">Tambah Gambar Lain</button>
                @error('nama_gambar_tambahan.*')
                    <p class="error-message">{{ $message }}</p>
                @enderror
                @error('keterangan_gambar_tambahan.*')
                    <p class="error-message">{{ $message }}</p>
                @enderror
            </div>

            <input type="hidden" name="deleted_image_ids" id="deleted_image_ids" value="[]">

            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui Berita</button>
            </div>
        </form>
    </div>

    <script>
        let additionalImageCount = 0;
        let deletedImageIds = [];

        function previewImage(event, previewId) {
            const previewContainer = document.getElementById(previewId);
            // If it's the thumbnail, clear only the current preview
            if (previewId === 'thumbnail-preview') {
                previewContainer.innerHTML = '';
            } else {
                // For additional images, append new previews
                // This function is designed for single file input preview, for multiple new inputs,
                // the `addAdditionalImageField` handles creating new preview containers.
            }

            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const imgDiv = document.createElement('div');
                    imgDiv.className = 'image-preview';
                    imgDiv.innerHTML = `<img src="${e.target.result}" alt="Image Preview">`;
                    previewContainer.appendChild(imgDiv);
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function addAdditionalImageField() {
            additionalImageCount++;
            const container = document.getElementById('additional-images-container');
            const newField = document.createElement('div');
            newField.className = 'flex items-center space-x-4 mb-4';
            newField.innerHTML = `
                <input type="file" name="nama_gambar_tambahan[]" class="form-input flex-grow" accept="image/*" onchange="previewImage(event, 'new-additional-image-preview-${additionalImageCount}')">
                <input type="text" name="keterangan_gambar_tambahan[]" class="form-input flex-grow" placeholder="Keterangan gambar (opsional)">
                <button type="button" class="btn btn-danger px-4 py-2" onclick="removeNewImageField(this)">Hapus</button>
            `;
            container.appendChild(newField);

            const newPreviewContainer = document.createElement('div');
            newPreviewContainer.id = `new-additional-image-preview-${additionalImageCount}`;
            newPreviewContainer.className = 'image-preview-container mt-2';
            container.appendChild(newPreviewContainer);
        }

        function removeNewImageField(button) {
            const fieldContainer = button.parentNode;
            // Find the corresponding preview container based on the input's onchange attribute
            const fileInput = fieldContainer.querySelector('input[type="file"]');
            if (fileInput) {
                const previewIdMatch = fileInput.getAttribute('onchange').match(/'(.*?)'/);
                if (previewIdMatch && previewIdMatch[1]) {
                    const previewContainer = document.getElementById(previewIdMatch[1]);
                    if (previewContainer) {
                        previewContainer.remove();
                    }
                }
            }
            if (fieldContainer) {
                fieldContainer.remove();
            }
        }

        function markImageForDeletion(imageId) {
            deletedImageIds.push(imageId);
            document.getElementById('deleted_image_ids').value = JSON.stringify(deletedImageIds);
            document.getElementById(`existing-image-${imageId}`).remove();
            alert('Gambar akan dihapus setelah berita diperbarui.'); // Using alert for simplicity, consider a custom modal
        }
    </script>
@endsection
