<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait ArrayAccessorStaticTrait
{
    abstract public function &getAccessor();

    public static function has($key)
    {
        return Arr::has(static::getAccessor(), $key);
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex(static::getAccessor(), $index, $delimiter);
    }

    public static function set($key, $value)
    {
        return Arr::set(static::getAccessor(), $key, $value);
    }

    public static function setRef($key, &$value)
    {
        return Arr::setRef(static::getAccessor(), $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndex(static::getAccessor(), $index, $value, $delimiter);
    }

    public static function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRef(static::getAccessor(), $index, $value, $delimiter);
    }

    public static function get($key, $else = null)
    {
        return Arr::get(static::getAccessor(), $key, $else);
    }

    public static function &getRef($key, &$else = null)
    {
        return Arr::getRef(static::getAccessor(), $key, $else);
    }

    public static function getForce($key, $else = null)
    {
        return Arr::getForce(static::getAccessor(), $key, $else);
    }

    public static function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef(static::getAccessor(), $key, $else);
    }

    public static function getArray($key, $else = null)
    {
        return Arr::getArray(static::getAccessor(), $key, $else);
    }

    public static function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef(static::getAccessor(), $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForce(static::getAccessor(), $key, $else);
    }

    public static function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef(static::getAccessor(), $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForce(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForce(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef(static::getAccessor(), $index, $else, $delimiter);
    }

    public static function del($key)
    {
        return Arr::del(static::getAccessor(), $key);
    }

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndex(static::getAccessor(), $index, $delimiter);
    }
}