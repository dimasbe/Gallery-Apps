@extends('layouts.admin')

@section('content')

<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
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
            <table class="min-w-full bg-white rounded-lg overflow-hidden" id="beritaTable">
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
                        <tr id="berita-row-{{ $item->id }}">
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                {{ ($berita->currentPage() - 1) * $berita->perPage() + $loop->iteration }}
                            </td>
                            <td class="text-center py-4 px-4 text-sm text-gray-700">
                                <img src="{{ $item->thumbnail_url }}" alt="Thumbnail Berita" class="w-16 h-16 object-cover rounded-md shadow-sm mx-auto">
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
                                    <button type="button"
                                            class="bg-red-700 border border-red-800 text-white text-xs font-bold py-1 px-2 rounded-md shadow-sm"
                                            onclick="deleteBerita('{{ $item->id }}', '{{ route('admin.berita.destroy', $item->id) }}')">
                                        Hapus
                                    </button>
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

        {{-- Pagination --}}
        <div class="flex justify-between items-center mt-4">
            <div class="text-sm text-gray-600">
                Rows per page:
                <select id="rows-per-page" class="ml-2 border border-gray-300 rounded-md py-2 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red" onchange="changePerPage(this.value)">
                    <option value="5" {{ request('per_page', 5) == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ request('per_page', 5) == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ request('per_page', 5) == 20 ? 'selected' : '' }}>20</option>
                    <option value="30" {{ request('per_page', 5) == 30 ? 'selected' : '' }}>30</option>
                    <option value="40" {{ request('per_page', 5) == 40 ? 'selected' : '' }}>40</option>
                    <option value="50" {{ request('per_page', 5) == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ request('per_page', 5) == 100 ? 'selected' : '' }}>100</option>
                    <option value="500" {{ request('per_page', 5) == 500 ? 'selected' : '' }}>500</option>
                    <option value="1000" {{ request('per_page', 5) == 1000 ? 'selected' : '' }}>1000</option>
                </select>
            </div>
            <div id="pagination-info" class="text-sm text-gray-600">
                {{ $berita->firstItem() }} - {{ $berita->lastItem() }} of {{ $berita->total() }}
            </div>
            <div class="flex space-x-2">
                {{-- Tombol Previous --}}
                <a href="{{ $berita->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200 {{ $berita->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <i class="fas fa-chevron-left"></i>
                </a>

                {{-- Tampilkan Link Halaman --}}
                @foreach ($berita->getUrlRange(1, $berita->lastPage()) as $page => $url)
                    <a href="{{ $url . '&per_page=' . request('per_page', 5) . (request('keyword') ? '&keyword=' . request('keyword') : '') }}" class="px-3 py-1 border border-gray-300 rounded-md text-black hover:bg-gray-100 transition duration-200 {{ $page == $berita->currentPage() ? 'bg-custom-primary-red text-white' : '' }}">
                        {{ $page }}
                    </a>
                @endforeach

                {{-- Tombol Next --}}
                <a href="{{ $berita->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200 {{ !$berita->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
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
                        // Reload halaman untuk memperbarui daftar berita setelah penghapusan
                        window.location.reload();
                    });
                } else {
                    let errorMessage = data.message || 'Terjadi kesalahan. Silakan coba lagi.';
                    if (data.errors) {
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

    // Fungsi untuk mengubah jumlah baris per halaman
    function changePerPage(value) {
        const currentUrl = new URL(window.location.href);
        currentUrl.searchParams.set('per_page', value);
        // Pastikan parameter keyword juga tetap ada
        const keyword = document.getElementById('search-input').value; // Assuming you have a search input with this ID in the berita file
        if (keyword) {
            currentUrl.searchParams.set('keyword', keyword);
        } else {
            currentUrl.searchParams.delete('keyword');
        }
        currentUrl.searchParams.delete('page'); // Reset ke halaman 1 saat mengubah per_page
        window.location.href = currentUrl.toString();
    }

    // Event listener for DOMContentLoaded (if any other initialization is needed)
    document.addEventListener('DOMContentLoaded', function() {
        // No more event listeners for HTML pop-ups as they have been replaced by SweetAlert
    });
</script>
@endsection