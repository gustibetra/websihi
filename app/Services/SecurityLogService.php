<?php

namespace App\Services;

use App\Repositories\SecurityLogRepository;

class SecurityLogService extends BaseService
{
    public function __construct(
        private SecurityLogRepository $repository
    ) {}

    /**
     * Create security log
     */
    public function create(array $data)
    {
        try {
            $log = $this->repository->create($data);
            return $this->success($log);
        } catch (\Exception $e) {
            return $this->error('Gagal membuat log keamanan', $e->getMessage());
        }
    }

    /**
     * Log blocked request
     */
    public function logBlocked(string $ipAddress, string $userAgent, string $action, array $details = [])
    {
        // Check if security logging is enabled
        $securitySettingService = app(\App\Services\SecuritySettingService::class);
        if (!$securitySettingService->isEnabled('security_logging_enabled')) {
            return $this->success(null, 'Security logging is disabled');
        }

        return $this->create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'action' => $action,
            'status' => 'blocked',
            'details' => $details,
        ]);
    }

    /**
     * Log suspicious request
     */
    public function logSuspicious(string $ipAddress, string $userAgent, string $action, array $details = [])
    {
        // Check if security logging is enabled
        $securitySettingService = app(\App\Services\SecuritySettingService::class);
        if (!$securitySettingService->isEnabled('security_logging_enabled')) {
            return $this->success(null, 'Security logging is disabled');
        }

        return $this->create([
            'ip_address' => $ipAddress,
            'user_agent' => $userAgent,
            'action' => $action,
            'status' => 'suspicious',
            'details' => $details,
        ]);
    }

    /**
     * Get blocked logs
     */
    public function getBlocked($perPage = 50)
    {
        try {
            $logs = $this->repository->getBlocked($perPage);
            return $this->success($logs);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil log keamanan', $e->getMessage());
        }
    }
}

