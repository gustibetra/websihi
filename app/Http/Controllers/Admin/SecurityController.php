<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\SecurityLogService;
use App\Services\SecuritySettingService;
use Illuminate\Http\Request;

class SecurityController extends Controller
{
    public function __construct(
        private SecurityLogService $logService,
        private SecuritySettingService $settingService
    ) {}

    public function index(Request $request)
    {
        // Get security settings
        $ipFilteringEnabled = $this->settingService->isEnabled('ip_filtering_enabled');

        // Get logs
        $logsResult = $this->logService->getBlocked(50);
        $logs = $logsResult['success'] ? $logsResult['data'] : [];

        return view('admin.security.index', [
            'ipFilteringEnabled' => $ipFilteringEnabled,
            'logs' => $logs,
        ]);
    }

    public function updateSettings(Request $request)
    {
        $validated = $request->validate([
            'ip_filtering_enabled' => 'nullable|boolean',
        ]);

        $result = $this->settingService->setIpFiltering(
            $validated['ip_filtering_enabled'] ?? false
        );

        if ($result['success']) {
            return redirect()
                ->route('admin.security.index')
                ->with('success', $result['message']);
        }

        return back()->with('error', $result['message']);
    }

    public function logs(Request $request)
    {
        $perPage = $request->get('per_page', 50);

        $result = $this->logService->getBlocked($perPage);

        if ($result['success']) {
            return view('admin.security.logs', [
                'logs' => $result['data'],
            ]);
        }

        return back()->with('error', $result['message']);
    }
}
