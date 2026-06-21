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
         // Find a valid user id for audits
         $userId = DB::table('users')->value('id') ?? 1;
 
         // Insert or update school_life section
         DB::table('common')->updateOrInsert(
             [
                 'table_name' => 'home_section',
                 'key1' => 'school_life',
             ],
             [
                 'data1' => 'School Life',
                 'data2' => null, // Video thumbnail path, will use fallback default image
                 'data3' => 'https://www.youtube.com/watch?v=nA1Aqp0sPQo', // Default video URL
                 'data4' => 'School Life', // Subtitle
                 'data5' => 'Kehidupan Sekolah', // Title
                 'data6' => '99%', // Floating Badge Number
                 'data7' => 'Puas', // Floating Badge Subtitle
                 'data8' => 'Pembelajaran Fleksibel', // Feature 1 Title
                 'data9' => 'feather-heart', // Feature 1 Icon
                 'data10' => 'Belajar di Mana Saja', // Feature 2 Title
                 'data11' => 'feather-book', // Feature 2 Icon
                 'data12' => 'Berbasis Praktik', // Feature 3 Title
                 'data13' => 'feather-award', // Feature 3 Icon
                 'text1' => 'Fakta yang terbukti bahwa siswa dapat belajar dengan nyaman menggunakan kurikulum fleksibel kami.', // Feature 1 Desc
                 'text2' => 'Akses materi pembelajaran secara online kapan saja dan di mana saja tanpa hambatan.', // Feature 2 Desc
                 'text3' => 'Kurikulum dirancang untuk meningkatkan keterampilan nyata yang siap digunakan di dunia kerja.', // Feature 3 Desc
                 'is_active' => true,
                 'order' => 16,
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
             ->where('key1', 'school_life')
             ->delete();
     }
 };
