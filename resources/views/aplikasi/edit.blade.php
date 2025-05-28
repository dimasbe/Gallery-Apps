@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="card shadow-sm">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center">
            <a href="/aplikasi" class="text-decoration-none text-dark">
                <i class="fas fa-arrow-left me-2"></i>
                Kembali
            </a>
            <h5 class="mb-0 ms-auto me-auto text-center">Edit</h5>
        </div>
        <div class="card-body">
            <form action="/aplikasi/1" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                {{-- Bagian Gambar Aplikasi (Galeri) --}}
                <div class="mb-4 p-3 border rounded">
                    <label class="form-label mb-2">Gambar Aplikasi</label>
                    <div class="row row-cols-1 row-cols-md-4 g-3 mb-3">
                        {{-- Gambar yang sudah ada, statis sesuai gambar --}}
                        <div class="col">
                            <div class="card">
                                <img src="/storage/gambar1.jpg" class="card-img-top img-fluid" alt="Gambar Aplikasi" style="height: 100px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="/storage/gambar2.jpg" class="card-img-top img-fluid" alt="Gambar Aplikasi" style="height: 100px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="/storage/gambar3.jpg" class="card-img-top img-fluid" alt="Gambar Aplikasi" style="height: 100px; object-fit: cover;">
                            </div>
                        </div>
                        <div class="col">
                            <div class="card">
                                <img src="/storage/gambar4.jpg" class="card-img-top img-fluid" alt="Gambar Aplikasi" style="height: 100px; object-fit: cover;">
                            </div>
                        </div>

                        {{-- Kolom untuk menambah foto aplikasi baru --}}
                        <div class="col">
                            {{-- Menggunakan struktur yang lebih canggih untuk input file custom --}}
                            <div class="input-group" style="height: 100px;">
                                <div class="custom-file d-flex justify-content-center align-items-center w-100 h-100" style="border: 1px dashed #ccc; border-radius: .25rem; overflow: hidden; position: relative;">
                                    <input type="file" class="custom-file-input" name="gambar_aplikasi[]" id="gambar_baru" multiple accept="image/*" style="position: absolute; width: 100%; height: 100%; opacity: 0; cursor: pointer;">
                                    <label class="custom-file-label text-muted text-center m-0 p-2 d-flex align-items-center justify-content-center w-100 h-100" for="gambar_baru">
                                        <small>Tambah foto aplikasi</small>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Bagian Logo --}}
                <div class="mb-4 p-3 border rounded">
                    <label for="logo" class="form-label mb-2">Logo</label>
                    <div class="d-flex align-items-center mb-3">
                        <img src="/storage/logo.png" alt="Logo Aplikasi" class="img-thumbnail me-3" style="width: 80px; height: 80px; object-fit: contain;">
                        <div class="flex-grow-1">
                            {{-- Menggunakan input-group dan custom-file untuk logo --}}
                            <div class="input-group">
                                <label class="input-group-text custom-file-label" for="logo_file_input" id="logo_label">Choose File</label>
                                <input type="file" class="form-control custom-file-input d-none" name="logo" id="logo_file_input" accept="image/*">
                                <input type="text" class="form-control" id="logo_filename_display" value="Gambar Mobile Legend" readonly>
                            </div>
                            <small class="text-muted mt-1">Pilih File Logo</small>
                        </div>
                    </div>
                </div>

                {{-- Nama Aplikasi --}}
                <div class="mb-3">
                    <label for="nama_aplikasi" class="form-label">Nama Aplikasi</label>
                    <input type="text" class="form-control" name="nama_aplikasi" id="nama_aplikasi" value="Mobile Legend Bang bang" required>
                </div>

                {{-- Pemilik --}}
                <div class="mb-3">
                    <label for="pemilik" class="form-label">Pemilik</label>
                    <input type="text" class="form-control" name="pemilik" id="pemilik" value="Moonton" required>
                </div>

                <div class="row">
                    {{-- Jenis Kategori --}}
                    <div class="col-md-6 mb-3">
                        <label for="kategori" class="form-label">Jenis Kategori</label>
                        <select class="form-select" name="kategori" id="kategori" required>
                            <option value="">Pilih Kategori</option>
                            <option value="Game" selected>Game</option>
                            <option value="Edukasi">Edukasi</option>
                        </select>
                    </div>

                    {{-- Tanggal Rilis --}}
                    <div class="col-md-6 mb-3">
                        <label for="tanggal_rilis" class="form-label">Tanggal Rilis</label>
                        <div class="input-group">
                            <input type="date" class="form-control" name="tanggal_rilis" id="tanggal_rilis" value="2025-05-27" required>
                            <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
                        </div>
                    </div>
                </div>

                <div class="row">
                    {{-- Versi --}}
                    <div class="col-md-6 mb-3">
                        <label for="versi" class="form-label">Versi</label>
                        <input type="text" class="form-control" name="versi" id="versi" value="0.1.2" required>
                    </div>

                    {{-- Rating Konten --}}
                    <div class="col-md-6 mb-3">
                        <label for="rating_konten" class="form-label">Rating Konten</label>
                        <select class="form-select" name="rating_konten" id="rating_konten" required>
                            <option value="">Pilih Rating</option>
                            <option value="3+">3+</option>
                            <option value="7+">7+</option>
                            <option value="12+" selected>12+</option>
                            <option value="16+">16+</option>
                            <option value="18+">18+</option>
                        </select>
                    </div>
                </div>

                {{-- Tautan Aplikasi --}}
                <div class="mb-3">
                    <label for="tautan_aplikasi" class="form-label">Tautan Aplikasi</label>
                    <input type="url" class="form-control" name="tautan_aplikasi" id="tautan_aplikasi" value="https://play.google.com/store/apps/details?id=com.mobile.legends&hl=id" required>
                </div>

                {{-- Deskripsi --}}
                <div class="mb-3">
                    <label for="deskripsi" class="form-label">Deskripsi</label>
                    <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" required>Mobile Legends: Bang Bang adalah game mobile bergenre MOBA (Multiplayer Online Battle Arena) yang dikembangkan dan diterbitkan oleh Moonton. Dalam game ini, dua tim yang masing-masing terdiri dari lima pemain bertarung secara real-time untuk menghancurkan base lawan.</textarea>
                </div>

                {{-- Fitur --}}
                <div class="mb-4">
                    <label for="fitur" class="form-label">Fitur</label>
                    <textarea class="form-control" name="fitur" id="fitur" rows="3">Map MOBA Klasik & Pertandingan 5v5</textarea>
                    <small class="text-muted">Pisahkan fitur dengan koma atau baris baru jika lebih dari satu.</small>
                </div>

                {{-- Tombol Aksi --}}
                <div class="d-flex justify-content-end">
                    <a href="/aplikasi" class="btn btn-light me-2 border">Batal</a>
                    <button type="submit" class="btn btn-danger text-white">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card-img-top {
        border-bottom-left-radius: 0;
        border-bottom-right-radius: 0;
    }
    .cursor-pointer {
        cursor: pointer;
    }

    /* Style untuk custom file input (jika menggunakan Bootstrap 4 custom-file, atau Anda bisa menirunya) */
    .custom-file {
        position: relative;
        display: inline-block;
        width: 100%;
        height: calc(1.5em + .75rem + 2px); /* Menyesuaikan tinggi input form-control */
        margin-bottom: 0;
    }
    .custom-file-input {
        position: relative;
        z-index: 2;
        width: 100%;
        height: calc(1.5em + .75rem + 2px);
        margin: 0;
        opacity: 0;
    }
    .custom-file-label {
        position: absolute;
        top: 0;
        right: 0;
        left: 0;
        z-index: 1;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        font-weight: 400;
        line-height: 1.5;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: .25rem;
        box-shadow: inset 0 .2rem .4rem rgba(0,0,0,.05);
        display: flex; /* Untuk memposisikan teks di tengah */
        align-items: center; /* Untuk memposisikan teks di tengah */
        justify-content: flex-start; /* Untuk menempatkan teks di kiri, bisa diubah jadi center */
    }
    .custom-file-label::after {
        content: "Choose File"; /* Teks default untuk tombol */
        position: absolute;
        top: 0;
        right: 0;
        bottom: 0;
        z-index: 3;
        display: block;
        height: calc(1.5em + .75rem + 2px);
        padding: .375rem .75rem;
        line-height: 1.5;
        color: #495057;
        background-color: #e9ecef;
        border-left: 1px solid #ced4da;
        border-radius: 0 .25rem .25rem 0;
    }
    .custom-file-label.file-selected::after {
        content: ""; /* Sembunyikan "Choose File" jika file terpilih */
    }

    /* Override Bootstrap jika perlu */
    .form-select {
        padding-right: 2.25rem; /* Menyesuaikan padding untuk ikon panah default */
    }
