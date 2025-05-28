@extends('layouts.admin')

@section('title', 'Kategori')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">

    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Kategori</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Kategori</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        <div class="flex justify-end mb-4">
            <button id="btnTambah" class="bg-red-700 hover:bg-red-800 active:bg-red-900 text-white font-bold py-2 px-4 rounded-lg shadow-md flex items-center transition-colors duration-200">
                <i class="fas fa-plus mr-2"></i> Tambah
            </button>
        </div>

        <!-- Modal Tambah -->
        <div id="modalTambah" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
                <button onclick="tutupModal('modalTambah')" class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800">Tambah Kategori</h2>
                <form id="formTambahKategori">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" id="namaKategori" name="namaKategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="tutupModal('modalTambah')" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Simpan</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Edit -->
        <div id="modalEdit" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 relative">
                <button onclick="tutupModal('modalEdit')" class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-xl font-bold mb-4 text-gray-800">Edit Kategori</h2>
                <form id="formEditKategori">
                    <div class="mb-4">
                        <label class="block text-gray-700 mb-2">Nama Kategori</label>
                        <input type="text" id="editNamaKategori" name="editNamaKategori" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring focus:border-blue-300" required>
                    </div>
                    <div class="flex justify-end space-x-2">
                        <button type="button" onclick="tutupModal('modalEdit')" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                        <button type="submit" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Edit</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Modal Hapus -->
        <div id="modalHapus" class="fixed inset-0 bg-black bg-opacity-50 flex justify-center items-center z-50 hidden">
            <div class="bg-white w-full max-w-md rounded-lg shadow-lg p-6 text-center relative">
                <button onclick="tutupModal('modalHapus')" class="absolute top-2 right-2 text-gray-500 hover:text-red-700">
                    <i class="fas fa-times"></i>
                </button>
                <div class="flex justify-center mb-4 text-red-600 text-4xl">
                    <i class="fas fa-trash-alt"></i>
                </div>
                <h2 class="text-xl font-bold text-gray-800 mb-2">Apakah Anda yakin menghapus kategori ini?</h2>
                <div class="flex justify-center space-x-4 mt-4">
                    <button onclick="tutupModal('modalHapus')" class="bg-gray-300 text-gray-800 px-4 py-2 rounded-lg hover:bg-gray-400">Batal</button>
                    <button id="btnKonfirmasiHapus" class="bg-red-700 text-white px-4 py-2 rounded-lg hover:bg-red-800">Hapus</button>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            No.
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Nama Kategori
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal Dibuat
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal Diedit
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $categories = [
                            ['no' => 1, 'name' => 'Permainan', 'created_at' => '06 - 05 - 2025', 'updated_at' => '10 - 05 - 2025'],
                            ['no' => 2, 'name' => 'Belanja', 'created_at' => '06 - 05 - 2025', 'updated_at' => '10 - 05 - 2025'],
                            ['no' => 3, 'name' => 'Pendidikan',  'created_at' => '06 - 05 - 2025', 'updated_at' => '10 - 05 - 2025'],
                            ['no' => 4, 'name' => 'Olahraga', 'created_at' => '06 - 05 - 2025', 'updated_at' => '10 - 05 - 2025'],
                            ['no' => 5, 'name' => 'Fashion', 'created_at' => '06 - 05 - 2025', 'updated_at' => '10 - 05 - 2025'],
                        ];
                    @endphp

                    @foreach($categories as $category)
                    <tr>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $category['no'] }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm kategori-nama">{{ $category['name'] }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $category['created_at'] }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">{{ $category['updated_at'] }}</td>
                        <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                            <div class="flex space-x-2 justify-center">
                                <button class="btnEdit bg-green-600 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm">Edit</button>
                                <button class="btnHapus bg-red-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm">Hapus</button>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
</div>

<script>
    function tutupModal(id) {
        document.getElementById(id).classList.add('hidden');
    }

    document.getElementById('btnTambah').addEventListener('click', () => {
        document.getElementById('modalTambah').classList.remove('hidden');
    });

    document.getElementById('formTambahKategori').addEventListener('submit', function (e) {
        e.preventDefault();
        const namaKategori = document.getElementById('namaKategori').value;
        alert('Kategori "' + namaKategori + '" berhasil ditambahkan.');
        tutupModal('modalTambah');
        this.reset();
    });

    // Tombol Edit
    document.querySelectorAll('.btnEdit').forEach(button => {
        button.addEventListener('click', function () {
            const row = this.closest('tr');
            const namaKategori = row.querySelector('.kategori-nama').innerText;
            document.getElementById('editNamaKategori').value = namaKategori;
            document.getElementById('modalEdit').classList.remove('hidden');
        });
    });

    // Submit Edit
    document.getElementById('formEditKategori').addEventListener('submit', function (e) {
        e.preventDefault();
        const newNama = document.getElementById('editNamaKategori').value;
        alert('Kategori "' + newNama + '" berhasil diubah');
        tutupModal('modalEdit');
        this.reset();
    });

    // Tombol Hapus
    document.querySelectorAll('.btnHapus').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('modalHapus').classList.remove('hidden');
        });
    });

    document.getElementById('btnKonfirmasiHapus').addEventListener('click', function () {
        alert('Kategori berhasil dihapus');
        tutupModal('modalHapus');
    });
</script>
@endsection
