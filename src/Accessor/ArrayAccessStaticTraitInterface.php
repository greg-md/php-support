<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

interface ArrayAccessStaticTraitInterface
{
    public static function has($key);

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER);

    public static function set($key, $value);

    public static function setRef($key, &$value);

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER);

    public static function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER);

    public static function get($key, $else = null);

    public static function &getRef($key, &$else = null);

    public static function getForce($key, $else = null);

    public static function &getForceRef($key, &$else = null);

    public static function getArray($key, $else = null);

    public static function &getArrayRef($key, &$else = null);

    public static function getArrayForce($key, $else = null);

    public static function &getArrayForceRef($key, &$else = null);

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER);

    public static function del($key);

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER);
}
