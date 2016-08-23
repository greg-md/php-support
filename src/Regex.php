<?php

namespace Greg\Support;

use Greg\Support\Regex\InNamespaceRegex;

class Regex
{
    const PATTERN = '#';

    static public function inNamespace($start, $end, $recursive = true)
    {
        return new InNamespaceRegex($start, $end, $recursive);
    }

    static public function disableGroups($regex)
    {
        return preg_replace(static::pattern('(?<!\\\\)\((?!\?)'), '(?:', $regex);
    }

    static public function quote($string, $delimiter = self::PATTERN)
    {
        return preg_quote($string, $delimiter);
    }

    static public function pattern($regex, $flags = null)
    {
        return static::PATTERN . $regex . static::PATTERN . $flags;
    }
}