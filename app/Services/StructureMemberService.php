<?php

namespace App\Services;

use App\Repositories\StructureMemberRepository;

class StructureMemberService extends BaseService
{
    public function __construct(
        private StructureMemberRepository $repository
    ) {}

    /**
     * Get members by structure and period
     */
    public function getMembers($structureId, $period)
    {
        try {
            $members = $this->repository->getByStructureAndPeriod($structureId, $period);
            return $this->success($members);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil data anggota', $e->getMessage());
        }
    }

    /**
     * Add member to structure
     */
    public function addMember(array $data)
    {
        try {
            // Check if member already exists
            if ($this->repository->exists($data['common_id'], $data['member_id'], $data['period'])) {
                return $this->error('Anggota sudah terdaftar di struktur ini untuk period yang sama');
            }

            // Get max order and increment
            $maxOrder = $this->repository->getMaxOrder($data['common_id'], $data['period']);
            $data['order'] = $maxOrder + 1;
            $data['is_active'] = true;

            $member = $this->repository->create($data);
            return $this->success($member, 'Anggota berhasil ditambahkan');
        } catch (\Exception $e) {
            return $this->error('Gagal menambahkan anggota', $e->getMessage());
        }
    }

    /**
     * Bulk add members
     */
    public function bulkAddMembers($structureId, $period, array $memberIds, $position)
    {
        try {
            $added = 0;
            $skipped = 0;
            $maxOrder = $this->repository->getMaxOrder($structureId, $period);

            foreach ($memberIds as $memberId) {
                // Check if already exists
                if ($this->repository->exists($structureId, $memberId, $period)) {
                    $skipped++;
                    continue;
                }

                $maxOrder++;
                $this->repository->create([
                    'common_id' => $structureId,
                    'member_id' => $memberId,
                    'period' => $period,
                    'position' => $position,
                    'order' => $maxOrder,
                    'is_active' => true,
                ]);
                $added++;
            }

            $message = "Berhasil menambahkan {$added} anggota";
            if ($skipped > 0) {
                $message .= ", {$skipped} anggota sudah terdaftar";
            }

            return $this->success(null, $message);
        } catch (\Exception $e) {
            return $this->error('Gagal menambahkan anggota', $e->getMessage());
        }
    }

    /**
     * Update member position
     */
    public function updatePosition($id, $position)
    {
        try {
            $member = $this->repository->update($id, ['position' => $position]);
            return $this->success($member, 'Position berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate position', $e->getMessage());
        }
    }

    /**
     * Update members order
     */
    public function updateOrders(array $orders)
    {
        try {
            $this->repository->updateOrders($orders);
            return $this->success(null, 'Urutan berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate urutan', $e->getMessage());
        }
    }

    /**
     * Remove member from structure
     */
    public function removeMember($id)
    {
        try {
            $this->repository->deleteByStructureMemberId($id);
            return $this->success(null, 'Anggota berhasil dihapus dari struktur');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus anggota', $e->getMessage());
        }
    }
}

