<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Laravel\Socialite\Contracts\Provider;
use Laravel\Socialite\Two\User as SocialiteUser;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirect()
    {
        // Simpan asal permintaan (misalnya dari sign up) ke dalam session
        $from = request()->query('from');
        session(['google_from' => $from]);

        /** @var \Laravel\Socialite\Two\GoogleProvider|Provider $googleDriver */
        $googleDriver = Socialite::driver('google');

        return $googleDriver
            ->with(['prompt' => 'select_account'])
            ->redirect();
    }

    public function callback()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider|Provider $googleDriver */
        $googleDriver = Socialite::driver('google');

        /** @var SocialiteUser $googleUser */
        $googleUser = $googleDriver->stateless()->user();

        $from = session()->pull('google_from'); // Ambil dan hapus dari session

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if (!$user->google_id) {
                // Email sudah ada tapi belum terhubung dengan Google
                return redirect()->route('login')->withErrors([
                    'email' => 'Email ini sudah terdaftar. Silakan login menggunakan metode biasa.',
                ]);
            }

            // Update avatar jika perlu
            $user->update([
                'avatar' => $googleUser->getAvatar(),
            ]);

            Auth::login($user);

            // Kalau dari halaman register, beri notifikasi
            if ($from === 'register') {
                return redirect()->route('dashboard')->with('status', 'Akun sudah terdaftar. Anda berhasil login dengan Google.');
            }

            return redirect()->route('dashboard');
        }

        // Jika user belum terdaftar → buat baru
        $user = User::create([
            'name' => $googleUser->getName(),
            'email' => $googleUser->getEmail(),
            'google_id' => $googleUser->getId(),
            'role' => 'user',
            'password' => bcrypt(uniqid()),
        ]);

        Auth::login($user);

        return redirect()->route('dashboard')->with('status', 'Berhasil daftar dan login dengan akun Google.');
    }
}
