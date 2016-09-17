<?php

namespace Greg\Support\Config;

class ConfigPath
{
    public static function fetch($path, array $params = [], $ext = 'php')
    {
        $config = [];

        foreach (glob($path.DIRECTORY_SEPARATOR.'*') as $file) {
            $settings = null;

            if (is_dir($file)) {
                $settings = static::fetch($file, $params, $ext);
            }

            if (is_file($file) and pathinfo($file, PATHINFO_EXTENSION) == $ext) {
                $settings = ___gregRequireFile($file, $params);
            }

            if ($settings !== null) {
                $fileName = pathinfo($file, PATHINFO_FILENAME);

                $config[$fileName] = isset($config[$fileName]) ? array_merge($config[$fileName], $settings) : $settings;
            }
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
    function ___gregRequireFile($___file, array $___params = [])
    {
        extract($___params);

        return require $___file;
    }
}
