<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\QueryEncryption;
use Symfony\Component\HttpFoundation\Response;

class DecryptQueryParameters
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Only decrypt for frontend routes (not admin)
        if (!$request->is('admin/*') && $request->query()) {
            $decryptedParams = QueryEncryption::decryptParams($request->query());
            $request->merge($decryptedParams);
        }

        return $next($request);
    }
}
