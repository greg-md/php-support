<?php

namespace Greg\Support;

use Greg\Support\Regex\InNamespaceRegex;

class Regex
{
    protected static $pattern = '#';

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
        return preg_quote($string, $delimiter ?: static::$pattern);
    }

    public static function pattern($regex, $flags = null)
    {
        return static::$pattern.$regex.static::$pattern.$flags;
    }
}
