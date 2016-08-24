<?php

namespace Greg\Support;

use Greg\Support\Regex\InNamespaceRegex;

class Regex
{
    static protected $pattern = '#';

    static public function inNamespace($start, $end, $recursive = true)
    {
        return new InNamespaceRegex($start, $end, $recursive);
    }

    static public function disableGroups($regex)
    {
        return preg_replace(static::pattern('(?<!\\\\)\((?!\?)'), '(?:', $regex);
    }

    static public function quote($string, $delimiter = null)
    {
        return preg_quote($string, $delimiter ?: static::$pattern);
    }

    static public function pattern($regex, $flags = null)
    {
        return static::$pattern . $regex . static::$pattern . $flags;
    }
}