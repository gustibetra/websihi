<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Common;
use App\Models\Teacher;
use App\Models\News;
use App\Models\Announcement;
use App\Models\Gallery;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin SMK.
     */
    public function index()
    {
        $totalGuru          = Teacher::guru()->count();
        $totalTendik        = Teacher::tendik()->count();
        $totalNews          = News::count();
        $totalAnnouncements = Announcement::count();
        $totalGalleries     = Gallery::count();
        $totalJurusan       = Common::jurusan()->aktif()->count();

        return view('admin.dashboard', compact(
            'totalGuru',
            'totalTendik',
            'totalNews',
            'totalAnnouncements',
            'totalGalleries',
            'totalJurusan'
        ));
    }
}
