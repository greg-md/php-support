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
        return Arr::getRef($type, $key, $else);
    }

    public static function getArrayType(array &$type, $key, $else = null)
    {
        return Arr::getArrayRef($type, $key, $else);
    }

    public static function getIndexType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($type, $index, $else, $delimiter);
    }

    public static function getIndexArrayType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($type, $index, $else, $delimiter);
    }
}
