<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\User;
use App\Services\CommonIdGeneratorService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;

class MitraSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get creator
        $user = User::first();
        $userId = $user ? $user->id : 1;

        $idGen = app(CommonIdGeneratorService::class);

        $this->command->info('Deleting existing mitra_industri records from common table...');
        
        // Delete existing mitra_industri records in the common table
        DB::table('common')->where('table_name', 'mitra_industri')->delete();

        // Ensure directory exists
        Storage::disk('public')->makeDirectory('mitra_industri');

        // Copy dummy logos for premium visuals
        $logos = [];
        for ($i = 1; $i <= 7; $i++) {
            $src = public_path("assets/site/images/brand/partner-{$i}.webp");
            $dest = "mitra_industri/partner-{$i}.webp";
            if (File::exists($src)) {
                File::copy($src, storage_path('app/public/' . $dest));
                $logos[$i] = $dest;
            } else {
                // Try brand png files as fallback
                $brandSrc = public_path("assets/site/images/brand/brand-0{$i}.png");
                $brandDest = "mitra_industri/brand-0{$i}.png";
                if (File::exists($brandSrc)) {
                    File::copy($brandSrc, storage_path('app/public/' . $brandDest));
                    $logos[$i] = $brandDest;
                } else {
                    $logos[$i] = null;
                }
            }
        }

        // Fetch any existing jenis_kerjasama common records if available
        $jenisKerjasama = DB::table('common')->where('table_name', 'jenis_kerjasama')->pluck('key1')->toArray();

        $mitras = [
            // 7 Partners with Logos
            [
                'name' => 'PT. Telkom Indonesia Tbk',
                'web' => 'https://telkom.co.id',
                'logo' => $logos[1],
                'bidang' => 'Telekomunikasi & Jaringan',
                'kontak' => '021-5001111',
            ],
            [
                'name' => 'PT. Astra International Tbk',
                'web' => 'https://astra.co.id',
                'logo' => $logos[2],
                'bidang' => 'Otomotif & Manufaktur',
                'kontak' => '021-6522555',
            ],
            [
                'name' => 'PT. Toyota Motor Manufacturing Indonesia',
                'web' => 'https://toyota.co.id',
                'logo' => $logos[3],
                'bidang' => 'Manufaktur Otomotif',
                'kontak' => '021-8836000',
            ],
            [
                'name' => 'PT. Bank Central Asia Tbk (BCA)',
                'web' => 'https://bca.co.id',
                'logo' => $logos[4],
                'bidang' => 'Perbankan & Layanan Keuangan',
                'kontak' => '021-23588000',
            ],
            [
                'name' => 'Shopee Indonesia',
                'web' => 'https://shopee.co.id',
                'logo' => $logos[5],
                'bidang' => 'E-Commerce & Teknologi',
                'kontak' => '021-80600900',
            ],
            [
                'name' => 'PT. GoTo Gojek Tokopedia Tbk',
                'web' => 'https://gotocompany.com',
                'logo' => $logos[6],
                'bidang' => 'Teknologi & Layanan Digital',
                'kontak' => '021-50849000',
            ],
            [
                'name' => 'PT. Indomarco Prismatama (Indomaret)',
                'web' => 'https://indomaret.co.id',
                'logo' => $logos[7],
                'bidang' => 'Retail & Logistik',
                'kontak' => '021-7590999',
            ],
            // 3 Partners with NO Logos (Fallback default icon)
            [
                'name' => 'CV. Sinergi Solusi Informatika',
                'web' => 'https://example.com/sinergi',
                'logo' => null,
                'bidang' => 'Software House & Konsultan IT',
                'kontak' => '022-1234567',
            ],
            [
                'name' => 'PT. Kereta Api Indonesia (Persero)',
                'web' => 'https://kai.id',
                'logo' => null,
                'bidang' => 'Transportasi & Logistik BUMN',
                'kontak' => '121',
            ],
            [
                'name' => 'CV. Media Kreatif Nusantara',
                'web' => 'https://example.com/mediakreatif',
                'logo' => null,
                'bidang' => 'Desain & Multimedia',
                'kontak' => '022-7654321',
            ],
        ];

        $order = 1;
        foreach ($mitras as $m) {
            // Associate random jenis kerjasama if available
            $data6Val = '';
            if (!empty($jenisKerjasama)) {
                $randKeys = (array) array_rand($jenisKerjasama, min(2, count($jenisKerjasama)));
                $associated = [];
                foreach ($randKeys as $k) {
                    $associated[] = $jenisKerjasama[$k];
                }
                $data6Val = implode(';', $associated);
            }

            DB::table('common')->insert([
                'table_name' => 'mitra_industri',
                'key1'       => $idGen->generateId('mitra_industri'),
                'data1'      => $m['name'],
                'data2'      => $m['web'],
                'data3'      => $m['logo'],
                'data4'      => $m['bidang'],
                'data5'      => $m['kontak'],
                'data6'      => $data6Val,
                'text1'      => 'Kemitraan strategis dalam penyelarasan kurikulum sekolah, penyediaan tempat praktek kerja lapangan (PKL) / magang industri bagi siswa, guru tamu, serta program rekrutmen alumni secara langsung.',
                'order'      => $order++,
                'is_active'  => true,
                'created_by' => $userId,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        $this->command->info('Successfully seeded exactly 10 Mitra DU/DI partners!');
    }
}
