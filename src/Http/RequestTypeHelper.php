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
        return Arr::has($type, $key);
    }

    public static function hasIndexType(array &$type, $index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($type, $index, $delimiter);
    }

    public static function getType(array &$type, $key, $else = null)
    {
        return Arr::get($type, $key, $else);
    }

    public static function getArrayType(array &$type, $key, $else = null)
    {
        return Arr::getArray($type, $key, $else);
    }

    public static function getIndexType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($type, $index, $else, $delimiter);
    }

    public static function getIndexArrayType(array &$type, $index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($type, $index, $else, $delimiter);
    }
}
