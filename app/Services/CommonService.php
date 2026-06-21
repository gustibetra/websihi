<?php

namespace App\Services;

use App\Repositories\CommonRepository;

class CommonService extends BaseService
{
    public function __construct(
        private CommonRepository $repository,
        private CommonIdGeneratorService $idGenerator
    ) {}

    /**
     * Get data by table name
     */
    public function getByTableName(string $tableName)
    {
        try {
            $data = $this->repository->getByTableName($tableName);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil data', $e->getMessage());
        }
    }

    /**
     * Get data by table and key
     */
    public function getByTableAndKey(string $tableName, string $key1, $key2 = null, $key3 = null)
    {
        try {
            $data = $this->repository->getByTableAndKey($tableName, $key1, $key2, $key3);
            return $this->success($data);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil data', $e->getMessage());
        }
    }

    /**
     * Create common data
     */
    public function create(array $data)
    {
        try {
            $tableName = $data['table_name'] ?? null;
            
            // Auto-generate key1 jika belum ada dan table_name memerlukan ID generation
            if ($tableName && empty($data['key1'])) {
                $structureType = $data['key2'] ?? null; // structure_type biasanya di key2
                $data['key1'] = $this->idGenerator->generateId($tableName, $structureType);
            }
            
            // Validate key1 is unique
            if (!empty($data['key1']) && $tableName) {
                if (!$this->idGenerator->isIdUnique($tableName, $data['key1'])) {
                    return $this->error('ID sudah digunakan', 'Key1 harus unique per table_name');
                }
            }
            
            $common = $this->repository->create($data);
            return $this->success($common, 'Data berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat data', $e->getMessage());
        }
    }

    /**
     * Update common data
     */
    public function update($id, array $data)
    {
        try {
            $common = $this->repository->update($id, $data);
            if ($common) {
                return $this->success($common, 'Data berhasil diupdate');
            }
            return $this->error('Data tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate data', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $common = $this->repository->find($id);
            if ($common) {
                return $this->success($common);
            }
            return $this->error('Data tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil data', $e->getMessage());
        }
    }

    /**
     * Delete common data
     */
    public function delete($id)
    {
        try {
            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Data berhasil dihapus');
            }
            return $this->error('Data tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus data', $e->getMessage());
        }
    }
    
    /**
     * Toggle period active status
     */
    public function togglePeriodActive($id)
    {
        try {
            $period = $this->repository->find($id);
            
            if (!$period || $period->table_name !== 'period') {
                return $this->error('Period tidak ditemukan');
            }
            
            $newStatus = $period->data4 === '1' ? '0' : '1';
            $this->repository->update($id, ['data4' => $newStatus]);
            
            return $this->success(null, $newStatus === '1' ? 'Period berhasil diaktifkan' : 'Period berhasil dinonaktifkan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengubah status period', $e->getMessage());
        }
    }
}

