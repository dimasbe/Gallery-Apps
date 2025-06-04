@extends('layouts.admin')

@section('content')
    <div class="container mx-auto bg-white rounded-lg shadow-lg p-8">
        <h1 class="text-3xl font-bold text-gray-800 mb-6">Edit Berita</h1>

        {{-- Validasi Error --}}
        @if ($errors->any())
            <div class="alert alert-error mb-4">
                <ul class="list-disc list-inside text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Flash Error --}}
        @if (session('error'))
            <div class="alert alert-error mb-4 text-red-600">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.berita.update', $berita->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            {{-- Judul Berita --}}
            <div class="form-group mb-4">
                <label for="judul_berita" class="form-label font-semibold">Judul Berita</label>
                <input type="text" name="judul_berita" id="judul_berita" class="form-input w-full"
                    value="{{ old('judul_berita', $berita->judul_berita) }}" required>
            </div>

            {{-- Penulis --}}
            <div class="form-group mb-4">
                <label for="penulis" class="form-label font-semibold">Penulis</label>
                <input type="text" name="penulis" id="penulis" class="form-input w-full"
                    value="{{ old('penulis', $berita->penulis) }}" required>
            </div>

            {{-- Isi Berita --}}
            <div class="form-group mb-4">
                <label for="isi_berita" class="form-label font-semibold">Isi Berita</label>
                <textarea name="isi_berita" id="isi_berita" class="form-textarea w-full" rows="8"
                    required>{{ old('isi_berita', $berita->isi_berita) }}</textarea>
            </div>

            {{-- Kategori --}}
            <div class="form-group mb-4">
                <label for="kategori_ids" class="form-label font-semibold">Kategori</label>
                <select name="kategori_ids[]" id="kategori_ids" class="form-select w-full" multiple required>
                    @foreach ($kategoris as $kategori)
                        <option value="{{ $kategori->id }}"
                            {{ in_array($kategori->id, old('kategori_ids', $selectedKategoris)) ? 'selected' : '' }}>
                            {{ $kategori->nama_kategori }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Thumbnail --}}
            <div class="form-group mb-6">
                <label for="thumbnail" class="form-label font-semibold">Thumbnail Berita</label>
                <input type="file" name="thumbnail" id="thumbnail" class="form-input w-full" accept="image/*"
                    onchange="previewImage(event, 'thumbnail-preview')">
                <div id="thumbnail-preview" class="mt-2">
                    @php
                        $currentThumbnail = $berita->fotoBeritas->where('tipe', 'thumbnail')->first();
                    @endphp
                    <img src="{{ $currentThumbnail ? asset('storage/' . $currentThumbnail->nama_gambar) : 'https://placehold.co/100x100?text=No+Thumbnail' }}"
                         alt="Thumbnail"
                         class="w-24 h-24 object-cover mt-2">
                </div>
            </div>

            {{-- Gambar Tambahan --}}
            <div class="form-group mb-6">
                <label class="form-label font-semibold">Gambar Tambahan</label>

                {{-- Gambar Tambahan Lama --}}
                <div class="grid grid-cols-3 gap-4 mb-4" id="existing-additional-images">
                    @foreach ($berita->fotoBeritas->where('tipe', 'tambahan') as $foto)
                        <div class="relative border p-2 rounded" id="existing-image-{{ $foto->id }}">
                            <img src="{{ asset('storage/' . $foto->nama_gambar) }}" alt="Gambar Tambahan"
                                 class="w-full h-32 object-cover">
                            <p class="text-sm mt-1">{{ $foto->keterangan_gambar }}</p>
                            <button type="button" class="absolute top-1 right-1 bg-red-500 text-white text-xs px-2 py-1 rounded"
                                onclick="markImageForDeletion({{ $foto->id }})">X</button>
                        </div>
                    @endforeach
                </div>

                {{-- Gambar Tambahan Baru --}}
                <div id="additional-images-container"></div>
                <button type="button" class="btn btn-secondary mt-4" onclick="addAdditionalImageField()">Tambah Gambar</button>
                <input type="hidden" name="deleted_image_ids" id="deleted_image_ids" value="[]">
            </div>

            {{-- Tombol --}}
            <div class="flex justify-end space-x-4">
                <a href="{{ route('admin.berita.show', $berita->id) }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-primary">Perbarui</button>
            </div>
        </form>
    </div>

    {{-- Script Tambahan --}}
    <script>
        let additionalImageCount = 0;
        let deletedImageIds = [];

        function previewImage(event, previewId) {
            const previewContainer = document.getElementById(previewId);
            previewContainer.innerHTML = '';

            if (event.target.files && event.target.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" alt="Preview" class="w-24 h-24 object-cover mt-2">`;
                }
                reader.readAsDataURL(event.target.files[0]);
            }
        }

        function addAdditionalImageField() {
            additionalImageCount++;
            const container = document.getElementById('additional-images-container');
            const fieldHTML = `
                <div class="flex items-center gap-4 mb-4">
                    <input type="file" name="nama_gambar_tambahan[]" class="form-input w-1/2" accept="image/*"
                        onchange="previewImage(event, 'preview-${additionalImageCount}')">
                    <input type="text" name="keterangan_gambar_tambahan[]" class="form-input w-1/2" placeholder="Keterangan">
                    <button type="button" class="btn btn-danger" onclick="this.parentElement.remove()">Hapus</button>
                </div>
                <div id="preview-${additionalImageCount}" class="mb-4"></div>
            `;
            container.insertAdjacentHTML('beforeend', fieldHTML);
        }

        function markImageForDeletion(imageId) {
            deletedImageIds.push(imageId);
            document.getElementById('deleted_image_ids').value = JSON.stringify(deletedImageIds);
            const imageDiv = document.getElementById(`existing-image-${imageId}`);
            if (imageDiv) imageDiv.remove();
        }
    </script>
@endsection
