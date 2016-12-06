<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait ArrayAccessStaticTrait
{
    use AccessorStaticTrait;

    public static function has($key)
    {
        return Arr::has(static::$accessor, $key);
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex(static::$accessor, $index, $delimiter);
    }

    public static function set($key, $value)
    {
        return static::setRef($key, $value);
    }

    public static function setRef($key, &$value)
    {
        return Arr::setRef(static::$accessor, $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexRef($index, $value, $delimiter);
    }

    public static function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRef(static::$accessor, $index, $value, $delimiter);
    }

    public static function get($key, $else = null)
    {
        return static::getRef($key, $else);
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
        return static::getArrayRef($key, $else);
    }

    public static function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef(static::$accessor, $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        return static::getArrayForceRef($key, $else);
    }

    public static function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef(static::$accessor, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexRef($index, $else, $delimiter);
    }

    public static function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceRef($index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, &$else = null)
    {
        return Arr::getIndexArrayRef(static::$accessor, $index, $else);
    }

    public static function getIndexArrayForce($index, $else = null)
    {
        return static::getIndexArrayForceRef($index, $else);
    }

    public static function &getIndexArrayForceRef($index, &$else = null)
    {
        return Arr::getIndexArrayForceRef(static::$accessor, $index, $else);
    }

    public static function del($key)
    {
        return Arr::del(static::$accessor, $key);
    }

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndex(static::$accessor, $index, $delimiter);
    }
}
