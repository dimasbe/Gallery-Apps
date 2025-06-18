@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
    <!-- Wrapper Konten Utama -->
    <div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
        <!-- Navbar Riwayat + Breadcrumbs -->
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-bold text-red-700">Kategori</h1>
                <div class="flex mx-8">
                    {{-- Tambahkan form untuk pencarian --}}
                    <form action="{{ route('admin.kategori.index') }}" method="GET" class="flex w-64 md:w-80">
                        <input type="text" name="search" placeholder="Cari di sini..."
                            class="flex-grow px-4 py-2 rounded-l-md border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
                            value="{{ request('search') }}" />
                        <button type="submit"
                            class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-md hover:bg-[#f5f5f5] focus:outline-none">
                            <i class="fas fa-search text-custom-primary-red"></i>
                        </button>
                        <input type="hidden" name="filter" value="{{ $filter }}">
                    </form>
                </div>
            </div>
        </div>

        <div class="bg-white shadow-md rounded-lg p-6">
            {{-- Main container for the header row --}}
            <div class="flex items-center mb-4">

                {{-- Center-aligned text. flex-grow makes it take available space, text-center centers the content within it. --}}
                <div class="flex-grow text-center">
                </div>

                {{-- Right-aligned buttons group. space-x-6 applied here for distance between filter group and 'Tambah' button --}}
                <div class="flex space-x-4">
                    {{-- Filter buttons group --}}
                    <div class="flex space-x-2">
                        <a href="{{ route('admin.kategori.index', ['filter' => 'semua']) }}"
                            class="btnFilter font-semi bold py-1 px-3 rounded-lg shadow-md flex items-center transition-colors duration-200
                            @if ($filter === 'semua') bg-red-700 hover:bg-red-800 active:bg-red-900 text-white
                            @else
                                bg-white text-gray-800 border border-gray-300 hover:bg-gray-100 @endif">
                            Semua
                        </a>
                        <a href="{{ route('admin.kategori.index', ['filter' => 'aplikasi']) }}"
                            class="btnFilter font-semi bold py-1 px-3 rounded-lg shadow-md flex items-center transition-colors duration-200
                            @if ($filter === 'aplikasi') bg-red-700 hover:bg-red-800 active:bg-red-900 text-white
                            @else
                                bg-white text-gray-800 border border-gray-300 hover:bg-gray-100 @endif">
                            Aplikasi
                        </a>
                        <a href="{{ route('admin.kategori.index', ['filter' => 'berita']) }}"
                            class="btnFilter font-semi bold py-1 px-3 rounded-lg shadow-md flex items-center transition-colors duration-200
                            @if ($filter === 'berita') bg-red-700 hover:bg-red-800 active:bg-red-900 text-white
                            @else
                                bg-white text-gray-800 border border-gray-300 hover:bg-gray-100 @endif">
                            Berita
                        </a>
                    </div>
                    {{-- 'Tambah' button --}}
                    <button id="btnTambah"
                        class="bg-red-700 hover:bg-red-800 active:bg-red-900 text-white font-semi bold py-1 px-3 rounded-lg shadow-md flex items-center transition-colors duration-200">
                        <i class="fas fa-plus mr-2"></i> Tambah
                    </button>
                </div>
            </div>

            <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
                <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Tambah Kategori</h2>
                    <form id="formTambahKategori" enctype="multipart/form-data" novalidate> {{-- Added novalidate here --}}
                        @csrf
                        <div class="mb-4">
                            <label for="subKategori" class="block text-gray-700 mb-2">Sub Kategori</label>
                            <select id="subKategori" name="sub_kategori"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                required>
                                <option value="">Pilih sub kategori</option>
                                <option value="aplikasi">Aplikasi</option>
                                <option value="berita">Berita</option>
                            </select>
                            <p class="text-red-500 text-xs italic mt-1 hidden" id="error-subKategori">Sub Kategori wajib
                                diisi.</p>
                        </div>
                        <div class="mb-4">
                            <label for="namaKategori" class="block text-gray-700 mb-2">Nama Kategori</label>
                            <input type="text" id="namaKategori" name="nama_kategori"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                placeholder="Masukkan nama kategori" required>
                            <p class="text-red-500 text-xs italic mt-1 hidden" id="error-namaKategori">Nama Kategori wajib
                                diisi.</p>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="tutupModal('modalTambah')"
                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>

            {{-- Modal Edit Kategori --}}
            <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
                <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
                    <button onclick="tutupModal('modalEdit')"
                        class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                    <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Kategori</h2>
                    <form id="formEditKategori" enctype="multipart/form-data" novalidate> {{-- Added novalidate here --}}
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="editKategoriId" name="id">
                        <div class="mb-4">
                            <label for="editSubKategori" class="block text-gray-700 mb-2">Sub Kategori</label>
                            <select id="editSubKategori" name="sub_kategori"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                required>
                                <option value="aplikasi">Aplikasi</option>
                                <option value="berita">Berita</option>
                            </select>
                            <p class="text-red-500 text-xs italic mt-1 hidden" id="error-editSubKategori">Sub Kategori wajib
                                diisi.</p>
                        </div>
                        <div class="mb-4">
                            <label for="editNamaKategori" class="block text-gray-700 mb-2">Nama Kategori</label>
                            <input type="text" id="editNamaKategori" name="nama_kategori"
                                class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300"
                                required>
                            <p class="text-red-500 text-xs italic mt-1 hidden" id="error-editNamaKategori">Nama Kategori
                                wajib diisi.</p>
                        </div>
                        <div class="flex justify-end space-x-2">
                            <button type="button" onclick="tutupModal('modalEdit')"
                                class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                            <button type="submit"
                                class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Edit</button>
                        </div>
                    </form>
                </div>
            </div>

            <div id="modalHapus"
                class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
                <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 text-center relative">
                    <button onclick="tutupModal('modalHapus')"
                        class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
                        <i class="fas fa-times"></i>
                    </button>
                    <div class="flex justify-center mb-4 text-red-600 text-4xl">
                        <i class="fas fa-trash-alt"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800 mb-2">Apakah Anda yakin menghapus kategori ini?</h2>
                    <input type="hidden" id="deleteKategoriId">
                    <div class="flex justify-center space-x-4 mt-4">
                        <button onclick="tutupModal('modalHapus')"
                            class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                        <button id="btnKonfirmasiHapus"
                            class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Hapus</button>
                    </div>
                </div>
            </div>

            {{-- Modal Detail Kategori --}}
            <div id="modalDetail"
                class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
                <div class="bg-white w-full max-w-lg rounded-lg shadow-lg p-6 relative">
                    <h2 class="text-xl font-bold mb-4 text-gray-800 text-center">Detail Kategori</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <p class="text-gray-600 text-sm text-center">Sub Kategori</p>
                            <p id="detailSubKategori" class="text-gray-800 font-semibold capitalize text-center"></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm text-center">Nama Kategori</p>
                            <p id="detailNamaKategori" class="text-gray-800 font-semibold text-center"></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm text-center">Rilis</p>
                            <p id="detailTanggalDibuat" class="text-gray-800 font-semibold text-center"></p>
                        </div>
                        <div>
                            <p class="text-gray-600 text-sm text-center">Update</p>
                            <p id="detailTanggalDiedit" class="text-gray-800 font-semibold text-center"></p>
                        </div>
                    </div>
                    <div class="flex justify-end space-x-2 mt-6">
                        <button type="button" onclick="tutupModal('modalDetail')"
                            class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Tutup</button>
                    </div>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th
                                class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 tracking-wider">
                                No.
                            </th>
                            <th
                                class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 tracking-wider">
                                Nama Kategori
                            </th>
                            <th
                                class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 tracking-wider">
                                Sub Kategori
                            </th>
                            <th
                                class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 tracking-wider">
                                Rilis
                            </th>
                            <th
                                class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 tracking-wider">
                                Update
                            </th>
                            <th
                                class="text-center px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($kategoris as $category)
                            <tr>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                    {{ $loop->iteration }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm kategori-nama">
                                    {{ $category->nama_kategori }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm capitalize">
                                    {{ $category->sub_kategori }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm">
                                    {{ \Carbon\Carbon::parse($category->tanggal_dibuat)->format('d - m - Y') }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm">
                                    {{ \Carbon\Carbon::parse($category->tanggal_diedit)->format('d - m - Y') }}</td>
                                <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm text-center">
                                    <div class="flex space-x-2 justify-center">
                                        <button
                                            class="btnDetail bg-blue-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm"
                                            data-id="{{ $category->id }}">Detail</button>
                                        <button
                                            class="btnEdit bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm"
                                            data-id="{{ $category->id }}">Edit</button>
                                        <button
                                            class="btnHapus bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm"
                                            data-id="{{ $category->id }}">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6"
                                    class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">Tidak ada data
                                    kategori.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination --}}
            <div class="flex justify-between items-center mt-4">
                {{-- Rows per page dropdown --}}
                <div class="text-sm text-gray-600">
                    Rows per page:
                    <select id="rows-per-page"
                        class="ml-2 border border-gray-300 rounded-md py-2 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red">
                        @foreach ([5, 10, 20, 30, 40, 50, 100, 500] as $perPageOption)
                            <option value="{{ $perPageOption }}" {{ (request('per_page', 5) == $perPageOption) ? 'selected' : '' }}>
                                {{ $perPageOption }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Pagination Info (e.g., 1 - 1 of 1) --}}
                <div id="pagination-info" class="text-sm text-gray-600">
                    {{ $kategoris->firstItem() }}-{{ $kategoris->lastItem() }} of {{ $kategoris->total() }}
                </div>

                {{-- Custom Pagination Navigation (Previous, Page Number, and Next buttons) --}}
                <div class="flex space-x-2">
                    {{-- Previous Button --}}
                    <a href="{{ $kategoris->previousPageUrl() }}"
                    class="inline-flex items-center p-2 border border-gray-300 rounded-md
                    @if($kategoris->onFirstPage())
                        bg-gray-100 text-gray-500 cursor-not-allowed
                    @else
                        bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-primary-red
                    @endif">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M12.79 5.23a.75.75 0 010 1.06L9.06 10l3.73 3.71a.75.75 0 11-1.06 1.06l-4.25-4.25a.75.75 0 010-1.06l4.25-4.25a.75.75 0 011.06 0z" clip-rule="evenodd" />
                        </svg>
                    </a>

                    {{-- Page Numbers --}}
                    {{-- Loop through available pages to create numbered buttons --}}
                    @foreach ($kategoris->getUrlRange(1, $kategoris->lastPage()) as $page => $url)
                        <a href="{{ $url }}"
                        class="inline-flex items-center px-4 py-2 text-sm font-medium border rounded-md shadow-sm
                        @if ($page == $kategoris->currentPage())
                            bg-custom-primary-red text-white border-custom-primary-red
                        @else
                            bg-white text-gray-700 border-gray-300 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-primary-red
                        @endif">
                            {{ $page }}
                        </a>
                    @endforeach


                    {{-- Next Button --}}
                    <a href="{{ $kategoris->nextPageUrl() }}"
                    class="inline-flex items-center p-2 border border-gray-300 rounded-md
                    @if(!$kategoris->hasMorePages())
                        bg-gray-100 text-gray-500 cursor-not-allowed
                    @else
                        bg-white text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-custom-primary-red
                    @endif">
                        <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                            <path fill-rule="evenodd" d="M7.21 14.77a.75.75 0 010-1.06L10.94 10 7.21 6.29a.75.75 0 011.06-1.06l4.25 4.25a.75.75 0 010 1.06l-4.25 4.25a.75.75 0 01-1.06 0z" clip-rule="evenodd" />
                        </svg>
                    </a>
                </div>
            </div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    // Function to close modal
    function tutupModal(id) {
        document.getElementById(id).classList.add('hidden');
        clearErrorMessages();
    }

    // Function to clear all error messages
    function clearErrorMessages() {
        document.querySelectorAll('.text-red-500').forEach(el => {
            el.classList.add('hidden');
        });
    }

    // Validation function for forms
    function validateForm(formId) {
        let isValid = true;
        clearErrorMessages();

        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('input[required], select[required]');

        inputs.forEach(input => {
            const errorElement = document.getElementById(`error-${input.id}`);
            if (!input.value.trim()) {
                input.classList.add('border-red-500');
                if (errorElement) { // Check if errorElement exists
                    errorElement.classList.remove('hidden');
                }
                isValid = false;
            } else {
                input.classList.remove('border-red-500');
                if (errorElement) { // Check if errorElement exists
                    errorElement.classList.add('hidden');
                }
            }
        });

        return isValid;
    }

    // Tambah (Add) Kategori
    document.addEventListener('DOMContentLoaded', () => { // Ensure DOM is loaded
        const btnTambah = document.getElementById('btnTambah');
        if (btnTambah) {
            btnTambah.addEventListener('click', () => {
                const formTambah = document.getElementById('formTambahKategori');
                if (formTambah) {
                    formTambah.reset();
                }
                clearErrorMessages();
                const modalTambah = document.getElementById('modalTambah');
                if (modalTambah) {
                    modalTambah.classList.remove('hidden');
                }
            });
        }

        const formTambahKategori = document.getElementById('formTambahKategori');
        if (formTambahKategori) {
            formTambahKategori.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!validateForm('formTambahKategori')) {
                    return;
                }

                const formData = new FormData(this);

                try {
                    const response = await fetch("{{ route('admin.kategori.store') }}", {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                        },
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        let errorMessage = 'Terjadi kesalahan saat menambahkan kategori.';
                        if (errorData.errors) {
                            for (const key in errorData.errors) {
                                // This mapping might need adjustment based on your actual input IDs
                                const inputId = key.replace('_', 'Kategori');
                                const inputElement = document.getElementById(inputId);
                                const errorElement = document.getElementById(`error-${inputId}`);
                                if (inputElement && errorElement) {
                                    inputElement.classList.add('border-red-500');
                                    errorElement.textContent = errorData.errors[key][0];
                                    errorElement.classList.remove('hidden');
                                }
                            }
                            errorMessage = 'Terdapat kesalahan input. Mohon periksa kembali.';
                        } else if (errorData.message) {
                            errorMessage = errorData.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonColor: '#dc3545'
                        });
                        return;
                    }

                    const data = await response.json();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        tutupModal('modalTambah');
                        window.location.reload();
                    });
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan jaringan atau server.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }

        // Tombol Edit
        document.querySelectorAll('.btnEdit').forEach(button => {
            button.addEventListener('click', async function() {
                const kategoriId = this.dataset.id;
                document.getElementById('editKategoriId').value = kategoriId;
                clearErrorMessages(); // Clear errors when opening edit modal

                try {
                    const response = await fetch(`/admin/kategori/${kategoriId}/edit`);
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data kategori.');
                    }
                    const kategori = await response.json();

                    document.getElementById('editSubKategori').value = kategori.sub_kategori;
                    document.getElementById('editNamaKategori').value = kategori.nama_kategori;

                    document.getElementById('modalEdit').classList.remove('hidden');
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memuat data kategori.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Submit Edit
        const formEditKategori = document.getElementById('formEditKategori');
        if (formEditKategori) {
            formEditKategori.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!validateForm('formEditKategori')) {
                    return; // Stop if validation fails
                }

                const kategoriId = document.getElementById('editKategoriId').value;
                const formData = new FormData(this);
                // Laravel expects _method field for PUT/PATCH requests when using POST
                formData.append('_method', 'PUT');

                try {
                    const response = await fetch(`/admin/kategori/${kategoriId}`, {
                        method: 'POST', // Use POST for PUT requests with FormData and Laravel
                        body: formData,
                        headers: {
                            'Accept': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is sent
                        },
                    });

                    if (!response.ok) {
                        const errorData = await response.json();
                        let errorMessage = 'Terjadi kesalahan saat mengupdate kategori.';
                        if (errorData.errors) {
                            for (const key in errorData.errors) {
                                // Adjust ID mapping as per your form input IDs
                                const inputId = `edit${key.charAt(0).toUpperCase() + key.slice(1).replace('_', '')}`;
                                const inputElement = document.getElementById(inputId);
                                const errorElement = document.getElementById(`error-${inputId}`);
                                if (inputElement && errorElement) {
                                    inputElement.classList.add('border-red-500');
                                    errorElement.textContent = errorData.errors[key][0];
                                    errorElement.classList.remove('hidden');
                                }
                            }
                            errorMessage = 'Terdapat kesalahan input. Mohon periksa kembali.';
                        } else if (errorData.message) {
                            errorMessage = errorData.message;
                        }
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal!',
                            text: errorMessage,
                            confirmButtonColor: '#dc3545'
                        });
                        return;
                    }

                    const data = await response.json();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        toast: true,
                        position: 'top-end',
                        confirmButtonColor: '#28a745'
                    }).then(() => {
                        tutupModal('modalEdit');
                        window.location.reload(); // Reload to see the updated data
                    });
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan jaringan atau server.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        }

        // Tombol Hapus (No changes needed here as it uses SweetAlert2 for confirmation)
        document.querySelectorAll('.btnHapus').forEach(button => {
            button.addEventListener('click', function() {
                const kategoriId = this.dataset.id;
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Anda tidak akan dapat mengembalikan ini!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then(async (result) => {
                    if (result.isConfirmed) {
                        try {
                            const response = await fetch(`/admin/kategori/${kategoriId}`, {
                                method: 'DELETE',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}', // Ensure CSRF token is sent
                                    'Accept': 'application/json',
                                },
                            });

                            if (!response.ok) {
                                const errorData = await response.json();
                                let errorMessage = 'Terjadi kesalahan saat menghapus kategori.';
                                if (errorData.message) {
                                    errorMessage = errorData.message;
                                }
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal!',
                                    text: errorMessage,
                                    confirmButtonColor: '#dc3545'
                                });
                                return;
                            }

                            const data = await response.json();
                            Swal.fire({
                                title: 'Dihapus!',
                                text: data.message,
                                icon: 'success',
                                toast: true,
                                position: 'top-end',
                                showConfirmButton: false,
                                timer: 3000,
                                timerProgressBar: true
                            }).then(() => {
                                window.location.reload(); // Reload to see the updated data
                            });

                        } catch (error) {
                            console.error('Error:', error);
                            Swal.fire({
                                icon: 'error',
                                title: 'Error!',
                                text: 'Terjadi kesalahan jaringan atau server.',
                                confirmButtonColor: '#dc3545'
                            });
                        }
                    }
                });
            });
        });

        // Tombol Detail
        document.querySelectorAll('.btnDetail').forEach(button => {
            button.addEventListener('click', async function() {
                const kategoriId = this.dataset.id;
                try {
                    const response = await fetch(`/admin/kategori/${kategoriId}`);
                    if (!response.ok) {
                        throw new Error('Gagal mengambil data kategori.');
                    }
                    const kategori = await response.json();

                    document.getElementById('detailSubKategori').textContent = kategori.sub_kategori;
                    document.getElementById('detailNamaKategori').textContent = kategori.nama_kategori;
                    document.getElementById('detailTanggalDibuat').textContent = new Date(kategori
                        .tanggal_dibuat).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }).replace(/\//g, ' - ');
                    document.getElementById('detailTanggalDiedit').textContent = new Date(kategori
                        .tanggal_diedit).toLocaleDateString('id-ID', {
                            day: '2-digit',
                            month: '2-digit',
                            year: 'numeric'
                        }).replace(/\//g, ' - ');

                    document.getElementById('modalDetail').classList.remove('hidden');
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: 'Terjadi kesalahan saat memuat detail kategori.',
                        confirmButtonColor: '#dc3545'
                    });
                }
            });
        });

        // Event listener for "Rows per page" select
        document.getElementById('rows-per-page').addEventListener('change', function() {
            const selectedPerPage = this.value;
            const currentUrl = new URL(window.location.href);
            currentUrl.searchParams.set('per_page', selectedPerPage);
            currentUrl.searchParams.set('page', 1);
            window.location.href = currentUrl.toString();
        });

        // Event listener for filter buttons
        document.querySelectorAll('.btnFilter').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const currentUrl = new URL(window.location.href);
                const searchParam = currentUrl.searchParams.get('search');
                // Ensure the href attribute exists and contains 'filter='
                const href = this.getAttribute('href');
                let filterValue = '';
                if (href && href.includes('filter=')) {
                    filterValue = href.split('filter=')[1];
                }

                const perPageParam = currentUrl.searchParams.get('per_page');


                let newUrl = `{{ route('admin.kategori.index') }}?filter=${filterValue}`;
                if (searchParam) {
                    newUrl += `&search=${searchParam}`;
                }
                if (perPageParam) {
                    newUrl += `&per_page=${perPageParam}`;
                }

                window.location.href = newUrl;
            });
        });
    });
</script>
@endsection