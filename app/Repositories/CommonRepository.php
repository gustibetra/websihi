<?php

namespace App\Repositories;

use App\Models\Common;

class CommonRepository extends BaseRepository
{
    public function __construct(Common $model)
    {
        parent::__construct($model);
    }

    /**
     * Get data by table name
     */
    public function getByTableName(string $tableName)
    {
        return $this->model->where('table_name', $tableName)->get();
    }

    /**
     * Get data by table name and key
     */
    public function getByTableAndKey(string $tableName, string $key1, $key2 = null, $key3 = null)
    {
        $query = $this->model->where('table_name', $tableName)
            ->where('key1', $key1);

        if ($key2 !== null) {
            $query->where('key2', $key2);
        }

        if ($key3 !== null) {
            $query->where('key3', $key3);
        }

        return $query->get();
    }
    
    /**
     * Update records matching where conditions
     */
    public function updateWhere(array $where, array $data)
    {
        return $this->model->where($where)->update($data);
    }
    
    /**
     * Update records matching where conditions except specific ID
     */
    public function updateWhereNot(array $where, $exceptId, array $data)
    {
        return $this->model->where($where)->where('id', '!=', $exceptId)->update($data);
    }
    
    /**
     * Get data by table name with pagination and filters
     */
    public function getByTableNamePaginated(string $tableName, array $filters = [])
    {
        $query = $this->model->where('table_name', $tableName);
        
        // (Removed structureMembers relation to fix 500 error)
        
        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function($q) use ($search) {
                $q->where('key1', 'like', "%{$search}%")
                  ->orWhere('data1', 'like', "%{$search}%")
                  ->orWhere('data2', 'like', "%{$search}%")
                  ->orWhere('text1', 'like', "%{$search}%");
            });
        }
        
        // Apply structure type filter (for structures)
        if (!empty($filters['structure_type'])) {
            $query->where('data5', $filters['structure_type']);
        }
        
        // Apply period filter (data2 contains period ID)
        if (!empty($filters['period_id'])) {
            $query->where('data2', $filters['period_id']);
        }

        // Apply jurusan scoping (data3 contains jurusan ID)
        if (!empty($filters['jurusan_id'])) {
            $query->where('data3', $filters['jurusan_id']);
        }
        
        // Apply status filter (data4 contains status: 1=active, 0=inactive)
        if (isset($filters['status']) && $filters['status'] !== '') {
            $query->where('data4', $filters['status']);
        }
        
        // Apply sorting
        $sortBy = $filters['sortBy'] ?? 'key1';
        $sortDirection = $filters['sortDirection'] ?? 'asc';
        $query->orderBy($sortBy, $sortDirection);
        
        // Apply secondary sorting if provided
        if (!empty($filters['secondarySortBy'])) {
            $secondarySortDirection = $filters['secondarySortDirection'] ?? 'asc';
            $query->orderBy($filters['secondarySortBy'], $secondarySortDirection);
        }
        
        // Apply pagination
        $perPage = $filters['perPage'] ?? 15;
        
        return $query->paginate($perPage);
    }
}

