<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    public function index(): View
    {
        return view('kategori.index');
    }

    public function show($slug)
    {
        $view = 'kategori.' . $slug;

        if (view()->exists($view)) {
            return view($view, compact('slug'));
        }

        return view('kategori', compact('slug')); // fallback jika file spesifik tidak ada
    }
}
