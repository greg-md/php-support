<?php

namespace Greg\Support\Config;

class ConfigIni
{
    public static function file($file, $section = null, $indexDelimiter = null)
    {
        return static::contents(static::parseFile($file), $section, $indexDelimiter);
    }

    public static function string($string, $section = null, $indexDelimiter = null)
    {
        return static::contents(static::parseString($string), $section, $indexDelimiter);
    }

    protected static function contents(array $contents, $section = null, $indexDelimiter = null)
    {
        if (static::hasSections($contents)) {
            return static::contentsWithSections($contents, $section, $indexDelimiter);
        }

        if ($section) {
            throw new ConfigException('You don\'t have any sections in the config.');
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
                throw new ConfigException('Config ini section `' . $section . '` not found.');
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

            if (is_array($value)) {
                $value = static::parseIndexes($value, $indexDelimiter);
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
}
