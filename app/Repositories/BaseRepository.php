<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

/**
 * Base Repository Class
 * 
 * Base class untuk semua Repository classes
 * Berisi common database operations
 */
abstract class BaseRepository
{
    protected $model;

    /**
     * BaseRepository constructor
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Get all records
     */
    public function all()
    {
        return $this->model->all();
    }

    /**
     * Find by ID
     */
    public function find($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create new record
     */
    public function create(array $data)
    {
        // Use database time for timestamps by using query builder
        if ($this->model->usesTimestamps()) {
            // Get table name
            $table = $this->model->getTable();
            
            // Add timestamps using NOW()
            $data['created_at'] = \DB::raw('NOW()');
            $data['updated_at'] = \DB::raw('NOW()');
            
            // Insert using query builder to support DB::raw
            $id = \DB::table($table)->insertGetId($data);
            
            // Return the created model
            return $this->find($id);
        }
        
        return $this->model->create($data);
    }

    /**
     * Update record
     */
    public function update($id, array $data)
    {
        $record = $this->find($id);
        if ($record) {
            try {
                // Use database time for updated_at by using query builder
                if ($this->model->usesTimestamps()) {
                    // Add updated_at with database time
                    $data['updated_at'] = \DB::raw('NOW()');
                    
                    // Update using query builder to support DB::raw
                    // This will handle both regular values and DB::raw expressions
                    \DB::table($this->model->getTable())
                        ->where('id', $id)
                        ->update($data);
                    
                    // Return fresh model
                    return $this->find($id);
                }
                
                $record->update($data);
                return $record->fresh();
            } catch (\Exception $e) {
                \Log::error('BaseRepository update error: ' . $e->getMessage(), [
                    'id' => $id,
                    'data_keys' => array_keys($data),
                    'exception' => $e
                ]);
                throw $e;
            }
        }
        return null;
    }

    /**
     * Delete record
     */
    public function delete($id)
    {
        $record = $this->find($id);
        if ($record) {
            return $record->delete();
        }
        return false;
    }

    /**
     * Get model instance
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * Get query builder
     */
    public function query()
    {
        return $this->model->query();
    }
}

