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
        return Arr::set(static::$accessor, $key, $value);
    }

    public static function setRef($key, &$value)
    {
        return Arr::setRef(static::$accessor, $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndex(static::$accessor, $index, $value, $delimiter);
    }

    public static function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRef(static::$accessor, $index, $value, $delimiter);
    }

    public static function get($key, $else = null)
    {
        return Arr::get(static::$accessor, $key, $else);
    }

    public static function &getRef($key, &$else = null)
    {
        return Arr::getRef(static::$accessor, $key, $else);
    }

    public static function getForce($key, $else = null)
    {
        return Arr::getForce(static::$accessor, $key, $else);
    }

    public static function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef(static::$accessor, $key, $else);
    }

    public static function getArray($key, $else = null)
    {
        return Arr::getArray(static::$accessor, $key, $else);
    }

    public static function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef(static::$accessor, $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForce(static::$accessor, $key, $else);
    }

    public static function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef(static::$accessor, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForce(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(static::$accessor, $index, $else, $delimiter);
    }

    public static function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForce(static::$accessor, $index, $else, $delimiter);
    }

    public static function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef(static::$accessor, $index, $else, $delimiter);
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
