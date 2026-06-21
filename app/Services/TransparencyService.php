<?php

namespace App\Services;

use App\Repositories\TransparencyRepository;
use App\Services\FileUploadService;

class TransparencyService extends BaseService
{
    public function __construct(
        private TransparencyRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create transparency record
     */
    public function create(array $data)
    {
        try {
            // Upload file
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                $data['file'] = $this->fileService->upload($data['file'], 'transparency');
            }

            $transparency = $this->repository->create($data);
            return $this->success($transparency, 'Dokumen transparansi berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat dokumen transparansi', $e->getMessage());
        }
    }

    /**
     * Update transparency record
     */
    public function update($id, array $data)
    {
        try {
            $transparency = $this->repository->find($id);
            if (!$transparency) {
                return $this->error('Dokumen transparansi tidak ditemukan');
            }

            // Handle file upload
            if (isset($data['file']) && $data['file'] instanceof \Illuminate\Http\UploadedFile) {
                if ($transparency->file) {
                    $this->fileService->delete($transparency->file);
                }
                $data['file'] = $this->fileService->upload($data['file'], 'transparency');
            }

            $transparency = $this->repository->update($id, $data);
            return $this->success($transparency, 'Dokumen transparansi berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate dokumen transparansi', $e->getMessage());
        }
    }

    /**
     * Get public transparency records
     */
    public function getPublic($perPage = 10)
    {
        try {
            $transparency = $this->repository->getPublic($perPage);
            return $this->success($transparency);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil dokumen transparansi', $e->getMessage());
        }
    }

    /**
     * Get all transparency with filter
     */
    public function getAll(string $type = null, int $year = null, $perPage = 15)
    {
        try {
            $query = $this->repository->query();

            if ($type) {
                $query->where('type', $type);
            }

            if ($year) {
                $query->where('year', $year);
            }

            $query->orderBy('year', 'desc')->orderBy('created_at', 'desc');
            $transparency = $query->paginate($perPage);

            return $this->success($transparency);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil dokumen transparansi', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $transparency = $this->repository->find($id);
            if ($transparency) {
                return $this->success($transparency);
            }
            return $this->error('Dokumen transparansi tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil dokumen transparansi', $e->getMessage());
        }
    }

    /**
     * Delete transparency
     */
    public function delete($id)
    {
        try {
            $transparency = $this->repository->find($id);
            if (!$transparency) {
                return $this->error('Dokumen transparansi tidak ditemukan');
            }

            if ($transparency->file) {
                $this->fileService->delete($transparency->file);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Dokumen transparansi berhasil dihapus');
            }
            return $this->error('Gagal menghapus dokumen transparansi');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus dokumen transparansi', $e->getMessage());
        }
    }
}

