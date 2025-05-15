<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-white">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-black">Lupa Password</h2>
            <p class="text-center text-sm text-gray-600 mb-6">
                Masukkan email yang terdaftar, kami akan mengirimkan link untuk reset password Anda.
            </p>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full p-3 border-2 border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500"
                        type="email" name="email" :value="old('email')" required autofocus
                        placeholder="Masukkan email Anda" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <div class="flex items-center justify-end mt-4">
                    <button type="submit"
                        class="w-full bg-[#b30000] text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition">
                        Kirim Link Reset Password
                    </button>
                </div>
            </form>

            <!-- Kembali ke login -->
            <div class="mt-4 text-center text-sm text-gray-700">
                Ingat password Anda?
                <a href="{{ route('login') }}" class="text-indigo-600 hover:underline font-medium">
                    Login
                </a>
            </div>
        </div>
    </div>
</x-guest-layout>
