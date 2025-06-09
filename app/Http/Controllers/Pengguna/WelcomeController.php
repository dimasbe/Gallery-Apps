<?php

namespace App\Http\Controllers\Pengguna;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Berita; // Assuming your news model is named 'Berita'
use App\Models\Kategori; // Assuming your category model is named 'Kategori'

class WelcomeController extends Controller
{
    /**
     * Display the welcome page with latest news.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // Fetch the latest 3 news articles. Adjust the number as needed.
        // Make sure to order them by creation date in descending order.
        $beritas = Berita::orderBy('tanggal_dibuat', 'desc')->take(3)->get();

        return view('welcome', compact('beritas'));
    }
}