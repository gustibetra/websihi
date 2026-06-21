<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Clear existing menus
        Menu::truncate();

        // Home
        Menu::create([
            'location' => 'header',
            'title' => 'Home',
            'link_type' => 'route',
            'custom_url' => '/',
            'order' => 1,
            'is_active' => true,
        ]);

        // Profil with children
        $profil = Menu::create([
            'location' => 'header',
            'title' => 'Profil',
            'link_type' => 'group',
            'order' => 2,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $profil->id,
            'location' => 'header',
            'title' => 'Tentang Kami',
            'link_type' => 'route',
            'custom_url' => '/page/tentang-kami',
            'order' => 1,
            'is_active' => true,
        ]);

        Menu::create([
            'parent_id' => $profil->id,
            'location' => 'header',
            'title' => 'Visi & Misi',
            'link_type' => 'route',
            'custom_url' => '/page/visi-misi',
            'order' => 2,
            'is_active' => true,
        ]);

        // Berita
        Menu::create([
            'location' => 'header',
            'title' => 'Berita',
            'link_type' => 'route',
            'custom_url' => '/berita',
            'order' => 3,
            'is_active' => true,
        ]);

        // Agenda
        Menu::create([
            'location' => 'header',
            'title' => 'Agenda',
            'link_type' => 'route',
            'custom_url' => '/agenda',
            'order' => 4,
            'is_active' => true,
        ]);

        // Pengumuman
        Menu::create([
            'location' => 'header',
            'title' => 'Pengumuman',
            'link_type' => 'route',
            'custom_url' => '/pengumuman',
            'order' => 5,
            'is_active' => true,
        ]);

        // Kontak
        Menu::create([
            'location' => 'header',
            'title' => 'Kontak',
            'link_type' => 'route',
            'custom_url' => '/page/contact',
            'order' => 6,
            'is_active' => true,
        ]);
    }
}
