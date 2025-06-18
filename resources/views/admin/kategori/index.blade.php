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
                        <input
                            type="text"
                            name="search"
                            placeholder="Cari di sini..."
                            class="flex-grow px-4 py-2 rounded-l-md border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
                            value="{{ request('search') }}"
                        />
                        <button
                            type="submit"
                            class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-md hover:bg-[#f5f5f5] focus:outline-none"
                        >
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
                            @if($filter === 'semua')
                                bg-red-700 hover:bg-red-800 active:bg-red-900 text-white
                            @else
                                bg-white text-gray-800 border border-gray-300 hover:bg-gray-100
                            @endif">
                        Semua
                    </a>
                    <a href="{{ route('admin.kategori.index', ['filter' => 'aplikasi']) }}"
                        class="btnFilter font-semi bold py-1 px-3 rounded-lg shadow-md flex items-center transition-colors duration-200
                            @if($filter === 'aplikasi')
                                bg-red-700 hover:bg-red-800 active:bg-red-900 text-white
                            @else
                                bg-white text-gray-800 border border-gray-300 hover:bg-gray-100
                            @endif">
                        Aplikasi
                    </a>
                    <a href="{{ route('admin.kategori.index', ['filter' => 'berita']) }}"
                        class="btnFilter font-semi bold py-1 px-3 rounded-lg shadow-md flex items-center transition-colors duration-200
                            @if($filter === 'berita')
                                bg-red-700 hover:bg-red-800 active:bg-red-900 text-white
                            @else
                                bg-white text-gray-800 border border-gray-300 hover:bg-gray-100
                            @endif">
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
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                            <option value="">Pilih sub kategori</option>
                            <option value="aplikasi">Aplikasi</option>
                            <option value="berita">Berita</option>
                        </select>
                        <p class="text-red-500 text-xs italic mt-1 hidden" id="error-subKategori">Sub Kategori wajib diisi.</p>
                    </div>
                    <div class="mb-4">
                        <label for="namaKategori" class="block text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" id="namaKategori" name="nama_kategori"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" placeholder="Masukkan nama kategori" required>
                        <p class="text-red-500 text-xs italic mt-1 hidden" id="error-namaKategori">Nama Kategori wajib diisi.</p>
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
                <button onclick="tutupModal('modalEdit')" class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
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
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                            <option value="aplikasi">Aplikasi</option>
                            <option value="berita">Berita</option>
                        </select>
                        <p class="text-red-500 text-xs italic mt-1 hidden" id="error-editSubKategori">Sub Kategori wajib diisi.</p>
                    </div>
                    <div class="mb-4">
                        <label for="editNamaKategori" class="block text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" id="editNamaKategori" name="nama_kategori"
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                        <p class="text-red-500 text-xs italic mt-1 hidden" id="error-editNamaKategori">Nama Kategori wajib diisi.</p>
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

        <div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 text-center relative">
                <button onclick="tutupModal('modalHapus')" class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
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
        <div id="modalDetail" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
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
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">{{ $loop->iteration }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm kategori-nama">{{ $category->nama_kategori }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm capitalize">{{ $category->sub_kategori }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm">{{ \Carbon\Carbon::parse($category->tanggal_dibuat)->format('d - m - Y') }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm">{{ \Carbon\Carbon::parse($category->tanggal_diedit)->format('d - m - Y') }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-center text-sm text-center">
                            <div class="flex space-x-2 justify-center">
                                <button class="btnDetail bg-blue-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm" data-id="{{ $category->id }}">Detail</button>
                                <button class="btnEdit bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm" data-id="{{ $category->id }}">Edit</button>
                                <button class="btnHapus bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm" data-id="{{ $category->id }}">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">Tidak ada data kategori.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
         {{-- Pagination (Statis) --}}
         <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600">
                Rows per page:
                <select id="rows-per-page" class="ml-2 border border-gray-300 rounded-md py-2 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red">
                    <option value="10" selected>10</option>
                    <option value="20">20</option>
                    <option value="30">30</option>
                </select>
            </div>
            <div id="pagination-info" class="text-sm text-gray-600">
                1-10 of 30
            </div>
            <div class="flex space-x-2">
                <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200">
                    <i class="fas fa-chevron-left"></i>
                </button>
                <button class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200">
                    <i class="fas fa-chevron-right"></i>
                </button>
            </div>
        </div>
    </div>
</div>

{{-- SweetAlert2 CDN --}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    function tutupModal(id) {
        document.getElementById(id).classList.add('hidden');
        // Clear any previous error messages when closing the modal
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
        clearErrorMessages(); // Clear existing errors before validating

        const form = document.getElementById(formId);
        const inputs = form.querySelectorAll('input[required], select[required]');

        inputs.forEach(input => {
            const errorElement = document.getElementById(`error-${input.id}`);
            if (!input.value.trim()) {
                input.classList.add('border-red-500'); // Add red border
                errorElement.classList.remove('hidden');
                isValid = false;
            } else {
                input.classList.remove('border-red-500'); // Remove red border if valid
                errorElement.classList.add('hidden');
            }
        });
        return isValid;
    }

    document.getElementById('btnTambah').addEventListener('click', () => {
        document.getElementById('formTambahKategori').reset();
        clearErrorMessages(); // Clear errors when opening
        document.getElementById('modalTambah').classList.remove('hidden');
    });

    document.getElementById('formTambahKategori').addEventListener('submit', async function(e) {
        e.preventDefault();
        
        if (!validateForm('formTambahKategori')) {
            return; // Stop if validation fails
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
                    // Display backend validation errors under fields if available
                    for (const key in errorData.errors) {
                        const inputElement = document.getElementById(key.replace('_', 'Kategori'));
                        const errorElement = document.getElementById(`error-${key.replace('_', 'Kategori')}`);
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
                window.location.reload(); // Reload to see the new data
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
    document.getElementById('formEditKategori').addEventListener('submit', async function(e) {
        e.preventDefault();

        if (!validateForm('formEditKategori')) {
            return; // Stop if validation fails
        }

        const kategoriId = document.getElementById('editKategoriId').value;
        const formData = new FormData(this);

        try {
            const response = await fetch(`/admin/kategori/${kategoriId}`, {
                method: 'POST', // Use POST for PUT requests with FormData and Laravel
                body: formData,
                headers: {
                    'Accept': 'application/json',
                },
            });

            if (!response.ok) {
                const errorData = await response.json();
                let errorMessage = 'Terjadi kesalahan saat mengupdate kategori.';
                if (errorData.errors) {
                    // Display backend validation errors under fields if available
                    for (const key in errorData.errors) {
                        const inputElement = document.getElementById(`edit${key.charAt(0).toUpperCase() + key.slice(1).replace('_', '')}`);
                        const errorElement = document.getElementById(`error-edit${key.charAt(0).toUpperCase() + key.slice(1).replace('_', '')}`);
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
                        Swal.fire(
                            'Dihapus!',
                            data.message,
                            'success',
                            toast: true,
                            position: 'top-end',
                        ).then(() => {
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
                document.getElementById('detailTanggalDibuat').textContent = new Date(kategori.tanggal_dibuat).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, ' - ');
                document.getElementById('detailTanggalDiedit').textContent = new Date(kategori.tanggal_diedit).toLocaleDateString('id-ID', { day: '2-digit', month: '2-digit', year: 'numeric' }).replace(/\//g, ' - ');
                
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

    document.querySelectorAll('.btnFilter').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const currentUrl = new URL(window.location.href);
            const searchParam = currentUrl.searchParams.get('search');
            const filterValue = this.getAttribute('href').split('filter=')[1];
            
            let newUrl = `{{ route('admin.kategori.index') }}?filter=${filterValue}`;
            if (searchParam) {
                newUrl += `&search=${searchParam}`;
            }
            window.location.href = newUrl;
        });
    });
</script>
@endsection