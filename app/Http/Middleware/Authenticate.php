<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate
{
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::check()) {
            // Cek apakah route saat ini dimulai dengan '/admin'
            if ($request->is('admin/*')) {
                return redirect()->route('admin.login');
            }

            // Kalau bukan admin, redirect ke user login biasa
            return redirect()->route('login');
        }

        return $next($request);
    }
}