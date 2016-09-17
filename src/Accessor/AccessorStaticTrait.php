<?php

namespace Greg\Support\Accessor;

trait AccessorStaticTrait
{
    private static $accessor = [];

    protected static function getAccessor()
    {
        return static::$accessor;
    }

    protected static function setAccessor(array $accessor)
    {
        static::$accessor = $accessor;
    }

    protected static function inAccessor($key)
    {
        return array_key_exists($key, static::$accessor);
    }

    protected static function setToAccessor($key, $value)
    {
        static::$accessor[$key] = $value;
    }

    protected static function getFromAccessor($key)
    {
        return static::inAccessor($key) ? static::$accessor[$key] : null;
    }
}
