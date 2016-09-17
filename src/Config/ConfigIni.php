<?php

namespace Greg\Support\Config;

class ConfigIni
{
    public static function file($file, $section = null, $indexDelimiter = null)
    {
        return static::fetchContents(static::parseFile($file), $section, $indexDelimiter);
    }

    public static function string($string, $section = null, $indexDelimiter = null)
    {
        return static::fetchContents(static::parseString($string), $section, $indexDelimiter);
    }

    protected static function parseFile($file)
    {
        return parse_ini_file($file, true);
    }

    protected static function parseString($string)
    {
        return parse_ini_string($string, true);
    }

    protected static function fetchContents($contents, $section = null, $indexDelimiter = null)
    {
        $return = [];

        if ($contents) {
            if ($section) {
                $partsParam = [];

                foreach ($contents as $key => $value) {
                    $parts = array_map('trim', explode(':', $key));

                    $partsParam[$key] = $parts;

                    $primary = array_shift($parts);

                    $return[$primary] = $indexDelimiter ? static::fetchIndexes($value, $indexDelimiter) : $value;
                }

                foreach ($partsParam as $parts) {
                    $primary = array_shift($parts);

                    foreach ($parts as $part) {
                        $return[$primary] = array_replace_recursive($return[$part], $return[$primary]);
                    }
                }
            } else {
                $return = $indexDelimiter ? static::fetchIndexes($contents, $indexDelimiter) : $contents;
            }

            if ($section) {
                if (!array_key_exists($section, $return)) {
                    throw new ConfigException('Config ini section `' . $section . '` not found.');
                }

                $return = $return[$section];
            }
        }

        return $return;
    }

    protected static function fetchIndexes($contents, $indexDelimiter)
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

            if (is_array($value)) {
                $value = static::fetchIndexes($value, $indexDelimiter);
            }

            $contentsLevel = $value;
        }

        return $fetchedSection;
    }
}
