<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait AccessorStaticTrait
{
    private static $accessor = [];

    private static function &getAccessor()
    {
        return static::$accessor;
    }

    private static function setAccessor(array $accessor)
    {
        static::$accessor = $accessor;

        return static::$accessor;
    }

    private static function inAccessor($key)
    {
        return array_key_exists($key, static::$accessor);
    }

    private static function getFromAccessor($key)
    {
        return static::inAccessor($key) ? static::$accessor[$key] : null;
    }

    private static function setToAccessor($key, $value)
    {
        Arr::set(static::$accessor, $key, $value);

        return static::$accessor;
    }

    private static function addToAccessor(array $items)
    {
        static::$accessor = array_merge(static::$accessor, $items);

        return static::$accessor;
    }

    private static function removeFromAccessor($key)
    {
        unset(static::$accessor[$key]);

        return static::$accessor;
    }

    private static function resetAccessor()
    {
        static::$accessor = [];

        return static::$accessor;
    }
}
