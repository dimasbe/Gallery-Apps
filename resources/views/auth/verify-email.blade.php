<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center">
        <div class="w-full max-w-md bg-white rounded-xl shadow-xl p-8">
            <!-- Title -->
            <h2 class="text-2xl font-bold text-center text-black">Verifikasi Email</h2>
            <p class="text-sm text-center text-gray-600 mb-6">
                Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan mengklik
                tautan yang telah kami kirim ke email Anda. Jika Anda belum menerima emailnya, kami akan dengan senang hati mengirim ulang.
            </p>

            <!-- Status Message -->
            @if (session('status') == 'verification-link-sent')
                <div class="mb-4 text-sm font-medium text-green-600 text-center">
                    Link verifikasi baru telah dikirim ke email Anda.
                </div>
            @endif

            <!-- Resend Verification Link -->
            <form method="POST" action="{{ route('verification.send') }}" class="mb-4">
                @csrf
                <button type="submit"
                    class="w-full bg-[#b30000] text-white font-semibold py-2 rounded-lg hover:bg-red-700 transition">
                    Kirim Ulang Email Verifikasi
                </button>
            </form>

            <!-- Logout -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                    class="w-full text-sm text-gray-600 hover:text-black underline text-center">
                    Keluar
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
