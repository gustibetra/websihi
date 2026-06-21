<?php

namespace App\View\Composers;

use App\Models\Setting;
use App\Models\Menu;
use Illuminate\View\View;

class SettingsComposer
{
    /**
     * Bind data to the view.
     */
    public function compose(View $view): void
    {
        // Get settings as object (for easy access)
        $settings = Setting::first();
        
        // Get header menu with active children only
        $headerMenus = Menu::with(['page'])
            ->where('location', 'header')
            ->where('is_active', 1)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get()
            ->map(function ($menu) {
                return $this->loadActiveChildren($menu);
            });
        
        // Get footer menu with active children only
        $footerMenus = Menu::with(['page'])
            ->where('location', 'footer')
            ->where('is_active', 1)
            ->whereNull('parent_id')
            ->orderBy('order')
            ->get()
            ->map(function ($menu) {
                return $this->loadActiveChildren($menu);
            });
        
        // Get PPDB configuration from common table
        $ppdbConfig = \App\Models\Common::where('table_name', 'home_section')
            ->where('key1', 'ppdb')
            ->first();

        // Get SEO configuration from common table
        $seoConfig = \App\Models\Common::where('table_name', 'seo_setting')
            ->where('key1', 'seo_config')
            ->first();
        
        $view->with([
            'settings' => $settings,
            'headerMenus' => $headerMenus,
            'footerMenus' => $footerMenus,
            'ppdbConfig' => $ppdbConfig,
            'seoConfig' => $seoConfig,
        ]);
    }
    
    /**
     * Load active children recursively
     */
    private function loadActiveChildren($menu)
    {
        $menu->load(['page', 'children' => function ($query) {
            $query->where('is_active', 1)->orderBy('order')->with(['page']);
        }]);
        
        if ($menu->children->count() > 0) {
            $menu->children->each(function ($child) {
                $this->loadActiveChildren($child);
            });
        }
        
        return $menu;
    }
}
