<?php

namespace App\Helpers;

use Illuminate\Support\Facades\Crypt;

class QueryEncryption
{
    /**
     * Encrypt query parameter value
     *
     * @param mixed $value
     * @return string
     */
    public static function encrypt($value)
    {
        try {
            return base64_encode(Crypt::encryptString((string)$value));
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Decrypt query parameter value
     *
     * @param string $value
     * @return mixed
     */
    public static function decrypt($value)
    {
        try {
            return Crypt::decryptString(base64_decode($value));
        } catch (\Exception $e) {
            return $value;
        }
    }

    /**
     * Encrypt all query parameters in URL
     *
     * @param string $url
     * @param array $except Keys to exclude from encryption
     * @return string
     */
    public static function encryptUrl($url, $except = [])
    {
        $parts = parse_url($url);
        
        if (!isset($parts['query'])) {
            return $url;
        }

        parse_str($parts['query'], $params);
        $encryptedParams = [];

        foreach ($params as $key => $value) {
            if (in_array($key, $except)) {
                $encryptedParams[$key] = $value;
            } else {
                $encryptedParams[$key] = self::encrypt($value);
            }
        }

        $baseUrl = $parts['scheme'] . '://' . $parts['host'];
        if (isset($parts['port'])) {
            $baseUrl .= ':' . $parts['port'];
        }
        $baseUrl .= $parts['path'] ?? '';

        return $baseUrl . '?' . http_build_query($encryptedParams);
    }

    /**
     * Decrypt all query parameters from request
     *
     * @param array $params
     * @param array $except Keys to exclude from decryption
     * @return array
     */
    public static function decryptParams($params, $except = [])
    {
        $decryptedParams = [];

        foreach ($params as $key => $value) {
            if (in_array($key, $except)) {
                $decryptedParams[$key] = $value;
            } else {
                $decryptedParams[$key] = self::decrypt($value);
            }
        }

        return $decryptedParams;
    }
}
