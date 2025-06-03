@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-grey-100 flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8 font-sans">
    <div class="max-w-4xl w-full bg-white p-8 rounded-lg shadow-xl space-y-6">
        <h2 class="text-xl font-semibold text-gray-900 text-center">
            Tambah Aplikasi
        </h2>

        <form class="mt-8 space-y-6" action="#" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="border-2 border-dashed border-gray-300 rounded-lg p-4 text-center cursor-pointer hover:border-gray-400">
                <input type="file" id="foto_aplikasi" name="foto_aplikasi" class="hidden">
                <label for="foto_aplikasi" class="flex flex-col items-center justify-center h-80">
                    <svg class="mx-auto h-20 w-12 text-gray-400" stroke="currentColor" fill="none" viewBox="0 0 48 48" aria-hidden="true">
                        <path d="M28 8H12a4 4 0 00-4 4v20m32-12v8m0 0v8a4 4 0 01-4 4H12a4 4 0 01-4-4v-4m32-4l-3.172-3.172a4 4 0 00-5.656 0L28 28M8 32l9.172-9.172a4 4 0 015.656 0L40 32" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                    <span class="mt-2 block text-sm font-medium text-gray-900">
                        Unggah Foto Aplikasi
                    </span>
                </label>
            </div>

            <div>
                <div class="mt-4">
                    <label for="gambar_0_file" class="block text-sm font-medium text-gray-700">Logo</label>
                    <input type="file" name="logo" id="logo" class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-white focus:outline-none file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-red-50 file:text-red-700 hover:file:bg-red-100" accept="image/*">
                <div class="mt-1 flex items-center space-x-2"></div>
                </div>
            </div>

            <div>
                <label for="nama_aplikasi" class="block text-sm font-medium text-gray-700">Nama Aplikasi</label>
                <div class="mt-1">
                    <input id="nama_aplikasi" name="nama_aplikasi" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>

            <div>
                <label for="pemilik" class="block text-sm font-medium text-gray-700">Pemilik</label>
                <div class="mt-1">
                    <input id="pemilik" name="pemilik" type="text" required class="appearance-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label for="jenis_kategori" class="block text-sm font-medium text-gray-700">Kategori</label>
                    <div class="mt-1">
                        <select id="jenis_kategori" name="jenis_kategori" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                            <option value="">Pilih kategori</option>
                            <option value="game">Game</option>
                            <option value="produktifitas">Produktifitas</option>
                            <option value="hiburan">Hiburan</option>
                            <option value="sosial">Sosial</option>
                            <option value="edukasi">Edukasi</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label for="tanggal_rilis" class="block text-sm font-medium text-gray-700">Tanggal Rilis</label>
                    <div class="mt-1 relative">
                        <input id="tanggal_rilis" name="tanggal_rilis" type="date" class="appearance-none relative block w-full px-3 py-2 border border-gray-300 text-gray-900 rounded-md focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none">
                                <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd" />
                            </svg>
                        </span>
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

            <div id="dynamic-content" class="space-y-6">
                {{-- Paragraf dan gambar akan ditambahkan di sini oleh JavaScript --}}
                <div id="block-0">
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Deskripsi</h3>
                    <div class="mt-4">
                        <textarea name="paragrafs[0][content]" id="paragraf_0_content" rows="8" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required></textarea>
                    </div>
                </div>
            </div>

            {{-- Tambahkan bagian untuk Fitur di sini, mirip dengan Deskripsi --}}
            <div>
                <h3 class="text-lg font-semibold mb-3 text-gray-800">Fitur</h3>
                <div class="mt-4">
                    <textarea id="fitur_content" name="fitur" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-purple-500 focus:border-purple-500 sm:text-sm"></textarea>
                </div>
            </div>

            <div class="flex items-center justify-end space-x-4">
                    <a href="{{ route('user_login.aplikasi.index') }}" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2">
                        Batal
                    </a>
                <button type="submit" class="group relative flex justify-center py-2 px-6 border border-transparent text-sm font-medium rounded-md text-white bg-red-700 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-700 transition-all duration-200">
                    Simpan
                </button>
            </div>
        </form>
    </div>
</div>

<script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
<script>
    // Menampilkan nama file yang dipilih untuk input logo
    document.getElementById('logo').addEventListener('change', function() {
        var fileName = this.files[0] ? this.files[0].name : 'No file chosen';
        document.getElementById('file-chosen').textContent = fileName;
    });

    document.addEventListener('DOMContentLoaded', function() {
        let blockCount = 1;
        const dynamicContent = document.getElementById('dynamic-content');
        const addBlockButton = document.getElementById('add-block'); // Pastikan tombol ini ada di HTML jika ingin berfungsi

        const editors = {};

        // Fungsi untuk membuat CKEditor dengan konfigurasi yang diinginkan
        function createCKEditor(elementId, initialContent = '') {
            ClassicEditor
                .create(document.querySelector(elementId), {
                    removePlugins: [
                        'Image',
                        'ImageCaption',
                        'ImageStyle',
                        'ImageToolbar',
                        'ImageUpload',
                        'EasyImage',
                        'Base64UploadAdapter',
                        'CKFinder',
                        'MediaEmbed',
                        'Link'
                    ],
                    toolbar: {
                        items: [
                            'heading',
                            '|',
                            'bold',
                            'italic',
                            'bulletedList',
                            'numberedList',
                            '|',
                            'outdent',
                            'indent',
                            '|',
                            'blockQuote',
                            'undo',
                            'redo'
                        ]
                    }
                })
                .then(editor => {
                    editors[elementId.replace('#', '')] = editor; // Store by full ID for easy lookup
                    editor.setData(initialContent); // Set initial content if provided
                })
                .catch(error => {
                    console.error('There was an error initializing the CKEditor for ' + elementId + ':', error);
                });
        }

        // Inisialisasi CKEditor untuk textarea Deskripsi
        createCKEditor('#paragraf_0_content');

        // Inisialisasi CKEditor untuk textarea Fitur
        // Ambil konten yang mungkin sudah ada di textarea Fitur jika ada
        const fiturTextarea = document.getElementById('fitur_content');
        const initialFiturContent = fiturTextarea ? fiturTextarea.value : '';
        createCKEditor('#fitur_content', initialFiturContent);


        // Ini adalah bagian untuk menambahkan blok dinamis (paragraf/gambar)
        // Saya asumsikan Anda telah menghapus atau akan menghapus fungsionalitas ini
        // jika Anda hanya membutuhkan deskripsi dan fitur statis.
        // Jika Anda masih ingin menambahkan paragraf dinamis untuk deskripsi, biarkan kode ini.
        if (addBlockButton) {
            addBlockButton.addEventListener('click', function() {
                if (blockCount >= 5) {
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
                    <h3 class="text-lg font-semibold mb-3 text-gray-800">Paragraf ${blockCount + 1}</h3>
                    <button type="button" class="remove-block absolute top-2 right-2 text-red-600 hover:text-red-800 text-xl font-bold">&times;</button>
                    <div>
                        <label for="paragraf_${blockCount}_short_title" class="block text-sm font-medium text-gray-700">Judul Singkat Paragraf ${blockCount + 1}</label>
                        <input type="text" name="paragrafs[${blockCount}][short_title]" id="paragraf_${blockCount}_short_title" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm">
                    </div>
                    <div class="mt-4">
                        <label for="paragraf_${blockCount}_content" class="block text-sm font-medium text-gray-700">Isi Paragraf ${blockCount + 1}</label>
                        <textarea name="paragrafs[${blockCount}][content]" id="paragraf_${blockCount}_content" rows="5" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-red-500 focus:border-red-500 sm:text-sm" required></textarea>
                    </div>
                `;
                // Saya menghapus bagian gambar dinamis di sini
                dynamicContent.appendChild(newBlock);

                createCKEditor(`#paragraf_${blockCount}_content`); // Panggil fungsi dengan ID elemen

                newBlock.querySelector('.remove-block').addEventListener('click', function() {
                    const blockId = `paragraf_${newBlock.id.split('-')[1]}_content`; // Adjust ID for lookup
                    if (editors[blockId]) {
                        editors[blockId].destroy()
                            .catch(error => console.error('Error destroying editor:', error));
                        delete editors[blockId];
                    }
                    newBlock.remove();
                });

                blockCount++;
            });
        }


        // Handle form submission to ensure CKEditor content is updated
        const form = document.querySelector('form');
        form.addEventListener('submit', function() {
            for (const id in editors) {
                const editorInstance = editors[id];
                document.getElementById(id).value = editorInstance.getData();
            }
        });
    });
</script>
@endsection