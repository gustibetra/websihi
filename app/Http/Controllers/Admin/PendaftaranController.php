<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    // Daftar pendaftar + filter
    public function index(Request $request)
    {
        $query = Registration::query();

        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('asal_sekolah', 'like', "%{$s}%")
                  ->orWhere('email', 'like', "%{$s}%")
                  ->orWhere('no_whatsapp', 'like', "%{$s}%")
                  ->orWhere('program', 'like', "%{$s}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $pendaftar = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $stats = [
            'total'    => Registration::count(),
            'baru'     => Registration::where('status', 'Baru')->count(),
            'diterima' => Registration::where('status', 'Diterima')->count(),
            'ditolak'  => Registration::where('status', 'Ditolak')->count(),
        ];

        return view('admin.pendaftaran.index', compact('pendaftar', 'stats'));
    }

    // Detail pendaftar
    public function show($id)
    {
        $p = Registration::findOrFail($id);
        return view('admin.pendaftaran.show', compact('p'));
    }

    // Ubah status (Baru / Diterima / Ditolak)
    public function updateStatus(Request $request, $id)
    {
        $request->validate(['status' => 'required|in:Baru,Diterima,Ditolak']);
        $p = Registration::findOrFail($id);
        $p->status = $request->status;
        $p->save();
        return redirect()->back()->with('success', 'Status pendaftar berhasil diperbarui.');
    }

    // Hapus data
    public function destroy($id)
    {
        Registration::findOrFail($id)->delete();
        return redirect()->route('admin.pendaftaran.index')->with('success', 'Data pendaftar berhasil dihapus.');
    }

    // Download Excel (tanpa package tambahan)
    public function export(Request $request)
    {
        $query = Registration::query();

        if ($request->filled('status')) $query->where('status', $request->status);
        if ($request->filled('search')) {
            $s = $request->search;
            $query->where(function ($q) use ($s) {
                $q->where('nama_lengkap', 'like', "%{$s}%")
                  ->orWhere('asal_sekolah', 'like', "%{$s}%")
                  ->orWhere('program', 'like', "%{$s}%");
            });
        }

        $rows = $query->orderBy('created_at', 'desc')->get();
        $filename = 'Data-Pendaftar-' . date('Ymd-His') . '.xls';

        $html = view('admin.pendaftaran.export', compact('rows'))->render();

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}