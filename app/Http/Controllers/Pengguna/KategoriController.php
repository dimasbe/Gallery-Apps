<?php

namespace App\Http\Controllers\Pengguna;

use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use App\Contracts\Interfaces\KategoriInterface; // Your repository interface
use App\Enums\KategoriTypeEnum; // Your enum for category types

class KategoriController extends Controller
{
    private KategoriInterface $kategori;

    public function __construct(KategoriInterface $kategori)
    {
        $this->kategori = $kategori;
    }

    /**
     * Display a listing of application categories.
     * This is likely for a page showing all categories, e.g., /kategori
     *
     * @return View
     */
    public function index(): View
    {
        // This method fetches categories specifically filtered as 'APLIKASI' type.
        // It's good for a dedicated 'all categories' page.
        $aplikasiKategoris = $this->kategori->filterBySubKategori(KategoriTypeEnum::APLIKASI->value);

        return view('pengguna.kategori.index', compact('aplikasiKategoris'));
    }

    /**
     * Display applications for a specific category by its name.
     * This method handles routes like /kategori/{nama-kategori}.
     *
     * @param string $nama The URL-encoded name of the category.
     * @return View
     */
    public function showByNama($nama): View
    {
        // Decode the URL parameter to get the actual category name (e.g., 'Permainan' from 'permainan')
        $formattedNama = ucfirst(urldecode($nama));
        $kategori = $this->kategori->getByNameWithAplikasi($formattedNama);

        // Ensure $kategori is not null before accessing its properties.
        // If the category is not found, you might want to redirect or show a 404 page.
        if (!$kategori) {
            abort(404, 'Kategori tidak ditemukan.');
        }

        // Access applications through the relationship defined in your Kategori model/entity.
        $aplikasi = $kategori->aplikasi;

        // Pass the category and its applications to the view.
        return view('pengguna.kategori.show', compact('kategori', 'aplikasi'));
    }
}