<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Two\GoogleProvider;
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Models\User;

class GoogleController extends Controller
{
    /**
     * Redirect user ke Google OAuth
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirect()
    {
        // Ambil parameter 'from' dari request (bisa 'register' atau 'login')
        $from = request('from');
        
        // Simpan ke session supaya bisa dipakai pas callback
        if ($from === 'register' || $from === 'login') {
            session(['google_from' => $from]);
        }

        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');

        // Tambah opsi prompt untuk memilih akun setiap login
        return $driver
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    /**
     * Callback dari Google setelah login
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function callback()
    {
        /** @var GoogleProvider $driver */
        $driver = Socialite::driver('google');

        /** @var SocialiteUser $googleUser */
        $googleUser = $driver->stateless()->user();

        // Ambil & hapus session 'google_from'
        $from = session()->pull('google_from');

        // Cek apakah user dengan email tersebut sudah ada
        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            // Kalau user sudah ada tapi belum terhubung Google, tolak login via Google
            if (!$user->google_id) {
                return redirect()->route('login')->withErrors([
                    'email' => 'Email ini sudah terdaftar. Silakan login menggunakan metode biasa.',
                ]);
            }

            // Login user lama
            Auth::login($user);

            if ($from === 'register') {
                return redirect()->route('dashboard')->with('status', 'Akun sudah terdaftar. Anda berhasil login dengan Google.');
            }

            return redirect()->route('dashboard');
        }

        // Kalau user belum ada, buat akun baru tanpa menyimpan avatar Google
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'role' => 'user',
            'password' => bcrypt(uniqid()), // Password random
            'avatar' => null, // Tidak simpan avatar Google
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Berhasil daftar dan login dengan akun Google.');
    }
}
