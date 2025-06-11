<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Enums\StatusTypeEnum;
use App\Contracts\Interfaces\AplikasiInterface;
use App\Http\Requests\RejectAplikasiRequest; 

class AdminRiwayatController extends Controller
{
    private AplikasiInterface $aplikasi;

    public function __construct(AplikasiInterface $aplikasi)
    {
        $this->aplikasi = $aplikasi;
    }

    /**
     * Display a listing of the verified applications.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 10);
        $aplikasi = $this->aplikasi->getVerifiedPaginated($request, $perPage);

        return view('admin.riwayat.index', compact('aplikasi'));
    }

    /**
     * Display the specified verified application details.
     *
     * @param  int  $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function detail(int $id): View|RedirectResponse
    {
        $aplikasi = $this->aplikasi->findVerified($id);

        if (!$aplikasi) {
            return redirect()->route('admin.riwayat.index')->with('error', 'Data riwayat tidak ditemukan.');
        }

        return view('admin.riwayat.detail', compact('aplikasi'));
    }

    /**
     * Verify an application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function verify(int $id): RedirectResponse
    {
        $aplikasi = $this->aplikasi->verify($id);

        if (!$aplikasi) {
            return back()->with('error', 'Aplikasi tidak ditemukan.');
        }

        return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil diverifikasi.');
    }

    /**
     * Reject an application.
     *
     * @param  \App\Http\Requests\RejectAplikasiRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reject(RejectAplikasiRequest $request, int $id): RedirectResponse
    {
        $aplikasi = $this->aplikasi->reject($id, $request->input('alasan_penolakan'));

        if (!$aplikasi) {
            return back()->with('error', 'Aplikasi tidak ditemukan.');
        }

        return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil ditolak.');
    }

    /**
     * Archive an application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function archive(int $id): RedirectResponse
    {
        $aplikasi = $this->aplikasi->find($id); // Menggunakan find untuk cek status sebelum mengarsipkan

        if (!$aplikasi) {
            return redirect()->back()->with('error', 'Aplikasi tidak ditemukan.');
        }

        // Pastikan aplikasi sudah diterima dan belum diarsipkan sebelum diarsipkan
        if ($aplikasi->status_verifikasi !== StatusTypeEnum::DITERIMA->value || $aplikasi->arsip == 1) {
             return redirect()->back()->with('error', 'Aplikasi hanya bisa diarsipkan jika statusnya diterima dan belum diarsipkan.');
        }

        $this->aplikasi->archive($id);

        return redirect()->route('admin.arsip.index')->with('success', 'Aplikasi berhasil diarsipkan.');
    }

    /**
     * Delete an application.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        $aplikasi = $this->aplikasi->find($id);

        if (!$aplikasi) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        // Hanya izinkan penghapusan jika statusnya ditolak
        if ($aplikasi->status_verifikasi !== StatusTypeEnum::DITOLAK->value) {
            return redirect()->back()->with('error', 'Aplikasi hanya bisa dihapus jika statusnya ditolak.');
        }

        $this->aplikasi->delete($id);

        return redirect()->back()->with('success', 'Data berhasil dihapus.');
    }
}