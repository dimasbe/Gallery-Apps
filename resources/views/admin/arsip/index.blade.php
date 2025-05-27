@extends('layouts.admin') {{-- Memastikan halaman ini menggunakan layout admin Anda --}}

@section('title', 'Arsip') {{-- INI YANG HARUS ANDA UBAH/TAMBAHKAN --}}

@section('content')
    {{-- Konten halaman Arsip Anda di sini --}}
    <div class="bg-white shadow-md rounded-lg p-6 mb-6">
        <div class="flex justify-between items-center">
            <h1 class="text-3xl font-bold text-gray-800">Arsip</h1>
            <nav aria-label="breadcrumb">
                <ol class="flex items-center text-sm text-gray-600">
                    <li class="flex items-center">
                        <a href="{{ route('admin.dashboard') }}" class="hover:text-custom-primary-red">Beranda</a>
                        <span class="mx-2 text-custom-primary-red text-base">&bull;</span>
                    </li>
                    <li class="text-custom-primary-red" aria-current="page">Arsip</li>
                </ol>
            </nav>
        </div>
    </div>
    {{-- Sisa konten halaman arsip Anda --}}
@endsection