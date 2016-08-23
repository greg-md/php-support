<?php

namespace Greg\Support;

class IncludePath
{
    const APPEND_PATH = 'append';

    const PREPEND_PATH = 'prepend';

    static public function append($path)
    {
        return static::add($path, static::APPEND_PATH);
    }

    static public function prepend($path)
    {
        return static::add($path, static::PREPEND_PATH);
    }

    static public function add($path, $type = self::APPEND_PATH)
    {
        $path = (array)$path;

        $incPaths = explode(PATH_SEPARATOR, get_include_path());

        $path = array_values($path);

        $path = $type == static::APPEND_PATH ? array_merge($incPaths, $path) : array_merge($path, $incPaths);

        $path = array_unique($path);

        $path = array_filter($path);

        return set_include_path(implode(PATH_SEPARATOR, $path));
    }

    static public function reset()
    {
        return set_include_path('.');
    }

    static public function fileExists($file)
    {
        return stream_resolve_include_path($file) !== false;
    }
}