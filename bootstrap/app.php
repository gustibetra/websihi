<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Redirect to login if not authenticated
        $middleware->redirectGuestsTo('/login');
        
        // Security Headers - Apply to all requests
        $middleware->append(\App\Http\Middleware\SecurityHeadersMiddleware::class);
        
        // User Agent Filter - Apply to all requests (block Postman, cURL, etc)
        $middleware->append(\App\Http\Middleware\UserAgentFilterMiddleware::class);
        
        // IP Filter - Apply to all requests (can be enabled/disabled via admin panel)
        $middleware->append(\App\Http\Middleware\IpFilterMiddleware::class);
        
        // Rate Limiting - Apply to all requests (can be enabled/disabled via admin panel)
        $middleware->append(\App\Http\Middleware\RateLimitMiddleware::class);
        
        // Decrypt Query Parameters - Apply to frontend routes only
        $middleware->append(\App\Http\Middleware\DecryptQueryParameters::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Custom error pages
        $exceptions->respond(function ($response, $exception, $request) {
            // Only apply custom error pages for web requests (not API)
            if (!$request->is('api/*') && !$request->expectsJson()) {
                $statusCode = $response->getStatusCode();
                
                // Map of error codes to view files
                $errorViews = [
                    401 => 'errors.401',
                    403 => 'errors.403',
                    404 => 'errors.404',
                    419 => 'errors.419',
                    429 => 'errors.429',
                    500 => 'errors.500',
                    503 => 'errors.503',
                ];
                
                // Check if we have a custom view for this error code
                if (isset($errorViews[$statusCode]) && view()->exists($errorViews[$statusCode])) {
                    return response()->view($errorViews[$statusCode], [
                        'exception' => $exception
                    ], $statusCode);
                }
                
                // For other error codes, use generic error page
                if ($statusCode >= 400) {
                    return response()->view('errors.generic', [
                        'code' => $statusCode,
                        'title' => 'Terjadi Kesalahan',
                        'message' => $exception->getMessage() ?: 'Maaf, terjadi kesalahan yang tidak terduga.',
                        'exception' => $exception
                    ], $statusCode);
                }
            }
            
            return $response;
        });
    })->create();
