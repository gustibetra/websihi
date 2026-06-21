<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    /**
     * Display the settings page.
     */
    public function index(Request $request): View
    {
        // Debug: pastikan controller dipanggil
        // dd('Controller reached');
        
        return view('admin.settings.index');
    }
}
