<?php

namespace Greg\Support\Config;

class ConfigDir
{
    const EXTENSION = 'php';

    public static function path($path, $main = null)
    {
        $config = [];

        foreach (glob($path . DIRECTORY_SEPARATOR . '*') as $file) {
            $settings = null;

            if (is_dir($file)) {
                $settings = static::path($file);
            }

            if (is_file($file) and pathinfo($file, PATHINFO_EXTENSION) == static::EXTENSION) {
                $settings = ___gregRequireFile($file);
            }

            if ($settings !== null) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);

                $config[$fileName] = isset($config[$fileName]) ? array_merge($config[$fileName], $settings) : $settings;
            }
        }

        if ($main) {
            if (!array_key_exists($main, $config)) {
                throw new \Exception('Main config `' . $main . '` not found.');
            }

            $mainConfig = $config[$main];

            unset($config[$main]);

            $config = array_merge($mainConfig, $config);
        }

        return $config;
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
