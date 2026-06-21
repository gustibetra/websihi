<?php

use App\Helpers\QueryEncryption;

if (!function_exists('encrypt_query')) {
    /**
     * Encrypt query parameter value
     *
     * @param mixed $value
     * @return string
     */
    function encrypt_query($value)
    {
        return QueryEncryption::encrypt($value);
    }
}

if (!function_exists('decrypt_query')) {
    /**
     * Decrypt query parameter value
     *
     * @param string $value
     * @return mixed
     */
    function decrypt_query($value)
    {
        return QueryEncryption::decrypt($value);
    }
}

if (!function_exists('route_encrypted')) {
    /**
     * Generate route with encrypted query parameters
     *
     * @param string $name
     * @param array $parameters
     * @param bool $absolute
     * @return string
     */
    function route_encrypted($name, $parameters = [], $absolute = true)
    {
        $encryptedParams = [];
        
        foreach ($parameters as $key => $value) {
            $encryptedParams[$key] = encrypt_query($value);
        }
        
        return route($name, $encryptedParams, $absolute);
    }
}
