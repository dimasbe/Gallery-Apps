<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-black">Reset Password</h2>
            <p class="text-center text-sm text-gray-600 mb-6">
                Silakan buat password baru untuk akun Anda.
            </p>

            <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email"
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        type="email" name="email"
                        :value="old('email', $request->email)" required autofocus autocomplete="username"
                        placeholder="Masukkan email Anda" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password Baru')" />
                    <x-text-input id="password"
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        type="password" name="password" required autocomplete="new-password"
                        placeholder="Masukkan password baru" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Password')" />
                    <x-text-input id="password_confirmation"
                        class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        type="password" name="password_confirmation" required autocomplete="new-password"
                        placeholder="Ulangi password baru" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit"
                        class="w-full bg-[#b30000] text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition">
                        Reset Password
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
