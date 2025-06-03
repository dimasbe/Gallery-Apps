<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RiwayatController extends Controller
{
    public function index()
    {
        // Cukup kembalikan view.
        // Tidak perlu mengambil data dari database atau menggunakan model Riwayat dulu.
        return view('admin.riwayat.index'); // Pastikan path view ini benar
    }
}
