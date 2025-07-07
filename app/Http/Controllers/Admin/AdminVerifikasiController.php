<?php

namespace App\Http\Controllers\Admin;

use App\Contracts\Interfaces\KategoriInterface; // Pastikan ini digunakan jika diperlukan di masa mendatang
use App\Contracts\Interfaces\NotifikasiInterface;
use App\Contracts\Interfaces\VerifikasiAplikasiInterface;
use App\Enums\StatusTypeEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateRejectVerifikasiRequest;
use App\Models\Notifikasi; // Pastikan ini digunakan jika model Notifikasi diperlukan langsung
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
     * Data akan diurutkan dari yang terbaru oleh repository.
     */
    public function index(Request $request)
    {
        $keyword = $request->query('keyword');
        $perPage = $request->query('per_page', 5); // Ambil per_page dari request, default 5

        // Ambil semua aplikasi yang statusnya pending dengan paginasi
        // Pengurutan (orderBy) sudah ditangani di dalam metode getByStatusPaginated di repository
        $aplikasi = $this->aplikasi->getByStatusPaginated(StatusTypeEnum::PENDING->value, $perPage, $keyword);

        return view('admin.verifikasi.index', compact('aplikasi'));
    }


    /**
     * Memproses penerimaan aplikasi.
     *
     * @param Request $request Objek request.
     * @param int $id ID aplikasi yang akan diterima.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman riwayat dengan pesan sukses/error.
     */
    public function terima(Request $request, $id)
    {
        try {
            // Perbarui status verifikasi aplikasi menjadi DITERIMA
            $this->aplikasi->update($id, [
                'status_verifikasi' => StatusTypeEnum::DITERIMA->value, // Gunakan nilai enum 'diterima'
                'tanggal_verifikasi' => Carbon::now() // Set tanggal verifikasi saat ini
            ]);

            // Ambil data aplikasi yang baru saja diterima untuk notifikasi
            $aplikasiSelected = $this->aplikasi->show($id);

            // Tambahkan notifikasi untuk pengguna bahwa aplikasi telah diterima
            $this->notifikasi->store([
                'user_id' => $aplikasiSelected->id_user, // ID pengguna pemilik aplikasi
                'judul' => 'Aplikasi Diterima',
                'pesan' => 'Aplikasi "' . $aplikasiSelected->nama_aplikasi . '" telah diterima.',
                'waktu' => Carbon::now(),
                'is_read' => false
            ]);

            return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil diterima.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menerima aplikasi
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menerima aplikasi: ' . $e->getMessage());
        }
    }

    /**
     * Memproses penolakan aplikasi.
     *
     * @param UpdateRejectVerifikasiRequest $request Objek request dengan validasi alasan penolakan.
     * @param int $id ID aplikasi yang akan ditolak.
     * @return \Illuminate\Http\RedirectResponse Redirect ke halaman riwayat dengan pesan sukses/error.
     */
    public function tolak(UpdateRejectVerifikasiRequest $request, $id)
    {
        try {
            // Perbarui status verifikasi aplikasi menjadi DITOLAK
            $this->aplikasi->update($id, [
                'status_verifikasi' => StatusTypeEnum::DITOLAK->value, // Gunakan nilai enum 'ditolak'
                'alasan_penolakan' => $request->alasan_penolakan, // Simpan alasan penolakan dari request
                'tanggal_verifikasi' => Carbon::now() // Set tanggal verifikasi saat ini
            ]);

            // Ambil data aplikasi yang baru saja ditolak untuk notifikasi
            $aplikasiSelected = $this->aplikasi->show($id);

            // Tambahkan notifikasi untuk pengguna bahwa aplikasi telah ditolak
            $this->notifikasi->store([
                'user_id' => $aplikasiSelected->id_user, // ID pengguna pemilik aplikasi
                'judul' => 'Aplikasi "' . $aplikasiSelected->nama_aplikasi . '" Ditolak',
                'pesan' => $aplikasiSelected->alasan_penolakan, // Pesan notifikasi menggunakan alasan penolakan
                'waktu' => Carbon::now(),
                'is_read' => false
            ]);

            return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil ditolak.');
        } catch (\Exception $e) {
            // Tangani error jika terjadi masalah saat menolak aplikasi
            return redirect()->back()->with('error', 'Terjadi kesalahan saat menolak aplikasi: ' . $e->getMessage());
        }
    }

    /**
     * Menampilkan detail aplikasi untuk verifikasi.
     *
     * @param int $id ID aplikasi yang akan ditampilkan detailnya.
     * @return \Illuminate\Contracts\View\View Tampilan detail verifikasi.
     */
    public function detailVerifikasi($id) {
        $aplikasi = $this->aplikasi->show($id);

        return view('admin.verifikasi.detail', compact('aplikasi'));
    }
}