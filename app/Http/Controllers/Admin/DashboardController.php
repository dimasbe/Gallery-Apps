<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\AplikasiInterface; 
use App\Contracts\Interfaces\UserInterface;     
use App\Contracts\Interfaces\KategoriInterface; 
use App\Http\Controllers\Controller;
use App\Services\DashboardService;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    private UserInterface $user;
    private AplikasiInterface $aplikasi;
    private DashboardService $dashboardService;

    public function __construct(
        UserInterface $user,
        AplikasiInterface $aplikasi,
        DashboardService $dashboardService
    ) {
        $this->user = $user;
        $this->aplikasi = $aplikasi;
        $this->dashboardService = $dashboardService;
    }

    public function index()
    {
        $jumlahPengguna = $this->user->getCount();
        $jumlahAplikasi = $this->aplikasi->getCount();

        return view('admin.dashboard', compact('jumlahPengguna', 'jumlahAplikasi'));
    }

    public function getChartData(Request $request)
    {
        $month = $request->get('month', now()->month);
        $year = $request->get('year', now()->year);

        $chartData = $this->dashboardService->getChartData($month, $year);

        return response()->json($chartData);
    }
}