@extends('layouts.admin')

@section('title', 'Arsip')

@section('content')
<div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">

    {{-- KARTU PUTIH UNTUK HEADER & SEARCH --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6 flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
        <h1 class="text-3xl font-bold text-red-700">Arsip</h1>
        <div class="flex flex-col md:flex-row items-center w-full md:w-auto justify-end space-y-2 md:space-y-0 md:space-x-2">
            <form action="{{ route('admin.arsip.index') }}" method="GET" class="flex flex-wrap items-center w-full md:w-auto">
                {{-- Form Pencarian Tunggal --}}
                <form action="{{ route('admin.riwayat.index') }}" method="GET" class="w-full md:w-auto flex justify-end">
                    {{-- Hidden inputs to preserve current status and per_page when searching --}}
                    <input type="hidden" name="status" value="{{ request('status', 'semua') }}">
                    <input type="hidden" name="per_page" value="{{ request('per_page', '10') }}">

                    <div class="flex w-full md:w-80">
                        <input
                            type="text"
                            placeholder="Cari disini..."
                            class="flex-grow px-4 py-2 rounded-l-xl border border-[#f5f5f5] bg-[#f5f5f5] text-gray-800 placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-[#f5f5f5]"
                            name="keyword" {{-- Nama input untuk pencarian tunggal --}}
                            value="{{ request('keyword') }}"
                        />
                        <button
                            type="submit"
                            class="px-4 py-2 border border-l-0 border-[#f5f5f5] bg-[#f5f5f5] rounded-r-xl hover:bg-gray-200 focus:outline-none"
                        >
                            <i class="fas fa-search text-custom-primary-red"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>

    {{-- Kartu (Card) yang Membungkus Tabel Arsip --}}
    <div class="bg-white shadow-md rounded-xl p-6">
        <div class="overflow-x-auto">
            <table class="min-w-full leading-normal">
                <thead>
                    <tr>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-800 tracking-wider text-center rounded-tl-lg">
                            No.
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-800 tracking-wider text-center">
                            Nama Aplikasi
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-800 tracking-wider text-center">
                            Pemilik
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-800 tracking-wider text-center">
                            Kategori
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-left text-xs font-semibold text-gray-800 tracking-wider text-center">
                            Tanggal
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-800 tracking-wider">
                            Status
                        </th>
                        <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-semibold text-gray-800 tracking-wider rounded-tr-lg">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    {{-- Data diambil dari Controller dan disesuaikan dengan Model Aplikasi --}}
                    @if(count($arsip) > 0)
                        @foreach($arsip as $data)
                        <tr>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $loop->iteration + ($arsip->currentPage() - 1) * $arsip->perPage() }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data->nama_aplikasi }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data->nama_pemilik }}</p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <p class="text-gray-900 whitespace-no-wrap">{{ $data->kategori->nama_kategori ?? 'N/A' }}</p> {{-- Akses nama kategori melalui relasi --}}
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <p class="text-gray-900 whitespace-no-wrap">
                                    {{ $data->tanggal_diarsipkan ? \Carbon\Carbon::parse($data->tanggal_diarsipkan)->format('d-m-Y') : '-' }}
                                </p>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                {{-- Menyesuaikan badge status --}}
                                @php
                                    $statusText = '';
                                    $statusClass = '';
                                    if ($data->arsip) {
                                        $statusText = 'Diarsipkan';
                                        $statusClass = 'bg-yellow-200 text-yellow-900'; // Keeping yellow as per original
                                    } else {
                                        switch ($data->status_verifikasi) {
                                            case 'pending':
                                                $statusText = 'Pending';
                                                $statusClass = 'bg-yellow-200 text-yellow-900';
                                                break;
                                            case 'diterima': // Changed 'verified' to 'diterima' based on Riwayat page enum
                                                $statusText = 'Diterima';
                                                $statusClass = 'bg-yellow-200 text-yellow-900';
                                                break;
                                            case 'ditolak': // Changed 'rejected' to 'ditolak' based on Riwayat page enum
                                                $statusText = 'Ditolak';
                                                $statusClass = 'bg-red-200 text-red-900';
                                                break;
                                            default:
                                                $statusText = 'Tidak Diketahui';
                                                $statusClass = 'bg-gray-200 text-gray-900';
                                        }
                                    }
                                @endphp
                                <span class="relative inline-block px-3 py-1 font-semibold {{ $statusClass }} leading-tight rounded-full">
                                    <span aria-hidden="true" class="absolute inset-0 opacity-50 rounded-full"></span>
                                    <span class="relative">{{ $statusText }}</span>
                                </span>
                            </td>
                            <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                <div class="flex space-x-2 justify-center">
                                    <a href="{{ route('admin.arsip.show', $data->id) }}"
                                    class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                        Detail
                                    </a>
                                    <button onclick="showUnarchivePopup({{ $data->id }})"
                                            class="bg-purple-600 hover:bg-purple-600 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                        Tampilkan
                                    </button>
                                    {{-- The delete button now calls showDeletePopup with the item ID --}}
                                    <button class="bg-red-700 hover:bg-red-800 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center"
                                            onclick="showDeletePopup({{ $data->id }})">
                                            Hapus
                                    </button>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                Tidak ada data arsip.
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>

        {{-- Bagian Pagination --}}
        <div class="flex flex-col md:flex-row justify-between items-center mt-6 space-y-4 md:space-y-0">
            {{-- Rows per page dropdown --}}
            <div class="text-sm text-gray-600 flex items-center">
                Rows per page:
                <select id="baris-per-halaman" class="ml-2 border border-gray-300 rounded-md py-1 px-2 text-gray-700 focus:outline-none focus:border-red-500"
                    onchange="ubahBarisPerHalaman(this.value)">
                    <option value="5" {{ $arsip->perPage() == 5 ? 'selected' : '' }}>5</option>
                    <option value="10" {{ $arsip->perPage() == 10 ? 'selected' : '' }}>10</option>
                    <option value="20" {{ $arsip->perPage() == 20 ? 'selected' : '' }}>20</option>
                    <option value="30" {{ $arsip->perPage() == 30 ? 'selected' : '' }}>30</option>
                    <option value="40" {{ $arsip->perPage() == 40 ? 'selected' : '' }}>40</option>
                    <option value="50" {{ $arsip->perPage() == 50 ? 'selected' : '' }}>50</option>
                    <option value="100" {{ $arsip->perPage() == 100 ? 'selected' : '' }}>100</option>
                    <option value="500" {{ $arsip->perPage() == 500 ? 'selected' : '' }}>500</option>
                    <option value="1000" {{ $arsip->perPage() == 1000 ? 'selected' : '' }}>1000</option>
                </select>
            </div>

            {{-- Pagination Info (X - Y of Z) --}}
            <div id="info-paginasi" class="text-sm text-gray-600">
                @if ($arsip->total() > 0)
                    {{ $arsip->firstItem() }} - {{ $arsip->lastItem() }} of {{ $arsip->total() }}
                @else
                    Tidak ada data.
                @endif
            </div>

            {{-- Custom Pagination Navigation with individual buttons as in ff1.PNG --}}
            <div class="flex space-x-2"> 
                {{-- Previous Button --}}
                <a href="{{ $arsip->previousPageUrl(array_merge(request()->query(), ['per_page' => $arsip->perPage()])) }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 transition duration-200
                        {{ $arsip->onFirstPage() ? 'bg-white text-gray-400 cursor-not-allowed' : 'bg-white text-gray-700 hover:bg-gray-100' }}">
                    <i class="fas fa-chevron-left"></i>
                </a>

                {{-- Page Numbers --}}
                @foreach ($arsip->links()->elements as $element)
                    @if (is_string($element))
                        <span class="inline-flex items-center justify-center w-8 h-8 rounded-lg text-gray-700 bg-white border border-gray-300">
                            {{ $element }}
                        </span>
                    @endif

                    @if (is_array($element))
                        @foreach ($element as $page => $url)
                            <a href="{{ $url }}"
                            class="inline-flex items-center justify-center w-8 h-8 rounded-lg font-semibold transition duration-200
                                    {{ $page == $arsip->currentPage() ? 'bg-red-700 text-white shadow-md' : 'bg-white text-gray-700 border border-gray-300 hover:bg-gray-100' }}">
                                {{ $page }}
                            </a>
                        @endforeach
                    @endif
                @endforeach

                {{-- Next Button --}}
                <a href="{{ $arsip->nextPageUrl(array_merge(request()->query(), ['per_page' => $arsip->perPage()])) }}"
                class="inline-flex items-center justify-center w-8 h-8 rounded-lg border border-gray-300 transition duration-200
                        {{ $arsip->hasMorePages() ? 'bg-white text-gray-700 hover:bg-gray-100' : 'bg-white text-gray-400 cursor-not-allowed' }}">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
    </div>

    {{-- Pop-up Hapus --}}
        {{-- (Biarkan kode pop-up hapus seperti aslinya, karena ini tidak terkait langsung dengan pagination) --}}
        <div id="delete-popup-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto text-center">
                <div class="text-red-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7L5 7M10 11V17M14 11V17M6 7L6 19C6 20.1046 6.89543 21 8 21H16C17.1046 21 18 20.1046 18 19V7M9 7V4H15V7" />
                    </svg>
                </div>

                <p id="delete-popup-message" class="text-gray-800 text-lg font-semibold mb-6">Apakah Anda yakin ingin menghapus aplikasi ini?</p>

                <div class="flex justify-center space-x-4">
                    <button class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 font-medium py-1.5 px-4 rounded-md transition duration-200"
                            onclick="hideDeletePopup()">Batal</button>
                    {{-- The form for deletion --}}
                    <form id="delete-form" method="POST" action="">
                        @csrf
                        @method('DELETE')
                        {{-- This hidden input will hold the ID of the item to be deleted --}}
                        <input type="hidden" name="aplikasi_id" id="aplikasi_id_to_delete">
                        <button type="submit" class="bg-red-700 hover:bg-red-800 text-white font-medium py-1.5 px-4 rounded-md transition duration-200">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>

        {{-- Pop-up Batal Arsip --}}
        <div id="unarchive-popup-overlay" class="fixed inset-0 bg-gray-800 bg-opacity-75 flex items-center justify-center z-50 hidden">
            <div class="bg-white rounded-lg shadow-xl p-6 w-full max-w-sm mx-auto text-center">
                <div class="text-purple-600 mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </div>

                <p id="unarchive-popup-message" class="text-gray-800 text-lg font-semibold mb-6">
                    Yakin ingin memindahkan aplikasi ini dari arsip?
                </p>

                <div class="flex justify-center space-x-4">
                    <button class="bg-white border border-gray-300 hover:bg-gray-100 text-gray-800 font-medium py-1.5 px-4 rounded-md transition duration-200"
                            onclick="hideUnarchivePopup()">Batal</button>
                    <form id="unarchive-form" method="POST" action="">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                                class="bg-purple-600 hover:bg-purple-600 text-white font-medium py-1.5 px-4 rounded-md transition duration-200">
                            Tampilkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script>
    // Fungsi untuk menampilkan pop-up Delete
    function showDeletePopup(id) {
        // Set the ID to the hidden input in the delete form
        document.getElementById('aplikasi_id_to_delete').value = id;
        // Construct the action URL for the form.
        // This assumes your delete route is something like '/admin/arsip/{id}'
        // If your route is different, adjust this URL accordingly.
        const deleteForm = document.getElementById('delete-form');
        deleteForm.action = `/admin/arsip/${id}`; // Example: /admin/arsip/123
        document.getElementById('delete-popup-overlay').classList.remove('hidden');
    }

    // Fungsi untuk menyembunyikan pop-up Delete
    function hideDeletePopup() {
        document.getElementById('delete-popup-overlay').classList.add('hidden');
    }

    // Fungsi untuk mengubah jumlah baris per halaman, diperbarui untuk mempertahankan semua parameter pencarian
    function ubahBarisPerHalaman(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page'); // Reset to first page when changing per_page

        // Get all potential search parameters from the current URL and re-add them
        const searchFields = ['keyword', 'nama_aplikasi', 'nama_pemilik', 'nama_kategori', 'tanggal_diarsipkan']; // Add 'keyword' here if you have a general search on arsip
        searchFields.forEach(field => {
            const fieldValue = new URLSearchParams(window.location.search).get(field);
            if (fieldValue) {
                url.searchParams.set(field, fieldValue);
            } else {
                url.searchParams.delete(field);
            }
        });

        window.location.href = url.toString();
    }

    function showUnarchivePopup(id) {
        const form = document.getElementById('unarchive-form');
        form.action = `/admin/arsip/${id}/unarchive`;
        document.getElementById('unarchive-popup-overlay').classList.remove('hidden');
    }

    function hideUnarchivePopup() {
        document.getElementById('unarchive-popup-overlay').classList.add('hidden');
    }

    document.addEventListener('DOMContentLoaded', function() {
        // SweetAlert2 for delete confirmation
        document.querySelectorAll('.delete-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal',
                    reverseButtons: true
                }).then((result) => {
                    if (result.isConfirmed) {
                        // If confirmed, submit the form
                        form.submit();
                    }
                });
            });
        });

        // Check for success messages from the session and display SweetAlert toast
        if(session('success'))
            Swal.fire({
                title: 'Berhasil!',
                text: "{{ session('success') }}",
                icon: 'success',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        endif

        // Check for error messages from the session and display SweetAlert error
        if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        endif
    });
</script>

@if (session('success'))
<script>
    Swal.fire({
        title: 'Berhasil!',
        text: "{{ session('success') }}",
        icon: 'success',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
@endif

{{-- SweetAlert error --}}
@if (session('error'))
<script>
    Swal.fire({
        icon: 'error',
        title: 'Oops...',
        text: "{{ session('error') }}",
    });
</script>
@endif
@endpush
