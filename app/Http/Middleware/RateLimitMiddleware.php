<?php

namespace App\Http\Middleware;

use App\Services\SecurityLogService;
use App\Services\SecuritySettingService;
use App\Models\SecuritySetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\RateLimiter;

class RateLimitMiddleware
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
        // Check if rate limiting is enabled
        if (!$this->securitySettingService->isEnabled('rate_limiting_enabled')) {
            return $next($request);
        }

        $ipAddress = $request->ip();
        $userAgent = $request->userAgent() ?? '';
        
        // Allow localhost, private IPs, logged-in users, or local environment
        if (app()->environment('local') || auth()->check() || $this->isLocalOrPrivateIp($ipAddress)) {
            return $next($request);
        }

        // Define rate limiter key based on IP
        $key = 'rate_limit:' . $ipAddress;
        
        // Get max requests per hour from database, default to 100
        $maxAttempts = (int) SecuritySetting::getValue('rate_limit_per_hour', 100);

        // Check if rate limit has been exceeded
        if (RateLimiter::tooManyAttempts($key, $maxAttempts)) {
            // Generate unique incident ID
            $incidentId = strtoupper(substr(md5($ipAddress . $userAgent . time()), 0, 12));
            
            // Log blocked request (if logging is enabled)
            $this->securityLogService->logBlocked(
                $ipAddress,
                $userAgent,
                'rate_limit_blocked',
                [
                    'reason' => 'Rate limit exceeded (' . $maxAttempts . ' requests/hour)',
                    'url' => $request->fullUrl(),
                    'incident_id' => $incidentId,
                ]
            );

            // Check if request expects JSON or is from API
            if ($request->expectsJson() || $request->is('api/*') || $this->isApiClient($userAgent)) {
                return response()->json([
                    'success' => false,
                    'message' => 'ACCESS DENIED - Rate limit exceeded. Too many requests.',
                    'your_information' => [
                        'ip_address' => $ipAddress,
                        'user_agent' => $userAgent,
                        'timestamp' => now()->format('Y-m-d H:i:s T'),
                        'request_url' => $request->fullUrl(),
                        'incident_id' => $incidentId,
                    ],
                    'note' => 'Please try again in an hour.'
                ], 429);
            }

            // Return custom HTML view for browser requests (using 429 status code)
            return response()->view('security.blocked', [
                'ipAddress' => $ipAddress,
                'userAgent' => $userAgent,
                'timestamp' => now()->format('Y-m-d H:i:s T'),
                'requestUrl' => $request->fullUrl(),
                'incidentId' => $incidentId,
            ], 429);
        }

        // Record a request attempt/hit (1 hour decay = 3600 seconds)
        RateLimiter::hit($key, 3600);

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
     * Check if request is from API client
     */
    private function isApiClient(string $userAgent): bool
    {
        $userAgentLower = strtolower($userAgent);
        $apiClientIndicators = [
            'postman', 'curl', 'wget', 'python', 'java', 'go-http', 'okhttp', 'httpie', 'insomnia', 'restclient', 'apache-httpclient'
        ];

        foreach ($apiClientIndicators as $indicator) {
            if (str_contains($userAgentLower, $indicator)) {
                return true;
            }
        }

        return false;
    }
}
