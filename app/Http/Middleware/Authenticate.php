<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;

class Authenticate extends Middleware
{
    /**
     * Tentukan kemana user diarahkan jika belum login.
     */
    protected function redirectTo($request): ?string
    {
        if ($request->expectsJson()) {
            return null; // API request → tidak redirect
        }

        // ✅ Jika user akses area /elearning/* tanpa sesi e-learning
        // → arahkan ke halaman login E-Learning
        if ($request->is('elearning*')) {
            return route('elearning.login');
        }

        // Default → halaman login admin
        return route('login');
    }
}