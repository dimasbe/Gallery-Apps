@extends('layouts.admin') 

@section('content')
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

<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-2xl font-bold mb-6 text-red-800 text-center">Formulir Berita</h1>

    {{-- Form untuk menambahkan berita --}}
    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Bagian Judul Berita --}}
        <div>
            <label for="judul_berita" class="block text-sm font-medium text-gray-700">Judul Berita</label>
            <input type="text" name="judul_berita" id="judul_berita" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required>
            @error('judul_berita')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bagian Penulis --}}
        <div>
            <label for="penulis" class="block text-sm font-medium text-gray-700">Penulis</label>
            <input type="text" name="penulis" id="penulis" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required>
            @error('penulis')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bagian Kategori --}}
        <div>
            <label for="kategori_id" class="block text-sm font-medium text-gray-700">Kategori</label>
            <select name="kategori_id" id="kategori_id" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required>
                <option value="">Pilih Kategori</option>
                {{-- Asumsi Anda passing variabel $kategoris dari controller --}}
                @foreach($kategoris as $kategori)
                    <option value="{{ $kategori->id }}">{{ $kategori->nama_kategori }}</option>
                @endforeach
            </select>
            @error('kategori_id')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bagian Unggah Thumbnail Berita --}}
        <div>
            <label for="thumbnail" class="block text-sm font-medium text-gray-700">Unggah Thumbnail Berita</label>
            <input type="file" name="thumbnail" id="thumbnail" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" accept="image/*" required>
            @error('thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bagian Keterangan Thumbnail --}}
        <div>
            <label for="keterangan_thumbnail" class="block text-sm font-medium text-gray-700">Keterangan Thumbnail</label>
            <textarea name="keterangan_thumbnail" id="keterangan_thumbnail" rows="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
            @error('keterangan_thumbnail')
                <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Bagian Dinamis untuk Paragraf dan Gambar --}}
        <div class="pt-4 flex items-center space-x-2">
            <h1 class="text-xl font-bold text-black">Isi Berita</h1>
            {{-- Tombol Tambah Paragraf & Gambar --}}
            <button type="button" id="add-block" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">
                Tambah Paragraf & Gambar
            </button>
        </div>

        <div id="dynamic-content" class="space-y-6">
            {{-- Paragraf dan gambar akan ditambahkan di sini oleh JavaScript --}}
            <div class="border border-gray-300 p-4 rounded-md bg-white" id="block-0">
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Paragraf 1 & Gambar 1</h3>
                <div>
                    <label for="paragraf_0_short_title" class="block text-sm font-medium text-gray-700">Judul Singkat Paragraf 1</label>
                    <input type="text" name="paragrafs[0][short_title]" id="paragraf_0_short_title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>
                <div class="mt-4">
                    <label for="paragraf_0_content" class="block text-sm font-medium text-gray-700">Isi Paragraf 1</label>
                    <textarea name="paragrafs[0][content]" id="paragraf_0_content" rows="5" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required></textarea>
                </div>
                <div class="mt-4">
                    <label for="gambar_0_file" class="block text-sm font-medium text-gray-700">Unggah Gambar 1</label>
                    <input type="file" name="images[0][file]" id="gambar_0_file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" accept="image/*">
                </div>
                <div class="mt-4">
                    <label for="gambar_0_caption" class="block text-sm font-medium text-gray-700">Keterangan Gambar 1</label>
                    <textarea name="images[0][caption]" id="gambar_0_caption" rows="1" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
                </div>
            </div>
        </div>

        {{-- Tombol Submit dan Batal --}}
        <div class="pt-6 flex justify-end space-x-4">
            <a href="{{ route('admin.berita.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                Batal
            </a>
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">
                Simpan Berita
            </button>
        </div>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        let blockCount = 1; // Mulai dari 1 karena block-0 sudah ada secara statis
        const dynamicContent = document.getElementById('dynamic-content');
        const addBlockButton = document.getElementById('add-block');

        addBlockButton.addEventListener('click', function() {
            if (blockCount >= 5) { // Batasi hingga 5 paragraf/gambar tambahan (total 6 termasuk yang pertama)
                const modalDiv = document.createElement('div');
                modalDiv.className = 'fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full flex items-center justify-center z-50';
                modalDiv.innerHTML = `
                    <div class="bg-white p-6 rounded-lg shadow-xl max-w-sm mx-auto">
                        <h2 class="text-xl font-bold mb-4 text-center">Batas Maksimal Terlampaui</h2>
                        <p class="text-gray-700 mb-6">Maksimal 5 paragraf dan gambar tambahan dapat ditambahkan.</p>
                        <div class="flex justify-end">
                            <button type="button" id="close-modal" class="px-4 py-2 bg-red-700 text-white rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700">Tutup</button>
                        </div>
                    </div>
                `;
                document.body.appendChild(modalDiv);

                document.getElementById('close-modal').addEventListener('click', function() {
                    modalDiv.remove();
                });
                return;
            }

            const newBlock = document.createElement('div');
            newBlock.id = `block-${blockCount}`;
            newBlock.className = 'border border-gray-200 p-4 rounded-md bg-gray-50 relative';
            newBlock.innerHTML = `
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Paragraf ${blockCount + 1} & Gambar ${blockCount + 1}</h3>
                <button type="button" class="remove-block absolute top-2 right-2 text-red-600 hover:text-red-800 text-xl font-bold">&times;</button>
                <div>
                    <label for="paragraf_${blockCount}_short_title" class="block text-sm font-medium text-gray-700">Judul Singkat Paragraf ${blockCount + 1}</label>
                    <input type="text" name="paragrafs[${blockCount}][short_title]" id="paragraf_${blockCount}_short_title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                </div>
                <div class="mt-4">
                    <label for="paragraf_${blockCount}_content" class="block text-sm font-medium text-gray-700">Isi Paragraf ${blockCount + 1}</label>
                    <textarea name="paragrafs[${blockCount}][content]" id="paragraf_${blockCount}_content" rows="5" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required></textarea>
                </div>
                <div class="mt-4">
                    <label for="gambar_${blockCount}_file" class="block text-sm font-medium text-gray-700">Unggah Gambar ${blockCount + 1}</label>
                    <input type="file" name="images[${blockCount}][file]" id="gambar_${blockCount}_file" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" accept="image/*">
                </div>
                <div class="mt-4">
                    <label for="gambar_${blockCount}_caption" class="block text-sm font-medium text-gray-700">Keterangan Gambar ${blockCount + 1}</label>
                    <textarea name="images[${blockCount}][caption]" id="gambar_${blockCount}_caption" rows="2" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm"></textarea>
                </div>
            `;
            dynamicContent.appendChild(newBlock);

            // Tambahkan event listener untuk tombol hapus
            newBlock.querySelector('.remove-block').addEventListener('click', function() {
                newBlock.remove();
                // Optionally re-index the remaining blocks if needed for continuous numbering,
                // but for form submission with array keys, it's often not strictly necessary.
            });

            blockCount++;
        });
    });
</script>
@endsection