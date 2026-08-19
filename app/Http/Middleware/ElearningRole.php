<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ElearningRole
{
    /**
     * Melindungi halaman e-learning berdasarkan role user.
     *
     * Contoh pemakaian di route:
     *   ->middleware(\App\Http\Middleware\ElearningRole::class . ':staff')
     *   ->middleware(\App\Http\Middleware\ElearningRole::class . ':mahasiswa')
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        $user = auth('elearning')->user();

        // Jika belum login atau role tidak sesuai → tolak akses (403)
        if (!$user || $user->role !== $role) {
            abort(403, 'Anda tidak memiliki izin untuk mengakses halaman ini.');
        }

        return $next($request);
    }
}