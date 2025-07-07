<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class UserMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login'); // Redirect ke login user jika belum login
        }

        // Periksa apakah pengguna memiliki role 'user'
        // Jika Anda punya banyak role selain 'admin', Anda bisa menggunakan array:
        // if (!in_array(Auth::user()->role, ['user', 'editor', 'contributor'])) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard')->with('error', 'Anda tidak memiliki akses ke halaman pengguna.'); // Redirect admin
        }

        return $next($request);
    }
}
