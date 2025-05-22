@extends('layouts.app')

@section('content')
    <div class="min-h-screen flex items-center justify-center bg-white">
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
                        :value="old('email')" required autofocus autocomplete="username" />
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
                    <x-text-input id="password" type="password" name="password"
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        required autocomplete="current-password" />
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
        const agreeCheckbox = document.getElementById('agree');
        const submitBtn = document.getElementById('submitBtn');

        agreeCheckbox.addEventListener('change', function() {
            if (this.checked) {
                submitBtn.disabled = false;
                submitBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        });
    </script>
@endsection
