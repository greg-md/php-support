<?php

namespace Greg\Support\Tools;

class Regex
{
    private static $delimiter = '#';

    public static function inNamespace($start, $end, $recursive = true)
    {
        return new InNamespaceRegex($start, $end, $recursive);
    }

    public static function disableGroups($regex)
    {
        return preg_replace(static::pattern('(?<!\\\\)\((?!\?)'), '(?:', $regex);
    }

    public static function quote($string, $delimiter = null)
    {
        return preg_quote($string, $delimiter ?: static::$delimiter);
    }

    public static function pattern($regex, $flags = null)
    {
        return static::$delimiter . $regex . static::$delimiter . $flags;
    }

    public static function setDelimiter($delimiter)
    {
        static::$delimiter = (string) $delimiter;
    }

    public static function getDelimiter()
    {
        return static::$delimiter;
    }
}
