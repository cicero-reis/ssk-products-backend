<?php

if (!function_exists('config')) {

    function config($key, $default = null)
    {
        $keys = explode('.', $key);
        $config = null;

        if (isset($keys[0])) {
            $configPath = '/var/www/config/' . $keys[0] . '.php';

            if (file_exists($configPath)) {
                $config = include $configPath;
            }
        }

        foreach (array_slice($keys, 1) as $key) {
            if (isset($config[$key])) {
                $config = $config[$key];
            } else {
                return $default;
            }
        }

        return $config ?? $default;
    }
}

if (!function_exists('sanitizeFileName')) {

    function sanitizeFileName(string $filename): string
    {
        return preg_replace('/[^a-zA-Z0-9-_]/i', '_', $filename);
    }
}
