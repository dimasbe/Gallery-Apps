<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <!-- Judul -->
            <h2 class="text-2xl font-bold text-center text-black">Konfirmasi Password</h2>
            <p class="text-sm text-center text-gray-600 mb-6">
                Ini adalah area yang aman dari aplikasi. Harap konfirmasi password Anda sebelum melanjutkan.
            </p>

            <!-- Form Konfirmasi -->
            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf

                <!-- Password -->
                <div class="mb-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full"
                                  type="password"
                                  name="password"
                                  required autocomplete="current-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Tombol -->
                <div class="flex justify-end">
                    <x-primary-button class="w-full justify-center bg-[#b30000] hover:bg-red-700">
                        {{ __('Konfirmasi') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
