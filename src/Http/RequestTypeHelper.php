<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;

class RequestTypeHelper
{
    public static function hasTypeParams(array &$type)
    {
        return (bool) $type;
    }

    public static function getAllType(array &$type)
    {
        return $type;
    }

    public static function hasType(array &$type, $key)
    {
        return Arr::hasRef($type, $key);
    }

    public static function hasIndexType(array &$type, $index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($type, $index, $delimiter);
    }

    public static function getType(array &$type, $key, $else = null)
    {
        return static::getTypeRef($type, $key, $else);
    }

    public static function &getTypeRef(array &$type, $key, &$else = null)
    {
        return Arr::getRef($type, $key, $else);
    }

    public static function getForceType(array &$type, $key, $else = null)
    {
        return static::getForceTypeRef($type, $key, $else);
    }

    public static function &getForceTypeRef(array &$type, $key, &$else = null)
    {
        return Arr::getForceRef($type, $key, $else);
    }

    public static function getArrayType(array &$type, $key, $else = null)
    {
        return static::getArrayTypeRef($type, $key, $else);
    }

    public static function &getArrayTypeRef(array &$type, $key, &$else = null)
    {
        return Arr::getArrayRef($type, $key, $else);
    }

    public static function getArrayForceType(array &$type, $key, $else = null)
    {
        return static::getArrayForceTypeRef($type, $key, $else);
    }

    public static function &getArrayForceTypeRef(array &$type, $key, &$else = null)
    {
        return Arr::getArrayForceRef($type, $key, $else);
    }

    public static function getIndexType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexTypeRef($type, $index, $else, $delimiter);
    }

    public static function &getIndexTypeRef(array &$type, $index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($type, $index, $else, $delimiter);
    }

    public static function getIndexForceType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceTypeRef($type, $index, $else, $delimiter);
    }

    public static function &getIndexForceTypeRef(array &$type, $index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($type, $index, $else, $delimiter);
    }

    public static function getIndexArrayType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayTypeRef($type, $index, $else, $delimiter);
    }

    public static function &getIndexArrayTypeRef(array &$type, $index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($type, $index, $else, $delimiter);
    }

    public static function getIndexArrayForceType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceTypeRef($type, $index, $else, $delimiter);
    }

    public static function &getIndexArrayForceTypeRef(array &$type, $index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($type, $index, $else, $delimiter);
    }
}
