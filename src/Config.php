<?php

namespace Greg\Support;

class Config
{
    public static function dir($dir, $main = null)
    {
        $config = static::parseDir($dir);

        if ($main) {
            return static::parseMainConfig($config, $main);
        }

        return $config;
    }

    public static function iniFile($file, $section = null, $indexDelimiter = null)
    {
        return static::iniContents(static::parseFile($file), $section, $indexDelimiter);
    }

    public static function iniString($string, $section = null, $indexDelimiter = null)
    {
        return static::iniContents(static::parseString($string), $section, $indexDelimiter);
    }

    protected static function iniContents(array $contents, $section = null, $indexDelimiter = null)
    {
        if (static::hasSections($contents)) {
            return static::contentsWithSections($contents, $section, $indexDelimiter);
        }

        if ($section) {
            throw new \Exception('You don\'t have any sections in the config.');
        }

        if ($indexDelimiter) {
            return static::parseIndexes($contents, $indexDelimiter);
        }

        return $contents;
    }

    protected static function contentsWithSections(array $contents, $section = null, $indexDelimiter = null)
    {
        $contents = static::parseContentsWithSections($contents);

        if ($indexDelimiter) {
            foreach ($contents as $key => &$values) {
                $values = static::parseIndexes($values, $indexDelimiter);
            }
            unset($values);
        }

        if ($section) {
            if (!array_key_exists($section, $contents)) {
                throw new \Exception('Config ini section `' . $section . '` not found.');
            }

            return $contents[$section];
        }

        return $contents;
    }

    protected static function hasSections(array &$contents)
    {
        return is_array(current($contents));
    }

    protected static function parseContentsWithSections(&$contents)
    {
        $return = $keysParts = [];

        foreach ($contents as $key => $value) {
            $keysParts[$key] = array_map('trim', explode(':', $key));

            $return[$keysParts[$key][0]] = $value;
        }

        foreach ($keysParts as $parts) {
            $primary = array_shift($parts);

            foreach ($parts as $part) {
                $return[$primary] = array_replace($return[$part], $return[$primary]);
            }
        }

        return $return;
    }

    protected static function parseIndexes($contents, $indexDelimiter)
    {
        $fetchedSection = [];

        foreach ($contents as $key => $value) {
            $keys = explode($indexDelimiter, $key);

            $contentsLevel = &$fetchedSection;

            foreach ($keys as $part) {
                if ($part == '') {
                    $contentsLevel = &$contentsLevel[];
                } else {
                    $contentsLevel = &$contentsLevel[$part];
                }
            }

            $contentsLevel = $value;
        }

        return $fetchedSection;
    }

    protected static function parseFile($file)
    {
        return parse_ini_file($file, true) ?: [];
    }

    protected static function parseString($string)
    {
        return parse_ini_string($string, true) ?: [];
    }

    protected static function parseMainConfig(array $config, $main)
    {
        if (!array_key_exists($main, $config)) {
            throw new \Exception('Main config `' . $main . '` not found.');
        }

        $mainConfig = $config[$main];

        unset($config[$main]);

        return array_merge($mainConfig, $config);
    }

    protected static function parseDir($dir)
    {
        $config = [];

        foreach (glob($dir . DIRECTORY_SEPARATOR . '*') as $resource) {
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
            return static::parseDir($resource);
        }

        if (static::isConfigFile($resource)) {
            return ___gregRequireFile($resource);
        }

        return false;
    }

    protected static function isConfigFile($file)
    {
        return is_file($file) and pathinfo($file, PATHINFO_EXTENSION) == 'php';
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
