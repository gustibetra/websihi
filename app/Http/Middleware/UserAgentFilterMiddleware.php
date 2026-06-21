<?php

namespace App\Http\Middleware;

use App\Services\SecurityLogService;
use App\Services\SecuritySettingService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAgentFilterMiddleware
{
    /**
     * Blocked user agents
     */
    private array $blockedAgents = [
        // API Testing Tools
        'postman',
        'insomnia',
        'httpie',
        'restclient',
        'paw',
        'advanced rest client',
        
        // Command Line Tools
        'curl',
        'wget',
        'lynx',
        'links',
        
        // Programming Languages & Libraries
        'python-requests',
        'python-urllib',
        'python-httpx',
        'python',
        'go-http-client',
        'java/',
        'apache-httpclient',
        'okhttp',
        'node-fetch',
        'axios',
        'got/',
        'request/',
        'superagent',
        'ruby',
        'perl',
        'php/',
        'libwww-perl',
        
        // Scrapers & Crawlers
        'scrapy',
        'beautifulsoup',
        'mechanize',
        'selenium',
        'phantomjs',
        'headless',
        'puppeteer',
        'playwright',
        'jsdom',
        
        // Download Managers
        'download',
        'downloader',
        'getright',
        'flashget',
        'internet download manager',
        'idm',
        
        // Bots & Automated Tools
        'bot',
        'crawler',
        'spider',
        'scraper',
        'scan',
        'check',
        'monitor',
        'test',
        'benchmark',
        'load',
        'stress',
        
        // Security Testing Tools
        'nikto',
        'nmap',
        'sqlmap',
        'metasploit',
        'burp',
        'zap',
        'acunetix',
        'nessus',
        'openvas',
        'w3af',
        'skipfish',
        'wpscan',
        'dirbuster',
        'gobuster',
        'ffuf',
        'wfuzz',
        'hydra',
        'masscan',
        
        // Other Tools
        'fiddler',
        'charles',
        'mitmproxy',
        'wireshark',
        'teleport',
        'webcopier',
        'httrack',
        'webzip',
        'offline explorer',
    ];

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
        // Check if user agent filtering is enabled
        if (!$this->securitySettingService->isEnabled('user_agent_filtering_enabled')) {
            return $next($request);
        }

        $userAgent = $request->userAgent() ?? '';
        $ipAddress = $request->ip();

        // Allow localhost, private IPs, logged-in users, or local environment
        if (app()->environment('local') || auth()->check() || $this->isLocalOrPrivateIp($ipAddress)) {
            return $next($request);
        }

        // Check if user agent is blocked
        $isBlocked = $this->isBlockedUserAgent($userAgent);

        if ($isBlocked) {
            // Generate unique incident ID
            $incidentId = strtoupper(substr(md5($ipAddress . $userAgent . time()), 0, 12));
            
            // Log blocked request
            $this->securityLogService->logBlocked(
                $ipAddress,
                $userAgent,
                'user_agent_blocked',
                [
                    'reason' => 'Blocked user agent detected',
                    'url' => $request->fullUrl(),
                    'incident_id' => $incidentId,
                ]
            );

            // Check if request expects JSON or is from API client
            if ($request->expectsJson() || $request->is('api/*') || $this->isApiClient($userAgent)) {
                // Return JSON response for API clients
                return response()->json([
                    'success' => false,
                    'message' => 'ACCESS DENIED - Unauthorized access attempt detected and logged',
                    'warning' => 'This website is protected by Indonesian law and international cybersecurity regulations',
                    'your_information' => [
                        'ip_address' => $ipAddress,
                        'user_agent' => $userAgent,
                        'timestamp' => now()->format('Y-m-d H:i:s T'),
                        'request_url' => $request->fullUrl(),
                        'incident_id' => $incidentId,
                    ],
                    'legal_notice' => [
                        'warning' => 'Unauthorized access attempts, data scraping, or any malicious activities are strictly prohibited and may result in legal action.',
                    ],
                    'note' => 'All access attempts are monitored and logged for security purposes',
                ], 403);
            }

            // Return HTML page for browser requests
            return response()->view('security.blocked', [
                'ipAddress' => $ipAddress,
                'userAgent' => $userAgent,
                'timestamp' => now()->format('Y-m-d H:i:s T'),
                'requestUrl' => $request->fullUrl(),
                'incidentId' => $incidentId,
            ], 403);
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
     * Check if user agent is blocked
     */
    private function isBlockedUserAgent(string $userAgent): bool
    {
        $userAgentLower = strtolower($userAgent);

        foreach ($this->blockedAgents as $blockedAgent) {
            if (str_contains($userAgentLower, $blockedAgent)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Check if request is from API client (not browser)
     */
    private function isApiClient(string $userAgent): bool
    {
        $userAgentLower = strtolower($userAgent);
        
        // List of API client indicators
        $apiClientIndicators = [
            'postman',
            'curl',
            'wget',
            'python',
            'java',
            'go-http',
            'okhttp',
            'httpie',
            'insomnia',
            'restclient',
            'apache-httpclient',
        ];

        foreach ($apiClientIndicators as $indicator) {
            if (str_contains($userAgentLower, $indicator)) {
                return true;
            }
        }

        return false;
    }
}
