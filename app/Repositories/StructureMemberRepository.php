<?php

namespace App\Repositories;

use App\Models\StructureMember;

class StructureMemberRepository extends BaseRepository
{
    public function __construct(StructureMember $model)
    {
        parent::__construct($model);
    }

    /**
     * Get members by structure ID and period
     */
    public function getByStructureAndPeriod($structureId, $period)
    {
        return $this->model
            ->where('common_id', $structureId)
            ->where('period', $period)
            ->where('is_active', true)
            ->with('member')
            ->orderBy('order', 'asc')
            ->get();
    }

    /**
     * Check if member already exists in structure for period
     */
    public function exists($structureId, $memberId, $period)
    {
        return $this->model
            ->where('common_id', $structureId)
            ->where('member_id', $memberId)
            ->where('period', $period)
            ->exists();
    }

    /**
     * Get max order for structure and period
     */
    public function getMaxOrder($structureId, $period)
    {
        return $this->model
            ->where('common_id', $structureId)
            ->where('period', $period)
            ->max('order') ?? 0;
    }

    /**
     * Update order for multiple members
     */
    public function updateOrders(array $orders)
    {
        foreach ($orders as $id => $order) {
            $this->model->where('id', $id)->update(['order' => $order]);
        }
    }

    /**
     * Delete by structure member ID
     */
    public function deleteByStructureMemberId($id)
    {
        return $this->model->where('id', $id)->delete();
    }
}

