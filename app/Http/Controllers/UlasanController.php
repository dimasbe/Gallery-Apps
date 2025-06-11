<?php

namespace App\Http\Controllers;

use App\Models\Aplikasi;
use App\Contracts\Interfaces\UlasanInterface; 
use App\Http\Requests\StoreUlasanRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class UlasanController extends Controller
{
    protected UlasanInterface $ulasan; 

    public function __construct(UlasanInterface $ulasan)
    {
        $this->ulasan = $ulasan;
        // $this->middleware('auth')->only(['store']);
    }

    public function store(StoreUlasanRequest $request): JsonResponse
    {
        try {
            $ulasanData = [
                'id_aplikasi' => $request->validated('aplikasi_id'),
                'id_user' => Auth::id(), 
                'ulasan' => $request->validated('ulasan_teks'),
            ];

            $ulasan = $this->ulasan->store($ulasanData);

            return response()->json([
                'message' => 'Ulasan berhasil ditambahkan!',
                'ulasan' => [
                    'user_name' => $ulasan->user->name,
                    'ulasan_teks' => $ulasan->ulasan,
                    'created_at_formatted' => $ulasan->created_at->diffForHumans(),
                    'user_avatar' => asset('images/ulasan.png'), 
                ]
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan ulasan.', 'error' => $e->getMessage()], 500);
        }
    }

    public function index(Aplikasi $aplikasi): JsonResponse
    {
        $ulasan = $this->ulasan->getAllByAplikasiId($aplikasi->id_aplikasi);
        return response()->json($ulasan);
    }
}