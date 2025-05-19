@php
    $googleAvatar = filter_var($user->google_avatar ?? null, FILTER_VALIDATE_URL) ? $user->google_avatar : null;
    $localAvatar = $user->avatar ? asset('storage/' . $user->avatar) : null;
    $avatarUrl = $localAvatar ?: $googleAvatar ?: null;

    $name = $user->name ?? '';
    $nameParts = preg_split('/\s+/', trim($name));
    $initial = '';
    foreach ($nameParts as $part) {
        $initial .= mb_substr($part, 0, 1);
    }
    $initial = strtoupper(mb_substr($initial, 0, 2));
@endphp

@extends('layouts.app')

@section('content')
    <div class="max-w-2xl mx-auto p-4 relative text-[#1b1b18] dark:text-[#EDEDEC] font-[Poppins]">
        <a href="{{ route('dashboard') }}" class="inline-flex items-center text-sm text-gray-600 dark:text-gray-300 hover:text-gray-900 mb-4">
            <svg class="w-5 h-5 mr-1" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
            Kembali
        </a>

        <h2 class="text-xl font-semibold mb-4">Edit Profile</h2>

        @if (session('status') === 'profile-updated')
            <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                Profile updated successfully!
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data"
              x-data="{ photoPreview: null, photoChanged: false, showMenu: false, showModal: false }">
            @csrf
            @method('PATCH')

            {{-- Avatar & Info User --}}
            <div class="mb-6 flex items-start space-x-4">
                <div class="relative">
                    <template x-if="photoPreview">
                        <img
                            @click="showMenu = true"
                            x-bind:src="photoPreview"
                            class="w-36 h-36 rounded-full object-cover border border-gray-300 cursor-pointer"
                            alt="Avatar"
                            onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';"
                        >
                    </template>
                    <template x-if="!photoPreview">
                        @if ($avatarUrl)
                            <img
                                @click="showMenu = true"
                                src="{{ $avatarUrl }}"
                                class="w-36 h-36 rounded-full object-cover border border-gray-300 cursor-pointer"
                                alt="Avatar"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';"
                            >
                        @else
                            <div
                                @click="showMenu = true"
                                class="w-36 h-36 rounded-full border border-gray-300 bg-[#AD1500] text-white flex items-center justify-center text-6xl font-bold cursor-pointer select-none"
                            >
                                {{ $initial }}
                            </div>
                        @endif
                    </template>
                </div>

                <div>
                    <p class="text-lg font-semibold">{{ $user->name }}</p>
                    <p class="text-sm text-gray-500 dark:text-gray-400">
                        Bergabung sejak {{ $user->created_at->locale('id')->isoFormat('D MMMM YYYY') }}
                    </p>
                </div>
            </div>

            {{-- Dropdown menu --}}
            <div
                x-show="showMenu"
                @click.away="showMenu = false"
                style="display: none;"
                class="absolute bg-white dark:bg-[#1b1b18] shadow-md border rounded w-48 z-50"
            >
                <button type="button" @click="showMenu = false; showModal = true" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-[#2a2a27]">
                    Lihat Gambar
                </button>
                <button type="button" @click="$refs.photoInput.click(); showMenu = false" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-[#2a2a27]">
                    Update Gambar
                </button>
                <button type="submit" name="delete_avatar" value="1" class="block w-full text-left px-4 py-2 hover:bg-gray-100 dark:hover:bg-[#2a2a27] text-red-600">
                    Hapus Gambar
                </button>
            </div>

            {{-- Modal --}}
            <div
                x-show="showModal"
                style="display: none;"
                class="fixed inset-0 flex items-center justify-center z-50"
                @click="showModal = false"
            >
                <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" aria-hidden="true"></div>
                <div @click.stop class="z-50 rounded-full overflow-hidden shadow-lg w-96 h-96 border-4 border-white bg-white dark:bg-[#1b1b18]">
                    <template x-if="photoPreview">
                        <img
                            x-bind:src="photoPreview"
                            alt="Foto Profil"
                            class="w-full h-full object-cover"
                            onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';"
                        >
                    </template>
                    <template x-if="!photoPreview">
                        @if ($avatarUrl)
                            <img
                                src="{{ $avatarUrl }}"
                                alt="Foto Profil"
                                class="w-full h-full object-cover"
                                onerror="this.onerror=null;this.src='{{ asset('images/default-avatar.png') }}';"
                            >
                        @else
                            <div class="w-full h-full bg-[#AD1500] flex items-center justify-center text-[10rem] font-bold text-white select-none">
                                {{ $initial }}
                            </div>
                        @endif
                    </template>
                </div>
            </div>

            {{-- Input file --}}
            <input
                type="file"
                name="avatar"
                accept="image/*"
                class="hidden"
                x-ref="photoInput"
                @change="() => {
                    const file = $refs.photoInput.files[0];
                    if (!file) return;
                    const reader = new FileReader();
                    reader.onload = e => {
                        photoPreview = e.target.result;
                        photoChanged = true;
                    };
                    reader.readAsDataURL(file);
                }"
            >

            {{-- Confirm Avatar Update --}}
            <div x-show="photoChanged" x-transition class="mb-6">
                <button type="submit" name="update_avatar" value="1"
                        class="w-full bg-[#b30000] text-white px-4 py-2 rounded hover:bg-[#990000]">
                    Confirm Update Avatar
                </button>
            </div>

            {{-- Form input --}}
            <div class="mb-4">
                <label class="block text-sm font-medium">Name</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">Email</label>
                <input type="email" name="email" value="{{ old('email', $user->email) }}"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium">New Password</label>
                <input type="password" name="password"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium">Confirm Password</label>
                <input type="password" name="password_confirmation"
                       class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
            </div>

            <div class="mt-6 flex justify-center">
                <button type="submit"
                        class="w-full bg-[#b30000] text-white px-4 py-2 rounded hover:bg-[#990000]">
                    Simpan
                </button>
            </div>
        </form>
    </div>
@endsection
