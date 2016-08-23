<?php

namespace Greg\Support\Storage;

use Greg\Support\Arr;

trait ArrayAccessStaticTrait
{
    static public function has($key)
    {
        return Arr::hasRef(static::$storage, $key);
    }

    static public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef(static::$storage, $index, $delimiter);
    }

    static public function set($key, $value)
    {
        Arr::setRefValueRef(static::$storage, $key, $value);
    }

    static public function setValueRef($key, &$value)
    {
        Arr::setRefValueRef(static::$storage, $key, $value);
    }

    static public function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef(static::$storage, $index, $value, $delimiter);
    }

    static public function setIndexValueRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef(static::$storage, $index, $value, $delimiter);
    }

    static public function get($key, $else = null)
    {
        return Arr::getRef(static::$storage, $key, $else);
    }

    static public function &getRef($key, $else = null)
    {
        return Arr::getRef(static::$storage, $key, $else);
    }

    static public function getForce($key, $else = null)
    {
        return Arr::getForceRef(static::$storage, $key, $else);
    }

    static public function &getForceRef($key, $else = null)
    {
        return Arr::getForceRef(static::$storage, $key, $else);
    }

    static public function getArray($key, $else = null)
    {
        return Arr::getArrayRef(static::$storage, $key, $else);
    }

    static public function &getArrayRef($key, $else = null)
    {
        return Arr::getArrayRef(static::$storage, $key, $else);
    }

    static public function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForceRef(static::$storage, $key, $else);
    }

    static public function &getArrayForceRef($key, $else = null)
    {
        return Arr::getArrayForceRef(static::$storage, $key, $else);
    }

    static public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$storage, $index, $else, $delimiter);
    }

    static public function &getIndexRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(static::$storage, $index, $else, $delimiter);
    }

    static public function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$storage, $index, $else, $delimiter);
    }

    static public function &getIndexForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(static::$storage, $index, $else, $delimiter);
    }

    static public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(static::$storage, $index, $else, $delimiter);
    }

    static public function &getIndexArrayRef($index, $else = null)
    {
        return Arr::getIndexArrayRef(static::$storage, $index, $else);
    }

    static public function getIndexArrayForce($index, $else = null)
    {
        return Arr::getIndexArrayForceRef(static::$storage, $index, $else);
    }

    static public function &getIndexArrayForceRef($index, $else = null)
    {
        return Arr::getIndexArrayForceRef(static::$storage, $index, $else);
    }

    static public function required($key)
    {
        return Arr::requiredRef(static::$storage, $key);
    }

    static public function &requiredRef($key)
    {
        return Arr::requiredRef(static::$storage, $key);
    }

    static public function del($key)
    {
        Arr::delRef(static::$storage, $key);
    }

    static public function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::delIndexRef(static::$storage, $index, $delimiter);
    }
}