<?php

namespace Greg\Support\Storage;

use Greg\Support\Accessor\AccessorStaticTrait;
use Greg\Support\Arr;

trait ArrayAccessStaticTrait
{
    use AccessorStaticTrait;

    public static function has($key)
    {
        return Arr::hasRef(static::$accessor, $key);
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef(static::$accessor, $index, $delimiter);
    }

    public static function set($key, $value)
    {
        Arr::setRefValueRef(static::$accessor, $key, $value);
    }

    public static function setValueRef($key, &$value)
    {
        Arr::setRefValueRef(static::$accessor, $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef(static::$accessor, $index, $value, $delimiter);
    }

    public static function setIndexValueRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef(static::$accessor, $index, $value, $delimiter);
    }

    public static function get($key, $else = null)
    {
        return Arr::getRef(static::$accessor, $key, $else);
    }

    public static function &getRef($key, $else = null)
    {
        return Arr::getRef(static::$accessor, $key, $else);
    }

    public static function getForce($key, $else = null)
    {
        return Arr::getForceRef(static::$accessor, $key, $else);
    }

    public static function &getForceRef($key, $else = null)
    {
        return Arr::getForceRef(static::$accessor, $key, $else);
    }

    public static function getArray($key, $else = null)
    {
        return Arr::getArrayRef(static::$accessor, $key, $else);
    }

    public static function &getArrayRef($key, $else = null)
    {
        return Arr::getArrayRef(static::$accessor, $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForceRef(static::$accessor, $key, $else);
    }

    public static function &getArrayForceRef($key, $else = null)
    {
        return Arr::getArrayForceRef(static::$accessor, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, $else = null)
    {
        return Arr::getIndexArrayRef(static::$accessor, $index, $else);
    }

    public static function getIndexArrayForce($index, $else = null)
    {
        return Arr::getIndexArrayForceRef(static::$accessor, $index, $else);
    }

    public static function &getIndexArrayForceRef($index, $else = null)
    {
        return Arr::getIndexArrayForceRef(static::$accessor, $index, $else);
    }

    public static function del($key)
    {
        Arr::delRef(static::$accessor, $key);
    }

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::delIndexRef(static::$accessor, $index, $delimiter);
    }
}
