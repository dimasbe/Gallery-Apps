<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\KategoriInterface;
use App\Contracts\Interfaces\NotifikasiInterface;
use App\Contracts\Interfaces\VerifikasiAplikasiInterface;
use App\Enums\StatusTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRejectVerifikasiRequest;
use App\Models\Notifikasi;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdminVerifikasiController extends Controller
{
    protected VerifikasiAplikasiInterface $aplikasi;
    protected NotifikasiInterface $notifikasi;

    public function __construct(
        VerifikasiAplikasiInterface $aplikasi,
        NotifikasiInterface $notifikasi
    ) {
        $this->aplikasi = $aplikasi;
        $this->notifikasi = $notifikasi;
    }

    /**
     * Menampilkan daftar aplikasi yang perlu diverifikasi.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $perPage = $request->query('per_page', 5); // Ambil per_page dari request, default 10

        // Ambil semua aplikasi yang statusnya pending dengan paginasi
        // Gunakan metode paginate dari repository atau Query Builder
        $aplikasi = $this->aplikasi->getByStatusPaginated(StatusTypeEnum::PENDING->value, $perPage, $keyword);

        return view('admin.verifikasi.index', compact('aplikasi'));
    }


    /**
     * Memproses penerimaan aplikasi.
     */
    public function terima(Request $request, $id)
    {
        try {
            
            $this->aplikasi->update($id, [
                'status_verifikasi' => StatusTypeEnum::DITERIMA->value, // Gunakan nilai enum 'diterima'
                'tanggal_verifikasi' => Carbon::now() // Set tanggal verifikasi
            ]);

            // Menambahkan Notifikasi
            $aplikasiSelected = $this->aplikasi->show($id);
            $this->notifikasi->store([
                'user_id' => $aplikasiSelected->id_user, // fallback ke user login
                'judul' => 'Aplikasi Diterima',
                'pesan' => 'Aplikasi "' . $aplikasiSelected->nama_aplikasi . '" telah diterima.',
                'waktu' => Carbon::now(),
                'is_read' => false
            ]);

            return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil diterima.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menerima aplikasi: ' . $e->getMessage());
        }
    }

    /**
     * Memproses penolakan aplikasi.
     */
    public function tolak(UpdateRejectVerifikasiRequest $request, $id)
    {
        try {
            $this->aplikasi->update($id, [
                'status_verifikasi' => StatusTypeEnum::DITOLAK->value, // Gunakan nilai enum 'ditolak'
                'alasan_penolakan' => $request->alasan_penolakan, // Ganti 'catatan_penolakan'
                'tanggal_verifikasi' => Carbon::now() // Set tanggal verifikasi
            ]);

            // Menambahkan Notifikasi
            $aplikasiSelected = $this->aplikasi->show($id);
            $this->notifikasi->store([
                'user_id' => $aplikasiSelected->id_user, // fallback ke user login
                'judul' => 'Aplikasi "' . $aplikasiSelected->nama_aplikasi . '" Ditolak',
                'pesan' => $aplikasiSelected->alasan_penolakan,
                'waktu' => Carbon::now(),
                'is_read' => false
            ]);

            return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil ditolak.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak aplikasi: ' . $e->getMessage());
        }
    }

    public function detailVerifikasi($id) { 
        $aplikasi = $this->aplikasi->show($id);

        return view('admin.verifikasi.detail', compact('aplikasi'));
    }
}