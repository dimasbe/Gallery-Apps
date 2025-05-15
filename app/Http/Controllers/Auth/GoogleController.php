<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class GoogleController extends Controller
{
    public function redirect()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider $googleDriver */
        $googleDriver = Socialite::driver('google');

        return $googleDriver->with(['prompt' => 'select_account'])->redirect();
    }

    public function callback()
    {
        /** @var \Laravel\Socialite\Two\GoogleProvider $googleDriver */
        $googleDriver = Socialite::driver('google');

        $googleUser = $googleDriver->stateless()->user();

        $user = User::where('email', $googleUser->getEmail())->first();

        if ($user) {
            if (!$user->google_id) {
                // Email sudah ada tapi belum terhubung dengan Google
                // Tolak login Google dan beri pesan error
                return redirect()->route('login')->withErrors([
                    'email' => 'Email ini sudah terdaftar. Silakan login menggunakan metode biasa.',
                ]);
            } else {
                // Update avatar jika perlu
                $user->update([
                    'avatar' => $googleUser->getAvatar(),
                ]);
            }
        } else {
            // Buat user baru dengan data Google
            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'avatar' => $googleUser->getAvatar(),
                'role' => 'user',
                'password' => bcrypt(uniqid()), // password random
            ]);
        }

        Auth::login($user);

        return redirect()->route('dashboard');
    }
}
