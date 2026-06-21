<?php

namespace App\Services;

use App\Repositories\TeacherRepository;
use App\Services\FileUploadService;

class TeacherService extends BaseService
{
    public function __construct(
        private TeacherRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Create teacher
     */
    public function create(array $data)
    {
        try {
            // Upload photo if exists
            if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                $data['photo'] = $this->fileService->uploadAndResize($data['photo'], 'teachers', 400, 400);
            }

            $teacher = $this->repository->create($data);
            return $this->success($teacher, 'Guru/Tendik berhasil dibuat');
        } catch (\Exception $e) {
            return $this->error('Gagal membuat guru/tendik', $e->getMessage());
        }
    }

    /**
     * Update teacher
     */
    public function update($id, array $data)
    {
        try {
            $teacher = $this->repository->find($id);
            if (!$teacher) {
                return $this->error('Guru/Tendik tidak ditemukan');
            }

            // Handle photo upload
            if (isset($data['photo']) && $data['photo'] instanceof \Illuminate\Http\UploadedFile) {
                if ($teacher->photo) {
                    $this->fileService->delete($teacher->photo);
                }
                $data['photo'] = $this->fileService->uploadAndResize($data['photo'], 'teachers', 400, 400);
            }

            $teacher = $this->repository->update($id, $data);
            return $this->success($teacher, 'Guru/Tendik berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate guru/tendik', $e->getMessage());
        }
    }

    /**
     * Get active teachers
     */
    public function getActive($perPage = null)
    {
        try {
            $teachers = $this->repository->getActive($perPage);
            return $this->success($teachers);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil guru/tendik', $e->getMessage());
        }
    }

    /**
     * Search teachers
     */
    public function search(string $keyword, $perPage = 10)
    {
        try {
            $teachers = $this->repository->search($keyword, $perPage);
            return $this->success($teachers);
        } catch (\Exception $e) {
            return $this->error('Gagal mencari guru/tendik', $e->getMessage());
        }
    }

    /**
     * Get all teachers with filter
     */
    public function getAll(string $search = null, $perPage = 10, $jurusanId = null)
    {
        try {
            $query = $this->repository->query();

            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nip', 'like', "%{$search}%")
                      ->orWhere('jabatan', 'like', "%{$search}%")
                      ->orWhere('bidang_studi', 'like', "%{$search}%");
                });
            }

            if ($jurusanId !== null) {
                $query->where('jurusan_id', $jurusanId);
            }

            $query->orderBy('name', 'asc');
            $teachers = $query->paginate($perPage);

            return $this->success($teachers);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil guru/tendik', $e->getMessage());
        }
    }

    /**
     * Get by ID
     */
    public function getById($id)
    {
        try {
            $teacher = $this->repository->find($id);
            if ($teacher) {
                return $this->success($teacher);
            }
            return $this->error('Guru/Tendik tidak ditemukan');
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil guru/tendik', $e->getMessage());
        }
    }

    /**
     * Delete teacher
     */
    public function delete($id)
    {
        try {
            $teacher = $this->repository->find($id);
            if (!$teacher) {
                return $this->error('Guru/Tendik tidak ditemukan');
            }

            if ($teacher->photo) {
                $this->fileService->delete($teacher->photo);
            }

            $deleted = $this->repository->delete($id);
            if ($deleted) {
                return $this->success(null, 'Guru/Tendik berhasil dihapus');
            }
            return $this->error('Gagal menghapus guru/tendik');
        } catch (\Exception $e) {
            return $this->error('Gagal menghapus guru/tendik', $e->getMessage());
        }
    }
}
