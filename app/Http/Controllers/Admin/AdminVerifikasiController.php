<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
// use App\Models\User; // Jika Anda perlu mengambil data user
// use App\Models\Transaction; // Jika Anda perlu mengambil data transaksi

class AdminVerifikasiController extends Controller
{
    public function index()
    {
        // Contoh data dummy, ganti dengan data dari database Anda
        $totalUsers = 1500; // User::count();
        $monthlyRevenue = [1200, 1900, 3000, 5000, 2000, 3000, 4500]; // Data nyata dari DB
        $recentTransactions = [
            // Ambil dari DB
            ['id' => 1, 'name' => 'John Doe', 'product' => 'Laptop Gaming', 'date' => '2024-05-20', 'amount' => 1200, 'status' => 'Selesai'],
            ['id' => 2, 'name' => 'Jane Smith', 'product' => 'Smartphone', 'date' => '2024-05-19', 'amount' => 800, 'status' => 'Pending'],
            ['id' => 3, 'name' => 'Peter Jones', 'product' => 'Monitor Curved', 'date' => '2024-05-18', 'amount' => 350, 'status' => 'Selesai'],
            ['id' => 4, 'name' => 'Alice Brown', 'product' => 'Keyboard Mekanik', 'date' => '2024-05-17', 'amount' => 120, 'status' => 'Dibatalkan'],
        ];

        return view('admin.verifikasi', compact('totalUsers', 'monthlyRevenue', 'recentTransactions'));
    }
}