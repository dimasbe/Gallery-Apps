<?php

namespace App\Http\Controllers\Pengguna;

use App\Contracts\Interfaces\KategoriInterface;
use App\Enums\KategoriTypeEnum;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KategoriController extends Controller
{
    private KategoriInterface $kategori;

    public function __construct(KategoriInterface $kategori)
    {
        $this->kategori = $kategori;
    }

    public function index(Request $request): View
    {
        $filter = $request->query('filter', KategoriTypeEnum::APLIKASI->value);
        $search = $request->query('search'); // Ambil nilai 'search' dari URL query string

        $criteria = [];

        // Tambahkan filter sub_kategori ke array kriteria jika berlaku
        if ($filter === KategoriTypeEnum::APLIKASI->value) {
            $criteria['sub_kategori'] = KategoriTypeEnum::APLIKASI->value;
        } elseif ($filter === KategoriTypeEnum::BERITA->value) {
            $criteria['sub_kategori'] = KategoriTypeEnum::BERITA->value;
        }
        // Jika $filter bukan 'aplikasi' atau 'berita', maka tidak ada filter sub_kategori yang diterapkan,
        // yang berarti akan mengambil semua kategori (kemungkinan difilter oleh pencarian).

        // Tambahkan kriteria pencarian jika ada
        if ($search) {
            $criteria['search'] = $search;
        }

        // Gunakan metode filter generik dari repository
        $kategoris = $this->kategori->filter($criteria);

        return view('pengguna.kategori.index', [
            'categories' => $kategoris,
            'filter' => $filter,
            'search' => $search, // Penting: Kirim kembali nilai $search ke view untuk mengisi input form
        ]);
    }

    public function show(string $slug): View
    {
        $category = $this->kategori->findBySlug($slug);

        return view('pengguna.kategori.show', compact('category'));
    }
}