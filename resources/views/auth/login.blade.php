@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <h2 class="text-2xl font-bold text-center text-gray-800 mb-2">Login</h2>
            <p class="text-center text-sm text-gray-600 mb-6">Silahkan Login Terlebih Dahulu</p>

            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}" class="space-y-4" id="loginForm">
                @csrf

                @if ($errors->has('email'))
                    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded">
                        {{ $errors->first('email') }}
                    </div>
                @endif

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" type="email" name="email"
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        :value="old('email')" autofocus autocomplete="username"
                        placeholder="Masukkan email anda" />
                    <p id="emailError" class="text-red-500 text-xs italic mt-1 hidden">The email field is required.</p>
                </div>

                <!-- Password -->
                <div>
                    <div class="flex justify-between items-center">
                        <x-input-label for="password" :value="__('Password')" />
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:underline">
                                {{ __('Lupa password?') }}
                            </a>
                        @endif
                    </div>
                    <div class="relative">
                        <button type="button" onclick="togglePasswordVisibility('password')" class="absolute right-3 top-1/2 -translate-y-1/2 z-10">
                            <!-- Eye open -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-open-icon w-5 h-5 text-gray-500 block" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2.458 12C3.732 7.943 7.523 5 12 5
                                    s8.268 2.943 9.542 7-3.732 7-9.542 7
                                    -8.268-2.943-9.542-7z" />
                            </svg>
                            <!-- Eye closed -->
                            <svg xmlns="http://www.w3.org/2000/svg" class="eye-closed-icon w-5 h-5 text-gray-500 hidden" fill="none"
                                stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path d="M13.875 18.825A10.05 10.05 0 0112 19
                                    c-4.478 0-8.269-2.944-9.543-7
                                    a9.956 9.956 0 012.342-3.36m3.093-2.52
                                    A9.953 9.953 0 0112 5c4.478 0 8.269 2.944 9.543 7
                                    a9.956 9.956 0 01-1.88 3.106" />
                                <path d="M3 3l18 18" />
                            </svg>
                        </button>
                        <x-text-input id="password" type="password" name="password"
                            class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 pr-10"
                            autocomplete="current-password"
                            placeholder="Masukkan password anda" />
                        <p id="passwordError" class="text-red-500 text-xs italic mt-1 hidden">The password field is required.</p>
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center">
                    <input id="agree" type="checkbox" name="remember"
                        class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" />
                    <label for="agree" class="ml-2 text-sm text-gray-600">
                        {{ __('Saya setuju dengan syarat dan ketentuan') }}
                    </label>
                </div>

                <!-- Submit -->
                <button type="submit" id="submitBtn" disabled
                    class="w-full bg-[#b30000] text-white font-semibold py-2 rounded-lg opacity-50 cursor-not-allowed">
                    Login
                </button>

                <!-- Or separator -->
                <div class="flex items-center my-6">
                    <hr class="flex-grow border-gray-300" />
                    <span class="mx-3 text-gray-500">Atau</span>
                    <hr class="flex-grow border-gray-300" />
                </div>

                <!-- Google Login Button -->
                <a href="{{ route('google.redirect') }}"
                    class="w-full flex items-center justify-center gap-3 border border-gray-300 rounded-lg py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 transition">
                    <img src="https://www.svgrepo.com/show/475656/google-color.svg" class="w-5 h-5" alt="Google">
                    <span>Sign in with Google</span>
                </a>

                <!-- Register Link -->
                <div class="mt-4 text-center text-sm text-gray-700">
                    Tidak punya akun?
                    <a href="{{ route('register') }}" class="text-indigo-600 hover:underline font-medium">
                        {{ __('Register') }}
                    </a>
                </div>
            </form>
        </div>
    </div>

    <script>
        function togglePasswordVisibility(inputId) {
            const input = document.getElementById(inputId);
            const eyeOpenIcon = input.closest('.relative').querySelector('.eye-open-icon');
            const eyeClosedIcon = input.closest('.relative').querySelector('.eye-closed-icon');

            if (input.type === "password") {
                input.type = "text";
                eyeOpenIcon.classList.add('hidden');
                eyeClosedIcon.classList.remove('hidden');
            } else {
                input.type = "password";
                eyeOpenIcon.classList.remove('hidden');
                eyeClosedIcon.classList.add('hidden');
            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            const agreeCheckbox = document.getElementById('agree');
            const submitBtn = document.getElementById('submitBtn');
            const loginForm = document.getElementById('loginForm');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const emailError = document.getElementById('emailError');
            const passwordError = document.getElementById('passwordError');

            // Aktifkan tombol jika checkbox dicentang
            agreeCheckbox.addEventListener('change', function () {
                const checked = this.checked;
                submitBtn.disabled = !checked;
                submitBtn.classList.toggle('opacity-50', !checked);
                submitBtn.classList.toggle('cursor-not-allowed', !checked);
                submitBtn.classList.toggle('cursor-pointer', checked);
                submitBtn.classList.toggle('hover:bg-red-700', checked);
            });

            // Validasi input saat form disubmit
            loginForm.addEventListener('submit', function (event) {
                if (!submitBtn.disabled) {
                    let valid = true;

                    if (emailInput.value.trim() === '') {
                        emailInput.classList.add('border-red-500');
                        emailError.classList.remove('hidden');
                        valid = false;
                    } else {
                        emailInput.classList.remove('border-red-500');
                        emailError.classList.add('hidden');
                    }

                    if (passwordInput.value.trim() === '') {
                        passwordInput.classList.add('border-red-500');
                        passwordError.classList.remove('hidden');
                        valid = false;
                    } else {
                        passwordInput.classList.remove('border-red-500');
                        passwordError.classList.add('hidden');
                    }

                    if (!valid) {
                        event.preventDefault();
                    }
                }
            });

            // Reset error saat mengetik
            emailInput.addEventListener('input', () => {
                emailInput.classList.remove('border-red-500');
                emailError.classList.add('hidden');
            });

            passwordInput.addEventListener('input', () => {
                passwordInput.classList.remove('border-red-500');
                passwordError.classList.add('hidden');
            });
        });
    </script>
@endsection