</style>
@endpush

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const batalButton = document.querySelector('.btn-light');
        batalButton.addEventListener('click', function(event) {
            event.preventDefault();
            window.history.back();
        });

        // Script untuk menampilkan nama file yang dipilih pada input logo
        const logoFileInput = document.getElementById('logo_file_input');
        const logoFilenameDisplay = document.getElementById('logo_filename_display');
        const logoLabel = document.getElementById('logo_label');

        if (logoFileInput && logoFilenameDisplay && logoLabel) {
            logoFileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    logoFilenameDisplay.value = this.files[0].name;
                    logoLabel.classList.add('file-selected'); // Tambahkan kelas untuk menyembunyikan "Choose File"
                } else {
                    logoFilenameDisplay.value = "Gambar Mobile Legend"; // Default value jika tidak ada file
                    logoLabel.classList.remove('file-selected');
                }
            });

            // Set initial value for logo filename display based on existing value
            // if you were populating dynamically, you'd use a Blade variable here
            logoFilenameDisplay.value = "Gambar Mobile Legend"; // Default untuk statis
        }

        // Script untuk "Tambah foto aplikasi"
        const newAppImageInput = document.getElementById('gambar_baru');
        if (newAppImageInput) {
            newAppImageInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    // Di sini Anda bisa menambahkan logika untuk menampilkan preview gambar yang baru diupload
                    // Atau mengubah teks "Tambah foto aplikasi" menjadi "File terpilih (X)"
                    console.log(`${this.files.length} file dipilih untuk gambar aplikasi.`);
                    // Contoh mengubah label
                    const label = this.nextElementSibling;
                    if (label) {
                        label.querySelector('small').textContent = `File dipilih (${this.files.length})`;
                    }
                } else {
                     const label = this.nextElementSibling;
                    if (label) {
                        label.querySelector('small').textContent = `Tambah foto aplikasi`;
                    }
                }
            });
        }
    });
</script>
@endpush