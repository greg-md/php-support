<?php

namespace Greg\Support\Storage;

use Greg\Support\Arr;

trait ArrayAccessStaticTrait
{
    public static function has($key)
    {
        return Arr::hasRef(static::$storage, $key);
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef(static::$storage, $index, $delimiter);
    }

    public static function set($key, $value)
    {
        Arr::setRefValueRef(static::$storage, $key, $value);
    }

    public static function setValueRef($key, &$value)
    {
        Arr::setRefValueRef(static::$storage, $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef(static::$storage, $index, $value, $delimiter);
    }

    public static function setIndexValueRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef(static::$storage, $index, $value, $delimiter);
    }

    public static function get($key, $else = null)
    {
        return Arr::getRef(static::$storage, $key, $else);
    }

    public static function &getRef($key, $else = null)
    {
        return Arr::getRef(static::$storage, $key, $else);
    }

    public static function getForce($key, $else = null)
    {
        return Arr::getForceRef(static::$storage, $key, $else);
    }

    public static function &getForceRef($key, $else = null)
    {
        return Arr::getForceRef(static::$storage, $key, $else);
    }

    public static function getArray($key, $else = null)
    {
        return Arr::getArrayRef(static::$storage, $key, $else);
    }

    public static function &getArrayRef($key, $else = null)
    {
        return Arr::getArrayRef(static::$storage, $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForceRef(static::$storage, $key, $else);
    }

    public static function &getArrayForceRef($key, $else = null)
    {
        return Arr::getArrayForceRef(static::$storage, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$storage, $index, $else, $delimiter);
    }

    public static function &getIndexRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$storage, $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$storage, $index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$storage, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(static::$storage, $index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, $else = null)
    {
        return Arr::getIndexArrayRef(static::$storage, $index, $else);
    }

    public static function getIndexArrayForce($index, $else = null)
    {
        return Arr::getIndexArrayForceRef(static::$storage, $index, $else);
    }

    public static function &getIndexArrayForceRef($index, $else = null)
    {
        return Arr::getIndexArrayForceRef(static::$storage, $index, $else);
    }

    public static function required($key)
    {
        return Arr::requiredRef(static::$storage, $key);
    }

    public static function &requiredRef($key)
    {
        return Arr::requiredRef(static::$storage, $key);
    }

    public static function del($key)
    {
        Arr::delRef(static::$storage, $key);
    }

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::delIndexRef(static::$storage, $index, $delimiter);
    }
}
