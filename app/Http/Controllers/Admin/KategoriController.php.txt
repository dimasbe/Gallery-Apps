<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // For file storage

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'semua'); // Default filter is 'semua'

        if ($filter === 'aplikasi') {
            $kategoris = Kategori::where('sub_kategori', 'aplikasi')->orderBy('tanggal_dibuat', 'desc')->get();
        } elseif ($filter === 'berita') {
            $kategoris = Kategori::where('sub_kategori', 'berita')->orderBy('tanggal_dibuat', 'desc')->get();
        } else {
            $kategoris = Kategori::orderBy('tanggal_dibuat', 'desc')->get();
        }

        return view('admin.kategori.index', compact('kategoris', 'filter'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'sub_kategori' => 'required|in:aplikasi,berita',
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambarPath = null;
        if ($request->hasFile('gambar')) {
            $gambarPath = $request->file('gambar')->store('public/kategori_gambar');
            $gambarPath = str_replace('public/', 'storage/', $gambarPath); // Adjust path for public access
        }

        Kategori::create([
            'sub_kategori' => $request->sub_kategori,
            'nama_kategori' => $request->nama_kategori,
            'gambar' => $gambarPath,
        ]);

        return response()->json(['message' => 'Kategori berhasil ditambahkan!']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return response()->json($kategori);
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        return response()->json($kategori);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'sub_kategori' => 'required|in:aplikasi,berita',
            'nama_kategori' => 'required|string|max:255',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $gambarPath = $kategori->gambar;
        if ($request->hasFile('gambar')) {
            // Delete old image if exists
            if ($gambarPath) {
                Storage::delete(str_replace('storage/', 'public/', $gambarPath));
            }
            $gambarPath = $request->file('gambar')->store('public/kategori_gambar');
            $gambarPath = str_replace('public/', 'storage/', $gambarPath);
        } elseif ($request->input('remove_gambar') == 'true') {
            // Option to remove existing image without uploading new one
            if ($gambarPath) {
                Storage::delete(str_replace('storage/', 'public/', $gambarPath));
            }
            $gambarPath = null;
        }

        $kategori->update([
            'sub_kategori' => $request->sub_kategori,
            'nama_kategori' => $request->nama_kategori,
            'gambar' => $gambarPath,
        ]);

        return response()->json(['message' => 'Kategori berhasil diupdate!']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->gambar) {
            Storage::delete(str_replace('storage/', 'public/', $kategori->gambar));
        }
        $kategori->delete();
        return response()->json(['message' => 'Kategori berhasil dihapus!']);
    }
}