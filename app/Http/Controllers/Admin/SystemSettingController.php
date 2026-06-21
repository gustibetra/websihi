<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SettingService;
use Illuminate\Http\Request;

class SystemSettingController extends Controller
{
    public function __construct(
        private SettingService $settingService
    ) {}

    /**
     * Display system settings page
     */
    public function index()
    {
        $result = $this->settingService->get();

        if ($result['success']) {
            return view('admin.system-settings.index', [
                'setting' => $result['data'],
            ]);
        }

        return view('admin.system-settings.index', [
            'setting' => null,
            'error' => $result['message'] ?? null,
        ]);
    }

    /**
     * Update system settings
     */
    public function update(Request $request)
    {
        $validated = $request->validate([
            'institution_name' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:100',
            'phone' => 'nullable|string|max:50',
            'fax' => 'nullable|string|max:50',
            'website' => 'nullable|string|max:100',
            'google_map' => 'nullable|string',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'favicon' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico|max:512',
            'facebook' => 'nullable|string|max:255',
            'instagram' => 'nullable|string|max:255',
            'twitter' => 'nullable|string|max:255',
            'youtube' => 'nullable|string|max:255',
            'whatsapp' => 'nullable|string|max:50',
            'vision' => 'nullable|string',
            'mission' => 'nullable|string',
            'description' => 'nullable|string',
            // System settings
            'maintenance_mode' => 'nullable|boolean',
            'maintenance_message' => 'nullable|string',
            'max_login_attempts' => 'nullable|integer|min:1|max:10',
            'session_timeout' => 'nullable|integer|min:5|max:480',
            'email_notification' => 'nullable|boolean',
        ]);

        $validated['updated_by'] = auth()->id() ?? 1;

        $result = $this->settingService->update($validated);

        if ($result['success']) {
            return redirect()
                ->route('admin.system-settings.index')
                ->with('success', 'Pengaturan sistem berhasil diupdate');
        }

        return back()->withInput()->with('error', $result['message']);
    }
}
