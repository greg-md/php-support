<?php

namespace Greg\Support;

class IncludePath
{
    public static function append($path)
    {
        return static::add($path);
    }

    public static function prepend($path)
    {
        return static::add($path, true);
    }

    protected static function add($path, $prepend = false)
    {
        $path = (array) $path;

        $incPaths = explode(PATH_SEPARATOR, get_include_path());

        $path = array_values($path);

        $path = $prepend ? array_merge($path, $incPaths) : array_merge($incPaths, $path);

        $path = array_unique($path);

        $path = array_filter($path);

        return set_include_path(implode(PATH_SEPARATOR, $path));
    }

    public static function reset()
    {
        return set_include_path('.');
    }

    public static function exists($fileName)
    {
        return stream_resolve_include_path($fileName) !== false;
    }
}
