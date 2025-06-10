@extends('layouts.admin')

@section('content')

<!-- {{-- SweetAlert2 untuk notifikasi dari session (Ini menangani notifikasi dari redirect non-AJAX, atau saat halaman pertama kali dimuat) --}}
@if (session('alert.config'))
    <script>
        Swal.fire(@json(session('alert.config')));
    </script>
@endif -->

<div class="main-content-wrapper p-6 bg-gray-100 min-h-screen">
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-red-700">Berita</h1>
            <div class="flex mx-8">
    {{-- Form Pencarian --}}
    <form action="{{ route('admin.berita.index') }}" method="GET" class="flex w-64 md:w-80 mb-4">
    <input
        type="text"
        name="keyword"
        placeholder="Cari di sini..."
        class="flex-grow px-4 py-2 rounded-l-md border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
        value="{{ request('keyword') }}"
    />
    <button
        type="submit"
        class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-md hover:bg-[#f5f5f5] focus:outline-none"
    >
        <i class="fas fa-search text-custom-primary-red"></i>
    </button>
</form>

</div>
        </div>
    </div>

    <div class="bg-white shadow-md rounded-lg p-6">
        {{-- Header --}}
        <div class="flex justify-end items-center mb-4">
    <a href="{{ route('admin.berita.create') }}"
       class="bg-custom-primary-red text-white px-4 py-2 rounded-md hover:bg-custom-primary-red-darker transition duration-200">
        <i class="fas fa-plus mr-2"></i> Tambah Berita
    </a>
</div>

        {{-- Tabel Berita --}}
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden" id="beritaTable"> {{-- Menambahkan ID ke tabel --}}
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider rounded-tl-lg">
                            No.
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Thumbnail
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Judul Berita
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal Rilis
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider">
                            Tanggal Update
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 uppercase tracking-wider rounded-tr-lg">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @forelse ($berita as $item)
                        <tr id="berita-row-{{ $item->id }}"> {{-- Menambahkan ID ke setiap baris untuk penghapusan --}}
                            <td class="text-center py-4 px-4 text-sm text-gray-700">{{ $loop->iteration }}</td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                <img src="{{ $item->thumbnail_url }}" alt="Thumbnail Berita" class="w-16 h-16 object-cover rounded-md shadow-sm">
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700 font-medium">{{ $item->judul_berita }}</td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                {{ $item->tanggal_dibuat ? $item->tanggal_dibuat->format('d M Y') : '-' }}
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                {{ $item->tanggal_diedit ? $item->tanggal_diedit->format('d M Y') : '-' }}
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('admin.berita.show', $item->id) }}" 
                                       class="bg-blue-600 border border-blue-700 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm">
                                        Detail
                                    </a>
                                    <a href="{{ route('admin.berita.edit', $item->id) }}"
                                       class="bg-green-600 hover:bg-green-700 text-white text-xs font-semibold py-1 px-3 rounded shadow">
                                        Edit
                                    </a>
                                    {{-- Menggunakan tombol untuk konfirmasi hapus, panggil fungsi deleteBerita yang baru --}}
                                    <button type="button" 
                                            class="bg-red-700 border border-red-800 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm"
                                            onclick="deleteBerita('{{ $item->id }}', '{{ route('admin.berita.destroy', $item->id) }}')">
                                        Hapus
                                    </button>
                                    {{-- Form tersembunyi tidak lagi diperlukan secara ketat jika menggunakan Fetch API, tetapi disimpan untuk konteks --}}
                                    {{-- <form id="delete-form-{{ $item->id }}" action="{{ route('admin.berita.destroy', $item->id) }}" method="POST" style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form> --}}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-4 px-4 text-center text-gray-500">Tidak ada berita yang tersedia.</td>
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
    // Fungsi untuk menangani penghapusan dengan SweetAlert dan AJAX
    async function deleteBerita(beritaId, deleteUrl) {
        const result = await Swal.fire({
            title: 'Apakah Anda yakin?',
            text: "Berita ini akan dihapus secara permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Ya, hapus!',
            cancelButtonText: 'Batal'
        });

        if (result.isConfirmed) {
            try {
                const response = await fetch(deleteUrl, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Sertakan token CSRF
                        'Content-Type': 'application/json',
                        'Accept': 'application/json'
                    }
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500 // Notifikasi akan hilang setelah 1.5 detik
                    }).then(() => {
                        // Secara opsional hapus baris dari tabel tanpa me-refresh halaman penuh
                        const row = document.getElementById('berita-row-' + beritaId);
                        if (row) {
                            row.remove();
                        }
                        // Jika Anda ingin me-refresh halaman penuh untuk kesederhanaan setelah penghapusan berhasil:
                        // window.location.reload(); 
                    });
                } else {
                    // Tangani kesalahan dari server (validasi, konflik, umum)
                    let errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                    if (data.errors) {
                        // Untuk kesalahan validasi, Anda mungkin ingin menampilkannya dengan cara yang lebih detail
                        errorMessage += '\n' + Object.values(data.errors).join('\n');
                    }
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal!',
                        text: errorMessage
                    });
                }

            } catch (error) {
                console.error('Error:', error);
                Swal.fire({
                    icon: 'error',
                    title: 'Kesalahan Jaringan!',
                    text: 'Tidak dapat terhubung ke server. Silakan coba lagi.'
                });
            }
        }
    }
</script>
@endsection