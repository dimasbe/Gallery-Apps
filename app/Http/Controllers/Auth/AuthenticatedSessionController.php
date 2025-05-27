<?php

namespace App\Http\Controllers\Auth;

use App\Contracts\Interfaces\UserInterface;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    protected UserInterface $userInterface;

    public function __construct(UserInterface $userInterface)
    {
        $this->userInterface = $userInterface;
    }

    public function create(): View
    {
        return view('auth.login');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        $user = $this->userInterface->findByEmail($request->email);

        if (! $user || ! $this->userInterface->checkPassword($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => 'Email atau password salah.',
            ]);
        }

        Auth::login($user, $request->boolean('remember'));

        $request->session()->regenerate();

        // --- BAGIAN INI YANG DIUBAH ---
        // Jika role user adalah 'admin', redirect ke admin.dashboard
        if ($user->role === 'admin') {
            return redirect()->intended(route('admin.dashboard'));
        }

        // Jika bukan admin (asumsi user biasa), redirect ke dashboard user
        return redirect()->intended(route('dashboard')); // Menggunakan nama rute 'dashboard' untuk user biasa
        // --- AKHIR BAGIAN YANG DIUBAH ---
    }

    public function destroy(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}