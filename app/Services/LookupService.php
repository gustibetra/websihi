<?php

namespace App\Services;

use App\Repositories\CommonRepository;
use Illuminate\Support\Collection;

class LookupService
{
    public function __construct(
        private CommonRepository $commonRepository
    ) {}

    /**
     * Get lookup options for dropdown
     * 
     * @param string $tableName Table name in common table
     * @param string|null $valueField Field to use as value (default: 'id')
     * @param string|null $labelField Field to use as label (default: 'data1')
     * @param array $defaultOptions Default options to prepend (e.g., ['all' => 'Semua'])
     * @param callable|null $filterCallback Optional filter callback
     * @return array Array of ['value' => 'label'] options
     */
    public function getOptions(
        string $tableName,
        ?string $valueField = null,
        ?string $labelField = null,
        array $defaultOptions = [],
        ?callable $filterCallback = null
    ): array {
        $valueField = $valueField ?? 'id';
        $labelField = $labelField ?? 'data1';

        try {
            $data = $this->commonRepository->getByTableName($tableName);
            
            // Apply filter if provided
            if ($filterCallback && is_callable($filterCallback)) {
                $data = $data->filter($filterCallback);
            }

            $options = $data->mapWithKeys(function ($item) use ($valueField, $labelField) {
                $value = $this->getFieldValue($item, $valueField);
                $label = $this->getFieldValue($item, $labelField) ?? $value;
                return [$value => $label];
            })->toArray();

            // Prepend default options
            if (!empty($defaultOptions)) {
                $options = array_merge($defaultOptions, $options);
            }

            return $options;
        } catch (\Exception $e) {
            // Return default options only if error
            return $defaultOptions;
        }
    }

    /**
     * Get lookup collection (for advanced usage)
     * 
     * @param string $tableName
     * @param callable|null $filterCallback
     * @return Collection
     */
    public function getCollection(string $tableName, ?callable $filterCallback = null): Collection
    {
        try {
            $data = $this->commonRepository->getByTableName($tableName);
            
            if ($filterCallback && is_callable($filterCallback)) {
                $data = $data->filter($filterCallback);
            }

            return $data;
        } catch (\Exception $e) {
            return collect([]);
        }
    }

    /**
     * Get single lookup item by value
     * 
     * @param string $tableName
     * @param mixed $value
     * @param string $field Field to search (default: 'id')
     * @return mixed|null
     */
    public function getItem(string $tableName, $value, string $field = 'id')
    {
        try {
            $data = $this->commonRepository->getByTableName($tableName);
            return $data->firstWhere($field, $value);
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get field value from item (supports nested fields)
     * 
     * @param mixed $item
     * @param string $field
     * @return mixed
     */
    private function getFieldValue($item, string $field)
    {
        if (is_object($item)) {
            return $item->$field ?? null;
        } elseif (is_array($item)) {
            return $item[$field] ?? null;
        }
        return null;
    }

    // ==================== Convenience Methods ====================

    /**
     * Get news categories
     */
    public function getNewsCategories(array $defaultOptions = []): array
    {
        return $this->getOptions('kategori_berita', 'id', 'data1', $defaultOptions);
    }

    /**
     * Get periods (return collection for advanced usage)
     */
    public function getPeriods(): Collection
    {
        return $this->getCollection('period')->sortByDesc('date1');
    }
    
    /**
     * Get political parties (return collection for advanced usage)
     */
    public function getPoliticalParties(): Collection
    {
        return $this->getCollection('political_party')->sortBy('data1');
    }

    /**
     * Get event categories
     */
    public function getEventCategories(array $defaultOptions = []): array
    {
        return $this->getOptions('kategori_event', 'id', 'data1', $defaultOptions);
    }

    /**
     * Get announcement categories
     */
    public function getAnnouncementCategories(array $defaultOptions = []): array
    {
        return $this->getOptions('kategori_pengumuman', 'id', 'data1', $defaultOptions);
    }

    /**
     * Get structure types
     */
    public function getStructureTypes(array $defaultOptions = []): array
    {
        return $this->getOptions('structure_type', 'key1', 'data1', $defaultOptions);
    }

    /**
     * Get structures by type
     */
    public function getStructures(string $structureType, array $defaultOptions = []): array
    {
        return $this->getOptions(
            'structure',
            'id',
            'data1',
            $defaultOptions,
            function ($item) use ($structureType) {
                return ($item->key2 ?? null) === $structureType;
            }
        );
    }

    /**
     * Get status options (hardcoded, not from common table)
     */
    public function getStatusOptions(): array
    {
        return [
            'all' => 'Semua Status',
            'published' => 'Published',
            'draft' => 'Draft',
            'archived' => 'Archived',
        ];
    }

    /**
     * Get news status options (for form)
     */
    public function getNewsStatusOptions(): array
    {
        return [
            'draft' => 'Draft',
            'published' => 'Published',
            'archived' => 'Archived',
        ];
    }

    /**
     * Get positions (return collection for advanced usage)
     */
    public function getPositions(): Collection
    {
        return $this->getCollection('position')->where('data4', '1')->sortBy('data1');
    }
}

