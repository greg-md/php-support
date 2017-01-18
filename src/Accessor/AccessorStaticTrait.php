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
        return static::$accessor = $accessor;
    }

    private static function inAccessor($key)
    {
        return Arr::has(static::$accessor, $key);
    }

    private static function getFromAccessor($key, $else = null)
    {
        return Arr::get(static::$accessor, $key, $else);
    }

    private static function setToAccessor($key, $value)
    {
        return Arr::set(static::$accessor, $key, $value);
    }

    private static function addToAccessor(array $values)
    {
        return static::$accessor = array_merge(static::$accessor, $values);
    }

    private static function removeFromAccessor($key)
    {
        unset(static::$accessor[$key]);

        return static::$accessor;
    }

    private static function resetAccessor()
    {
        return static::$accessor = [];
    }
}
