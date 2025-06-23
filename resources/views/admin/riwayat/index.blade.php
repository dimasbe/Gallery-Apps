{{-- admin/riwayat/index.blade.php --}}

@extends('layouts.admin')

@section('title', 'Riwayat Verifikasi')

@section('content')
    <div class="main-content-wrapper p-6 bg-gray-1000 min-h-screen">
        {{-- Header Section --}}
        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
            <div class="flex flex-col md:flex-row justify-between items-center space-y-4 md:space-y-0">
                <h1 class="text-3xl font-bold text-red-700">Riwayat</h1>
                {{-- Form Pencarian --}}
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

        {{-- Main Content Card --}}
        <div class="bg-white shadow-md rounded-xl p-6">
            {{-- Status Filter Buttons --}}
            <div class="flex justify-end mb-4">
                <div class="flex items-center space-x-3">
                    @php
                        $statuses = [
                            'semua' => 'Semua',
                            'diterima' => 'Diterima',
                            'ditolak' => 'Ditolak',
                        ];
                        $currentStatus = request('status', 'semua');
                        // Tangkap parameter pencarian yang ada untuk dipertahankan
                        $searchParams = array_filter([
                            'keyword' => request('keyword'),
                            'per_page' => request('per_page'),
                        ]);
                    @endphp

                    @foreach ($statuses as $key => $label)
                        <a href="?{{ http_build_query(array_merge($searchParams, ['status' => $key])) }}">
                            <button
                                class="px-5 py-2 rounded-2xl font-semibold
                                {{ $currentStatus == $key
                                    ? 'bg-red-700 text-white'
                                    : 'border border-gray-300 text-gray-700 bg-white hover:bg-gray-100' }}">
                                {{ $label }}
                            </button>
                        </a>
                    @endforeach
                </div>
            </div>

            {{-- Kartu (Card) yang Membungkus Tabel Riwayat --}}
            <div class="overflow-x-auto">
                <table class="min-w-full leading-normal">
                    <thead>
                        <tr>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider rounded-tl-lg">
                                No.
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider">
                                Nama Aplikasi
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider">
                                Pemilik
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider">
                                Kategori
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider">
                                Tanggal
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider">
                                Status
                            </th>
                            <th class="px-5 py-3 border-b-2 border-gray-200 bg-gray-100 text-center text-xs font-bold text-gray-800 tracking-wider rounded-tr-lg">
                                Aksi
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(count($aplikasi) > 0)
                            @foreach($aplikasi as $data)
                                <tr>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">{{ $loop->iteration + ($aplikasi->currentPage() - 1) * $aplikasi->perPage() }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">{{ $data['nama_aplikasi'] }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">{{ $data['nama_pemilik'] }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">{{ $data->kategori->nama_kategori ?? 'Tidak Ada Kategori' }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm">
                                        <p class="text-gray-900 whitespace-no-wrap text-center">{{ \Carbon\Carbon::parse($data['tanggal_verifikasi'])->format('d-m-Y') }}</p>
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                        @if($data['status_verifikasi'] === \App\Enums\StatusTypeEnum::DITERIMA->value)
                                            <span class="relative inline-block px-3 py-1 font-semibold text-green-900 leading-tight">
                                                <span aria-hidden class="absolute inset-0 bg-green-200 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($data['status_verifikasi']) }}</span>
                                            </span>
                                        @elseif($data['status_verifikasi'] === \App\Enums\StatusTypeEnum::DITOLAK->value)
                                            <span class="relative inline-block px-3 py-1 font-semibold text-red-900 leading-tight">
                                                <span aria-hidden class="absolute inset-0 bg-red-200 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($data['status_verifikasi']) }}</span>
                                            </span>
                                        @else
                                            <span class="relative inline-block px-3 py-1 font-semibold text-gray-900 leading-tight">
                                                <span aria-hidden class="absolute inset-0 bg-gray-200 opacity-50 rounded-full"></span>
                                                <span class="relative">{{ ucfirst($data['status_verifikasi']) }}</span>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center">
                                        <div class="flex space-x-2 justify-center">
                                            <a href="{{ route('admin.riwayat.detail', ['id' => $data['id']]) }}"
                                                class="bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                                    Detail
                                            </a>
                                            @if($data['status_verifikasi'] === \App\Enums\StatusTypeEnum::DITOLAK->value)
                                                {{-- Delete Button (for 'Ditolak' status) --}}
                                                <form action="{{ route('admin.riwayat.delete', ['id' => $data['id']]) }}" method="POST" class="delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="bg-red-600 hover:bg-red-700 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                                        Hapus
                                                    </button>
                                                </form>
                                            @elseif($data['status_verifikasi'] === \App\Enums\StatusTypeEnum::DITERIMA->value && !$data['arsip']) {{-- Check if not archived --}}
                                                {{-- Archive Button (for 'Diterima' status AND not archived) --}}
                                                <form action="{{ route('admin.riwayat.archive', ['id' => $data['id']]) }}" method="POST" class="archive-form">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit"
                                                            class="bg-yellow-500 hover:bg-yellow-600 text-white text-xs font-bold py-2 px-4 rounded-lg shadow-sm transition duration-200 flex items-center justify-center">
                                                        Arsip
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="7" class="px-5 py-5 border-b border-gray-200 bg-white text-sm text-center text-gray-500">
                                    Tidak ada data riwayat verifikasi.
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>

            {{-- Bagian Pagination --}}
            <div class="flex justify-between items-center mt-6">
                <div class="text-sm text-gray-600">
                    Rows per page:
                    <select id="rows-per-page" class="ml-2 border border-gray-300 rounded-md py-1 px-2 text-gray-700 focus:outline-none focus:border-custom-primary-red" onchange="changePerPage(this.value)">
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
                    {{ $aplikasi->firstItem() }} - {{ $aplikasi->lastItem() }} of {{ $aplikasi->total() }}
                </div>
                <div class="flex space-x-2">
                    {{-- Tombol Previous --}}
                    <a href="{{ $aplikasi->previousPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200 {{ $aplikasi->onFirstPage() ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <i class="fas fa-chevron-left"></i>
                    </a>

                    {{-- Tampilkan Link Halaman --}}
                    @foreach ($aplikasi->getUrlRange(1, $aplikasi->lastPage()) as $page => $url)
                        <a href="{{ $url . '&per_page=' . request('per_page', 5) . (request('keyword') ? '&keyword=' . request('keyword') : '') . (request('status') ? '&status=' . request('status') : '') }}" class="px-3 py-1 border border-gray-300 rounded-md text-black hover:bg-gray-100 transition duration-200 {{ $page == $aplikasi->currentPage() ? 'bg-custom-primary-red text-white' : '' }}">
                            {{ $page }}
                        </a>
                    @endforeach

                    {{-- Tombol Next --}}
                    <a href="{{ $aplikasi->nextPageUrl() }}" class="px-3 py-1 border border-gray-300 rounded-md text-gray-600 hover:bg-gray-100 transition duration-200 {{ !$aplikasi->hasMorePages() ? 'opacity-50 cursor-not-allowed' : '' }}">
                        <i class="fas fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Existing changeRowsPerPage function, updated to preserve 'keyword' and 'status'
    function changeRowsPerPage(value) {
        const url = new URL(window.location.href);
        url.searchParams.set('per_page', value);
        url.searchParams.delete('page'); // Reset to first page when changing per_page

        // Preserve existing search parameters
        const keyword = url.searchParams.get('keyword');
        const status = url.searchParams.get('status');

        if (keyword) url.searchParams.set('keyword', keyword);
        if (status) url.searchParams.set('status', status);

        window.location.href = url.toString();
    }

    document.addEventListener('DOMContentLoaded', function () {
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

        // SweetAlert2 for archive confirmation
        document.querySelectorAll('.archive-form').forEach(form => {
            form.addEventListener('submit', function (e) {
                e.preventDefault(); // Prevent the default form submission

                Swal.fire({
                    title: 'Konfirmasi Arsip',
                    text: "Anda yakin ingin mengarsipkan data ini?",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#F59E0B', // Tailwind yellow-500
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Ya, Arsipkan!',
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
        @if(session('success'))
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
        @endif

        // Check for error messages from the session and display SweetAlert error
        @if(session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: "{{ session('error') }}",
            });
        @endif
    });
</script>
@endpush