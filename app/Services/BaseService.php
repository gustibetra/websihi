<?php

namespace App\Services;

/**
 * Base Service Class
 * 
 * Base class untuk semua Service classes
 * Berisi common methods yang bisa digunakan oleh semua services
 */
abstract class BaseService
{
    /**
     * Return success response
     */
    protected function success($data = null, string $message = 'Success')
    {
        return [
            'success' => true,
            'message' => $message,
            'data' => $data,
        ];
    }

    /**
     * Return error response
     */
    protected function error(string $message = 'Error', $errors = null)
    {
        return [
            'success' => false,
            'message' => $message,
            'errors' => $errors,
        ];
    }
}

