<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Kategori; // Add this line

class KategoriController extends Controller
{
    public function index(): View
    {
        return view('kategori.index');
    }

    public function allCategories(): View
    {
        // Fetch only categories where sub_kategori is 'aplikasi'
        $aplikasiKategoris = Kategori::where('sub_kategori', 'aplikasi')
                                     ->orderBy('nama_kategori')
                                     ->get();

        return view('kategori.index', compact('aplikasiKategoris'));
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
