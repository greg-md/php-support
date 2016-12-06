<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

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

        return static::$accessor;
    }

    protected static function inAccessor($key)
    {
        return array_key_exists($key, static::$accessor);
    }

    protected function getFromAccessor($key)
    {
        return static::inAccessor($key) ? static::$accessor[$key] : null;
    }

    protected function setToAccessor($key, $value)
    {
        Arr::set(static::$accessor, $key, $value);

        return static::$accessor;
    }

    protected function addToAccessor(array $items)
    {
        static::$accessor = array_merge(static::$accessor, $items);

        return static::$accessor;
    }

    private static function &accessor()
    {
        return static::$accessor;
    }
}
