<?php

namespace App\Http\Middleware;

use App\Services\SecurityLogService;
use App\Services\SecuritySettingService;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Symfony\Component\HttpFoundation\Response;

class IpFilterMiddleware
{
    public function __construct(
        private SecuritySettingService $securitySettingService,
        private SecurityLogService $securityLogService
    ) {}

    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if IP filtering is enabled
        if (!$this->securitySettingService->isEnabled('ip_filtering_enabled')) {
            return $next($request);
        }

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent();

        // Allow localhost, private IPs, logged-in users, or local environment
        if (app()->environment('local') || auth()->check() || $this->isLocalOrPrivateIp($ipAddress)) {
            return $next($request);
        }

        // Check if IP is from Indonesia
        $isIndonesia = $this->checkIpLocation($ipAddress);

        if (!$isIndonesia) {
            // Log blocked request
            $this->securityLogService->logBlocked(
                $ipAddress,
                $userAgent,
                'ip_filter_blocked',
                [
                    'reason' => 'IP not from Indonesia',
                    'url' => $request->fullUrl(),
                ]
            );

            // Redirect to Google.com (no information disclosure)
            return redirect()->away('https://www.google.com');
        }

        return $next($request);
    }

    /**
     * Check if IP is local or private
     */
    private function isLocalOrPrivateIp(string $ip): bool
    {
        return filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE) === false
            || $ip === '127.0.0.1'
            || $ip === '::1'
            || str_starts_with($ip, '192.168.')
            || str_starts_with($ip, '10.')
            || str_starts_with($ip, '172.');
    }

    /**
     * Check IP location using free geolocation API
     */
    private function checkIpLocation(string $ip): bool
    {
        // Cache key
        $cacheKey = "ip_location_{$ip}";

        // Check cache first (24 hours)
        return Cache::remember($cacheKey, 86400, function () use ($ip) {
            try {
                // Using ip-api.com (free, no API key required)
                $response = Http::timeout(5)->get("http://ip-api.com/json/{$ip}", [
                    'fields' => 'status,countryCode',
                ]);

                if ($response->successful()) {
                    $data = $response->json();
                    
                    if ($data['status'] === 'success' && $data['countryCode'] === 'ID') {
                        return true;
                    }
                }

                // Fallback: ipinfo.io (free tier available)
                $response = Http::timeout(5)->get("https://ipinfo.io/{$ip}/country");

                if ($response->successful()) {
                    $countryCode = trim($response->body());
                    return $countryCode === 'ID';
                }

                // If API fails, allow the request (fail open)
                return true;
            } catch (\Exception $e) {
                // If API fails, allow the request (fail open)
                \Log::warning("IP geolocation check failed for IP: {$ip}", [
                    'error' => $e->getMessage(),
                ]);
                return true;
            }
        });
    }
}
