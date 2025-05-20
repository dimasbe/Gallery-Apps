@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-black">Register</h2>
            <p class="text-center text-sm text-gray-600 mb-6">Selamat Datang di GalleryApps</p>

            <form method="POST" action="{{ route('register') }}" class="space-y-4" id="registerForm">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" />
                    <x-text-input id="name" name="name" type="text" required
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan nama lengkap anda"
                        autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" name="email" type="email" required
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan email anda"
                        autocomplete="email" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" name="password" type="password" required
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan password anda"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Password Confirmation -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation" name="password_confirmation" type="password" required
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        placeholder="Masukkan ulang password anda"
                        autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Agreement -->
                <div class="flex items-start">
                    <input id="terms" name="terms" type="checkbox"
                        class="mt-1 rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <label for="terms" class="ml-2 text-sm text-gray-600">Saya setuju dengan syarat dan kebijakan</label>
                </div>

                <!-- Register Button -->
                <button type="submit" id="registerBtn" disabled
                    class="w-full bg-[#b30000] text-white font-semibold py-2 rounded-lg opacity-50 cursor-not-allowed">
                    Register
                </button>
            </form>

            <!-- Or separator -->
            <div class="flex items-center my-6">
                <hr class="flex-grow border-gray-300" />
                <span class="mx-3 text-gray-500">Atau</span>
                <hr class="flex-grow border-gray-300" />
            </div>

            <!-- Google Register -->
            <a href="{{ route('google.redirect', ['from' => 'register']) }}"
                class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google" />
                <span>Sign up with Google</span>
            </a>

            <!-- Login link bawah -->
            <div class="mt-4 text-center text-sm text-gray-700">
                Sudah punya akun?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">
                    Login
                </a>
            </div>
        </div>
    </div>

    <script>
        const termsCheckbox = document.getElementById('terms');
        const registerBtn = document.getElementById('registerBtn');

        termsCheckbox.addEventListener('change', function () {
            if (this.checked) {
                registerBtn.disabled = false;
                registerBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                registerBtn.disabled = true;
                registerBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>
@endsection
