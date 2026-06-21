<?php

namespace App\Services;

use App\Repositories\SecretariatRepository;
use App\Services\FileUploadService;

class SecretariatService extends BaseService
{
    public function __construct(
        private SecretariatRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create secretariat
     */
    public function create(array $data)
    {
        try {
            // Upload photo if exists
            if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                $data['photo'] = $this->fileService->uploadAndResize($data['photo'], 'secretariat', 400, 400);
            }

            $secretariat = $this->repository->create($data);
            return $this->success($secretariat, 'Sekretariat berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat sekretariat', $e->getMessage());
        }
    }

    /**
     * Update secretariat
     */
    public function update($id, array $data)
    {
        try {
            $secretariat = $this->repository->find($id);
            if (!$secretariat) {
                return $this->error('Sekretariat tidak ditemukan');
            }

            // Handle photo upload
            if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                if ($secretariat->photo) {
                    $this->fileService->delete($secretariat->photo);
                }
                $data['photo'] = $this->fileService->uploadAndResize($data['photo'], 'secretariat', 400, 400);
            }

            $secretariat = $this->repository->update($id, $data);
            return $this->success($secretariat, 'Sekretariat berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate sekretariat', $e->getMessage());
        }
    }

    /**
     * Get active secretariat
     */
    public function getActive($perPage = null)
    {
        try {
            $secretariat = $this->repository->getActive($perPage);
            return $this->success($secretariat);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil sekretariat', $e->getMessage());
        }
    }

    /**
     * Get all secretariat with filter
     */
    public function getAll(string $search = null, $perPage = 15)
    {
        try {
            $query = $this->repository->query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('position', 'like', "%{$search}%")
                      ->orWhere('division', 'like', "%{$search}%");
                });
            }

            $query->orderBy('name', 'asc');
            $secretariat = $query->paginate($perPage);

            return $this->success($secretariat);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil sekretariat', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $secretariat = $this->repository->find($id);
            if ($secretariat) {
                return $this->success($secretariat);
            }
            return $this->error('Sekretariat tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil sekretariat', $e->getMessage());
        }
    }

    /**
     * Delete secretariat
     */
    public function delete($id)
    {
        try {
            $secretariat = $this->repository->find($id);
            if (!$secretariat) {
                return $this->error('Sekretariat tidak ditemukan');
            }

            if ($secretariat->photo) {
                $this->fileService->delete($secretariat->photo);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Sekretariat berhasil dihapus');
            }
            return $this->error('Gagal menghapus sekretariat');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus sekretariat', $e->getMessage());
        }
    }
}

