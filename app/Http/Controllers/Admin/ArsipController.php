<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use App\Contracts\Interfaces\AplikasiInterface;
use Carbon\Carbon;

class ArsipController extends Controller
{
    private AplikasiInterface $aplikasi;

    public function __construct(AplikasiInterface $aplikasi)
    {
        $this->aplikasi = $aplikasi;
    }

    /**
     * Display a listing of archived applications with search filters.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        $perPage = $request->input('per_page', 10);
        $arsip = $this->aplikasi->getArchivedPaginated($request, $perPage);

        return view('admin.arsip.index', compact('arsip'));
    }

    /**
     * Display the details of a specific archived application.
     *
     * @param int $id
     * @return \Illuminate\View\View|\Illuminate\Http\RedirectResponse
     */
    public function show(int $id): View|RedirectResponse
    {
        $aplikasi = $this->aplikasi->findArchived($id);

        if (!$aplikasi) {
            return redirect()->route('admin.arsip.index')->with('error', 'Data arsip tidak ditemukan.');
        }

        return view('admin.arsip.detail', compact('aplikasi'));
    }

    /**
     * Unarchive an application, moving it back to the history.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function unarchive(int $id): RedirectResponse
    {
        $aplikasi = $this->aplikasi->find($id); 

        if (!$aplikasi) {
            return redirect()->back()->with('error', 'Aplikasi tidak ditemukan.');
        }

        if ($aplikasi->arsip == 0) {
            return redirect()->back()->with('error', 'Aplikasi ini tidak diarsipkan.');
        }

        $this->aplikasi->unarchive($id);

        return redirect()->route('admin.riwayat.index')->with('success', 'Aplikasi berhasil dikembalikan dari arsip.');
    }

    /**
     * Delete an archived application permanently.
     * This method is renamed from deleteFromArchive to destroy to follow Laravel conventions.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id): RedirectResponse
    {
        try {
            $deleted = $this->aplikasi->deleteArchived($id);

            if (!$deleted) {
                return redirect()->route('admin.arsip.index')->with('error', 'Gagal menghapus aplikasi dari arsip. Data mungkin tidak ditemukan.');
            }

            return redirect()->route('admin.arsip.index')->with('success', 'Aplikasi berhasil dihapus permanen dari arsip.');
        } catch (\Exception $e) {
            return redirect()->route('admin.arsip.index')->with('error', 'Terjadi kesalahan saat menghapus aplikasi: ' . $e->getMessage());
        }
    }
}