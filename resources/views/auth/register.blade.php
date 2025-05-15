<x-guest-layout>
    <h2 class="text-center text-2xl font-bold mb-6">Register</h2>

    <form method="POST" action="{{ route('register') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" name="name" type="text" autocomplete="name" required
                class="mt-1 block w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" name="email" type="email" autocomplete="email" required
                class="mt-1 block w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" name="password" type="password" autocomplete="new-password" required
                class="mt-1 block w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" required
                class="mt-1 block w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500" />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <!-- Button Register -->
        <div class="flex items-center justify-between">
            <a href="{{ route('login') }}" class="underline text-sm text-gray-600 hover:text-gray-900">
                Already have an account? Login
            </a>

            <x-primary-button>
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Or separator -->
    <div class="flex items-center my-6">
        <hr class="flex-grow border-gray-300" />
        <span class="mx-3 text-gray-500">or</span>
        <hr class="flex-grow border-gray-300" />
    </div>

    <!-- Register/Login with Google -->
    <div>
        <a href="{{ route('google.redirect') }}"
           class="flex items-center justify-center w-full p-3 rounded-lg bg-red-600 text-white font-semibold hover:bg-red-700 transition">
            <svg class="w-6 h-6 mr-2" viewBox="0 0 48 48" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
            </svg>
            <span>Register with Google</span>
        </a>
    </div>
</x-guest-layout>
