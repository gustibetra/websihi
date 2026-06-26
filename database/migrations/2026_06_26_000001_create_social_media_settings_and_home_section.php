<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        $userId = DB::table('users')->value('id') ?? 1;

        // 1. Insert or update social_media section in home_sections list
        DB::table('common')->updateOrInsert(
            [
                'table_name' => 'home_section',
                'key1' => 'social_media',
            ],
            [
                'data1' => 'Media Sosial', // Section Title
                'data2' => 'Koneksi Sosial', // Section Subtitle
                'text1' => 'Ikuti kanal media sosial resmi kami untuk mendapatkan informasi terbaru secara real-time.', // Section Description
                'is_active' => true,
                'order' => 18,
                'created_by' => $userId,
                'updated_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );

        // 2. Initialize social_media_config settings row
        DB::table('common')->updateOrInsert(
            [
                'table_name' => 'social_media_setting',
                'key1' => 'social_media_config',
            ],
            [
                // Instagram settings
                'data1' => 'https://instagram.com', // instagram_url
                'data2' => '0', // show_instagram (0 = false, 1 = true)
                'text1' => null, // instagram_embed

                // YouTube settings
                'data3' => 'https://youtube.com', // youtube_url
                'data4' => '0', // show_youtube
                'text2' => null, // youtube_embed

                // Facebook settings
                'data5' => 'https://facebook.com', // facebook_url
                'data6' => '0', // show_facebook
                'text3' => null, // facebook_embed

                // TikTok settings
                'data7' => 'https://tiktok.com', // tiktok_url
                'data8' => '0', // show_tiktok
                'text4' => null, // tiktok_embed

                'is_active' => true,
                'created_by' => $userId,
                'updated_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::table('common')
            ->where('table_name', 'home_section')
            ->where('key1', 'social_media')
            ->delete();

        DB::table('common')
            ->where('table_name', 'social_media_setting')
            ->where('key1', 'social_media_config')
            ->delete();
    }
};
