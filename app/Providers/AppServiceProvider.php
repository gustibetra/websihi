<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Share settings and menus to all site views, layouts, and page templates
        view()->composer([
            'partials.site.*',
            'layouts.site',
            'site.*'
        ], \App\View\Composers\SettingsComposer::class);
    }
}
