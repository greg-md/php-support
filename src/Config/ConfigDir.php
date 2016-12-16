<?php

namespace Greg\Support\Config;

class ConfigDir
{
    const EXTENSION = 'php';

    public static function path($path, $main = null)
    {
        $config = static::parsePath($path);

        if ($main) {
            return static::parseMainConfig($config, $main);
        }

        return $config;
    }

    protected function parseMainConfig(array $config, $main)
    {
        if (!array_key_exists($main, $config)) {
            throw new \Exception('Main config `' . $main . '` not found.');
        }

        $mainConfig = $config[$main];

        unset($config[$main]);

        return array_merge($mainConfig, $config);
    }

    protected static function parsePath($path)
    {
        $config = [];

        foreach (glob($path . DIRECTORY_SEPARATOR . '*') as $resource) {
            if (!$settings = static::parseResource($resource)) {
                continue;
            }

            $fileName = pathinfo($resource, PATHINFO_FILENAME);

            $config[$fileName] = isset($config[$fileName]) ? array_merge($config[$fileName], $settings) : $settings;
        }

        return $config;
    }

    protected static function parseResource($resource)
    {
        if (is_dir($resource)) {
            return static::parsePath($resource);
        }

        if (static::isConfigFile($resource)) {
            return ___gregRequireFile($resource);
        }

        return false;
    }

    protected static function isConfigFile($file)
    {
        return is_file($file) and pathinfo($file, PATHINFO_EXTENSION) == static::EXTENSION;
    }
}

/*
 * Scope isolated include.
 *
 * Prevents access to $this/self from included files.
 */
if (!function_exists('___gregRequireFile')) {
    function ___gregRequireFile($file)
    {
        return require $file;
    }
}
