<?php

namespace App\Services;

use App\Repositories\SettingRepository;
use App\Services\FileUploadService;

class SettingService extends BaseService
{
    public function __construct(
        private SettingRepository $repository,
        private FileUploadService $fileService
    ) {}

    /**
     * Update settings
     */
    public function update(array $data)
    {
        try {
            // Handle logo upload (original size)
            if (isset($data['logo']) && $data['logo'] instanceof \Illuminate\Http\UploadedFile) {
                $setting = $this->repository->getFirstOrCreate();
                if ($setting->logo) {
                    $this->fileService->delete($setting->logo);
                }
                $data['logo'] = $this->fileService->uploadAndResize($data['logo'], 'settings', 300, 300);
            }

            // Handle logo square upload (1:1 ratio)
            if (isset($data['logo_square']) && $data['logo_square'] instanceof \Illuminate\Http\UploadedFile) {
                $setting = $this->repository->getFirstOrCreate();
                if ($setting->logo_square) {
                    $this->fileService->delete($setting->logo_square);
                }
                $data['logo_square'] = $this->fileService->uploadAndResize($data['logo_square'], 'settings', 200, 200);
            }

            // Handle favicon upload
            if (isset($data['favicon']) && $data['favicon'] instanceof \Illuminate\Http\UploadedFile) {
                $setting = $this->repository->getFirstOrCreate();
                if ($setting->favicon) {
                    $this->fileService->delete($setting->favicon);
                }
                $data['favicon'] = $this->fileService->uploadAndResize($data['favicon'], 'settings', 32, 32);
            }

            $setting = $this->repository->updateSettings($data);
            return $this->success($setting, 'Pengaturan berhasil diupdate');
        } catch (\Exception $e) {
            return $this->error('Gagal mengupdate pengaturan', $e->getMessage());
        }
    }

    /**
     * Get settings
     */
    public function get()
    {
        try {
            $setting = $this->repository->getFirstOrCreate();
            return $this->success($setting);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil pengaturan', $e->getMessage());
        }
    }

    /**
     * Get all settings
     */
    public function getAll()
    {
        try {
            $settings = $this->repository->all();
            return $this->success($settings);
        } catch (\Exception $e) {
            return $this->error('Gagal mengambil pengaturan', $e->getMessage());
        }
    }

    /**
     * Update or create setting by key
     */
    public function updateOrCreate(string $key, $value)
    {
        try {
            $setting = $this->repository->updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );
            return $this->success($setting);
        } catch (\Exception $e) {
            return $this->error('Gagal menyimpan pengaturan', $e->getMessage());
        }
    }
}

