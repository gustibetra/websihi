<?php

namespace App\Repositories;

use App\Models\Teacher;

class TeacherRepository extends BaseRepository
{
    public function __construct(Teacher $model)
    {
        parent::__construct($model);
    }

    /**
     * Get active teachers
     */
    public function getActive($perPage = null)
    {
        $query = $this->model->where('is_active', true)
            ->orderBy('name', 'asc');

        return $perPage ? $query->paginate($perPage) : $query->get();
    }

    /**
     * Get teachers by jurusan
     */
    public function getByJurusan($jurusanId)
    {
        return $this->model->where('jurusan_id', $jurusanId)
            ->where('is_active', true)
            ->orderBy('name', 'asc')
            ->get();
    }

    /**
     * Search teachers
     */
    public function search(string $keyword, $perPage = 10)
    {
        return $this->model->where('is_active', true)
            ->where(function ($query) use ($keyword) {
                $query->where('name', 'like', "%{$keyword}%")
                    ->orWhere('nip', 'like', "%{$keyword}%")
                    ->orWhere('jabatan', 'like', "%{$keyword}%")
                    ->orWhere('bidang_studi', 'like', "%{$keyword}%");
            })
            ->orderBy('name', 'asc')
            ->paginate($perPage);
    }
}
