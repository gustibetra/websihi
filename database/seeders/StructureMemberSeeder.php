<?php

namespace Database\Seeders;

use App\Models\Common;
use App\Models\Member;
use App\Models\StructureMember;
use Illuminate\Database\Seeder;

class StructureMemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Seeding Structure Members data...');

        $period = '2024-2029';

        // Get structures
        $dapil1 = Common::where('table_name', 'structure')
            ->where('key1', 'DP01')
            ->first();
        $dapil2 = Common::where('table_name', 'structure')
            ->where('key1', 'DP02')
            ->first();
        $dapil3 = Common::where('table_name', 'structure')
            ->where('key1', 'DP03')
            ->first();

        $komisiA = Common::where('table_name', 'structure')
            ->where('key1', 'KM01')
            ->first();
        $komisiB = Common::where('table_name', 'structure')
            ->where('key1', 'KM02')
            ->first();
        $komisiC = Common::where('table_name', 'structure')
            ->where('key1', 'KM03')
            ->first();
        $komisiD = Common::where('table_name', 'structure')
            ->where('key1', 'KM04')
            ->first();

        $fraksiDemokrat = Common::where('table_name', 'structure')
            ->where('key1', 'FR01')
            ->first();
        $fraksiPKS = Common::where('table_name', 'structure')
            ->where('key1', 'FR02')
            ->first();
        $fraksiPDIP = Common::where('table_name', 'structure')
            ->where('key1', 'FR03')
            ->first();
        $fraksiPKB = Common::where('table_name', 'structure')
            ->where('key1', 'FR04')
            ->first();
        $fraksiGerindra = Common::where('table_name', 'structure')
            ->where('key1', 'FR05')
            ->first();

        // Get members
        $members = Member::where('period', $period)->get();

        if ($members->isEmpty()) {
            $this->command->warn('No members found. Please run MemberSeeder first.');
            return;
        }

        if (!$dapil1 || !$komisiA || !$fraksiDemokrat) {
            $this->command->warn('Structures not found. Please run CommonSeeder first.');
            return;
        }

        // Assign members to structures
        $assignments = [
            // Member 1: Iwan Setiawan (Demokrat)
            [
                'member' => $members->where('name', 'Iwan Setiawan, S.E.')->first(),
                'structures' => [
                    ['structure' => $dapil1, 'position' => 'Anggota', 'order' => 1],
                    ['structure' => $komisiA, 'position' => 'Anggota', 'order' => 1],
                    ['structure' => $fraksiDemokrat, 'position' => 'Anggota', 'order' => 1],
                ],
            ],
            // Member 2: Deni Ramdhani (PKS)
            [
                'member' => $members->where('name', 'Deni Ramdhani')->first(),
                'structures' => [
                    ['structure' => $dapil1, 'position' => 'Anggota', 'order' => 2],
                    ['structure' => $komisiB, 'position' => 'Anggota', 'order' => 1],
                    ['structure' => $fraksiPKS, 'position' => 'Anggota', 'order' => 1],
                ],
            ],
            // Member 3: Mochamad Dani Daniswara (PDI-P)
            [
                'member' => $members->where('name', 'Mochamad Dani Daniswara, S.Pd.')->first(),
                'structures' => [
                    ['structure' => $dapil2, 'position' => 'Anggota', 'order' => 1],
                    ['structure' => $komisiC, 'position' => 'Ketua', 'order' => 1],
                    ['structure' => $fraksiPDIP, 'position' => 'Anggota', 'order' => 1],
                ],
            ],
            // Member 4: Dede Latif (PKB)
            [
                'member' => $members->where('name', 'Dede Latif')->first(),
                'structures' => [
                    ['structure' => $dapil2, 'position' => 'Anggota', 'order' => 2],
                    ['structure' => $komisiD, 'position' => 'Anggota', 'order' => 1],
                    ['structure' => $fraksiPKB, 'position' => 'Anggota', 'order' => 1],
                ],
            ],
            // Member 5: Siti Nurhaliza (Demokrat)
            [
                'member' => $members->where('name', 'Siti Nurhaliza, S.H.')->first(),
                'structures' => [
                    ['structure' => $dapil3, 'position' => 'Anggota', 'order' => 1],
                    ['structure' => $komisiA, 'position' => 'Wakil Ketua', 'order' => 2],
                    ['structure' => $fraksiDemokrat, 'position' => 'Anggota', 'order' => 2],
                ],
            ],
            // Member 6: Budi Santoso (Gerindra)
            [
                'member' => $members->where('name', 'Budi Santoso, S.E., M.M.')->first(),
                'structures' => [
                    ['structure' => $dapil3, 'position' => 'Anggota', 'order' => 2],
                    ['structure' => $komisiB, 'position' => 'Ketua', 'order' => 2],
                    ['structure' => $fraksiGerindra, 'position' => 'Anggota', 'order' => 1],
                ],
            ],
        ];

        $totalAssignments = 0;

        foreach ($assignments as $assignment) {
            $member = $assignment['member'];
            if (!$member) {
                continue;
            }

            foreach ($assignment['structures'] as $struct) {
                $structure = $struct['structure'];
                if (!$structure) {
                    continue;
                }

                StructureMember::updateOrCreate(
                    [
                        'common_id' => $structure->id,
                        'member_id' => $member->id,
                        'period' => $period,
                    ],
                    [
                        'position' => $struct['position'],
                        'order' => $struct['order'],
                        'is_active' => true,
                    ]
                );
                $totalAssignments++;
            }
        }

        $this->command->info("Structure Members created: {$totalAssignments} assignments");
    }
}
