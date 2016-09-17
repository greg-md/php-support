<?php

namespace Greg\Support;

class Arr
{
    const INDEX_DELIMITER = '.';

    public static function has(array $array, $key)
    {
        return static::hasRef($array, $key);
    }

    public static function hasRef(array &$array, $key)
    {
        if (is_array($key)) {
            foreach (($keys = $key) as $k) {
                if (!static::hasRef($array, $k)) {
                    return false;
                }
            }

            return true;
        }

        return array_key_exists($key, $array);
    }

    public static function hasIndex(array $array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        return static::hasIndexRef($array, $index, $delimiter);
    }

    public static function hasIndexRef(array &$array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            foreach (($indexes = $index) as $index) {
                if (!static::hasIndexRef($array, $index, $delimiter)) {
                    return false;
                }
            }

            return true;
        }

        if (strpos($index, $delimiter) === false) {
            return static::hasRef($array, $index);
        }

        $myRef = &$array;

        foreach (explode($delimiter, $index) as $index) {
            if (!(is_array($myRef) and array_key_exists($index, $myRef))) {
                return false;
            }

            $myRef = &$myRef[$index];
        }

        return true;
    }

    public static function set(array $array, $key, $value)
    {
        return static::setRefValueRef($array, $key, $value);
    }

    public static function &setRef(array &$array, $key, $value)
    {
        return static::setRefValueRef($array, $key, $value);
    }

    public static function setValueRef(array $array, $key, &$value)
    {
        return static::setRefValueRef($array, $key, $value);
    }

    public static function &setRefValueRef(array &$array, $key, &$value)
    {
        if ($key === null or $key === '') {
            $array[] = &$value;
        } else {
            $array[$key] = &$value;
        }

        return $array;
    }

    public static function setIndex(array $array, $index, $value, $delimiter = self::INDEX_DELIMITER)
    {
        return static::setIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function &setIndexRef(array &$array, $index, $value, $delimiter = self::INDEX_DELIMITER)
    {
        return static::setIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function setIndexValueRef(array $array, $index, &$value, $delimiter = self::INDEX_DELIMITER)
    {
        return static::setIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function &setIndexRefValueRef(array &$array, $index, &$value, $delimiter = self::INDEX_DELIMITER)
    {
        if (strpos($index, $delimiter) === false) {
            return static::setRefValueRef($array, $index, $value);
        }

        $myRef = &$array;

        $indexes = explode($delimiter, $index);

        $lastIndex = array_pop($indexes);

        foreach ($indexes as $index) {
            $myRef = &$myRef[$index];

            $myRef = (array) $myRef;
        }

        static::setRefValueRef($myRef, $lastIndex, $value);

        return $array;
    }

    public static function get(array $array, $key, $else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = static::get($array, $kk, $else[$kk]);
                } else {
                    $value = static::get($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = &$value;
            }

            return $return;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $else;
    }

    public static function &getRef(array &$array, $key, &$else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = &static::getRef($array, $kk, $else[$kk]);
                } else {
                    $value = &static::getRef($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = &$value;
            }

            return $return;
        }

        if (array_key_exists($key, $array)) {
            return $array[$key];
        }

        return $else;
    }

    public static function getForce(array &$array, $key, $else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = static::getForce($array, $kk, $else[$kk]);
                } else {
                    $value = static::getForce($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = &$value;
            }

            return $return;
        }

        if (!array_key_exists($key, $array)) {
            $array[$key] = $else;
        }

        return $array[$key];
    }

    public static function &getForceRef(array &$array, $key, &$else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = &static::getForceRef($array, $kk, $else[$kk]);
                } else {
                    $value = &static::getForceRef($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = &$value;
            }

            return $return;
        }

        if (!array_key_exists($key, $array)) {
            $array[$key] = &$else;
        }

        return $array[$key];
    }

    public static function getArray(array $array, $key, $else = null)
    {
        $ref = static::getRef($array, $key, $else);

        $ref = (array) $ref;

        return $ref;
    }

    public static function &getArrayRef(array &$array, $key, &$else = null)
    {
        $ref = &static::getRef($array, $key, $else);

        $ref = (array) $ref;

        return $ref;
    }

    public static function getArrayForce(array &$array, $key, $else = null)
    {
        $ref = static::getForceRef($array, $key, $else);

        $ref = (array) $ref;

        return $ref;
    }

    public static function &getArrayForceRef(array &$array, $key, &$else = null)
    {
        $ref = &static::getForceRef($array, $key, $else);

        $ref = (array) $ref;

        return $ref;
    }

    public static function getIndex(array $array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (array_key_exists($ik, $else)) {
                    $value = static::getIndex($array, $ik, $else[$ik], $delimiter);
                } else {
                    $value = static::getIndex($array, $ik, $newElse = null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            return $return;
        }

        return static::getIndexStrRef($array, $index, $else, $delimiter);
    }

    public static function &getIndexRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (array_key_exists($ik, $else)) {
                    $value = &static::getIndexRef($array, $ik, $else[$ik], $delimiter);
                } else {
                    $value = &static::getIndexRef($array, $ik, $newElse = null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            return $return;
        }

        return static::getIndexStrRef($array, $index, $else, $delimiter);
    }

    protected static function &getIndexStrRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (strpos($index, $delimiter) === false) {
            return static::getRef($array, $index, $else);
        }

        $myRef = &$array;

        foreach (explode($delimiter, $index) as $index) {
            if (!(is_array($myRef) and array_key_exists($index, $myRef))) {
                return $else;
            }

            $myRef = &$myRef[$index];
        }

        return $myRef;
    }

    public static function getIndexForce(array &$array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (array_key_exists($ik, $else)) {
                    $value = static::getIndexForce($array, $ik, $else[$ik], $delimiter);
                } else {
                    $value = static::getIndexForce($array, $ik, $newElse = null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            return $return;
        }

        return static::getIndexStrForceRef($array, $index, $else, $delimiter);
    }

    public static function &getIndexForceRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (array_key_exists($ik, $else)) {
                    $value = &static::getIndexForceRef($array, $ik, $else[$ik], $delimiter);
                } else {
                    $value = &static::getIndexForceRef($array, $ik, $newElse = null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            return $return;
        }

        return static::getIndexStrForceRef($array, $index, $else, $delimiter);
    }

    protected static function &getIndexStrForceRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (strpos($index, $delimiter) === false) {
            return static::getForceRef($array, $index, $else);
        }

        $myRef = &$array;

        $has = true;

        foreach (explode($delimiter, $index) as $index) {
            if (!(is_array($myRef) and array_key_exists($index, $myRef))) {
                $has = false;
            }

            $myRef = &$myRef[$index];
        }

        if (!$has) {
            $myRef = &$else;
        }

        return $myRef;
    }

    public static function getIndexArray(array $array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $ref = static::getIndexRef($array, $index, $else, $delimiter);

        $ref = (array) $ref;

        return $ref;
    }

    public static function &getIndexArrayRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $ref = &static::getIndexRef($array, $index, $else, $delimiter);

        $ref = (array) $ref;

        return $ref;
    }

    public static function getIndexArrayForce(array &$array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $ref = static::getIndexForceRef($array, $index, $else, $delimiter);

        $ref = (array) $ref;

        return $ref;
    }

    public static function &getIndexArrayForceRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $ref = &static::getIndexForceRef($array, $index, $else, $delimiter);

        $ref = (array) $ref;

        return $ref;
    }

    public static function del(array $array, $key)
    {
        return static::delRef($array, $key);
    }

    public static function &delRef(array &$array, $key)
    {
        if (is_array($key)) {
            foreach (($keys = $key) as $k) {
                static::delRef($array, $k);
            }
        } else {
            unset($array[$key]);
        }

        return $array;
    }

    public static function delIndex(array $array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        return static::delIndexRef($array, $index, $delimiter);
    }

    public static function &delIndexRef(array &$array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            foreach (($indexes = $index) as $index) {
                static::delIndexRef($array, $index, $delimiter);
            }
        } else {
            if (strpos($index, $delimiter) === false) {
                return static::delRef($array, $index);
            }

            $indexes = explode($delimiter, $index);

            $lastIndex = array_pop($indexes);

            $myRef = &$array;

            foreach ($indexes as $index) {
                $myRef = &$myRef[$index];

                if (!is_array($myRef)) {
                    break;
                }
            }

            if (is_array($myRef)) {
                unset($myRef[$lastIndex]);
            }
        }

        return $array;
    }

    public static function suffix(array $array, $suffix)
    {
        return static::suffixRef($array, $suffix);
    }

    public static function &suffixRef(array &$array, $suffix)
    {
        foreach ($array as &$value) {
            $value .= $suffix;
        }
        unset($value);

        return $array;
    }

    public static function prefix(array $array, $prefix)
    {
        return static::prefixRef($array, $prefix);
    }

    public static function &prefixRef(array &$array, $prefix)
    {
        foreach ($array as &$value) {
            $value = $prefix . $value;
        }
        unset($value);

        return $array;
    }

    public static function appendValueRef(array $array, &$value = null, &...$values)
    {
        return static::appendRefValueRef($array, $value, ...$values);
    }

    public static function &appendRefValueRef(array &$array, &$value = null, &...$values)
    {
        $array[] = &$value;

        if ($values) {
            foreach ($values as &$v) {
                $array[] = &$v;
            }
            unset($v);
        }

        return $array;
    }

    public static function appendKey(array $array, $key = null, $value = null)
    {
        return static::appendKeyRefValueRef($array, $key, $value);
    }

    public static function &appendKeyRef(array &$array, $key = null, $value = null)
    {
        return static::appendKeyRefValueRef($array, $key, $value);
    }

    public static function appendKeyValueRef(array $array, $key = null, &$value = null)
    {
        return static::appendKeyRefValueRef($array, $key, $value);
    }

    public static function &appendKeyRefValueRef(array &$array, $key = null, &$value = null)
    {
        if ($key === null or $key === '') {
            $array[] = &$value;
        } else {
            unset($array[$key]);

            $array[$key] = &$value;
        }

        return true;
    }

    public static function appendIndex(array $array, $index = null, $value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::appendIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function &appendIndexRef(array &$array, $index = null, $value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::appendIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function appendIndexValueRef(array $array, $index = null, &$value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::appendIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function &appendIndexRefValueRef(array &$array, $index = null, &$value = null, $delimiter = self::INDEX_DELIMITER)
    {
        $indexes = explode($delimiter, $index);

        $lastIndex = array_pop($indexes);

        return static::appendKeyRefValueRef(static::getIndexArrayForceRef($array, implode($delimiter, $indexes)), $lastIndex, $value);
    }

    public static function prependValueRef(array $array, &$value = null, &...$values)
    {
        return static::prependRefValueRef($array, $value, ...$values);
    }

    public static function &prependRefValueRef(array &$array, &$value = null, &...$values)
    {
        static::prependKeyRefValueRef($array, null, $value);

        if ($values) {
            foreach ($values as &$v) {
                static::prependKeyRefValueRef($array, null, $v);
            }
            unset($v);
        }

        return $array;
    }

    public static function prependKey(array $array, $key = null, $value = null)
    {
        return static::prependKeyRefValueRef($array, $key, $value);
    }

    public static function &prependKeyRef(array &$array, $key = null, $value = null)
    {
        return static::prependKeyRefValueRef($array, $key, $value);
    }

    public static function prependKeyValueRef(array $array, $key = null, &$value = null)
    {
        return static::prependKeyRefValueRef($array, $key, $value);
    }

    public static function &prependKeyRefValueRef(array &$array, $key = null, &$value = null)
    {
        if ($key === null) {
            array_unshift($array, null);

            $array[0] = &$value;
        } else {
            $array = [$key => &$value] + $array;
        }

        return true;
    }

    public static function prependIndex(array $array, $index = null, $value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::prependIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function &prependIndexRef(array &$array, $index = null, $value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::prependIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function prependIndexValueRef(array $array, $index = null, &$value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::prependIndexRefValueRef($array, $index, $value, $delimiter);
    }

    public static function &prependIndexRefValueRef(array &$array, $index = null, &$value = null, $delimiter = self::INDEX_DELIMITER)
    {
        $indexes = explode($delimiter, $index);

        $lastIndex = array_pop($indexes);

        return static::prependKeyRefValueRef(static::getIndexArrayForceRef($array, implode($delimiter, $indexes)), $lastIndex, $value);
    }

    public static function first(array $array, callable $callable = null, $else = null)
    {
        return static::firstRef($array, $callable, $else);
    }

    public static function &firstRef(array &$array, callable $callable = null, $else = null)
    {
        if ($callable !== null) {
            foreach ($array as $key => &$value) {
                if (call_user_func_array($callable, [$value, $key])) {
                    return $value;
                }
            }
            unset($value);

            return $else;
        }

        if ($array) {
            reset($array);

            return $array[key($array)];
        }

        return $else;
    }

    public static function last(array $array, callable $callable = null, $else = null)
    {
        return static::lastRef($array, $callable, $else);
    }

    public static function &lastRef(array &$array, callable $callable = null, $else = null)
    {
        if ($callable !== null) {
            return static::first($reverse = array_reverse($array), $callable, $else);
        }

        if ($array) {
            end($array);

            return $array[key($array)];
        }

        return $else;
    }

    public static function mapRecursive(callable $callable, array $array, array ...$arrays)
    {
        return static::mapRecursiveRef($callable, $array, $arrays);
    }

    public static function mapRecursiveRef(callable $callable, array &$array, array &...$arrays)
    {
        foreach ($array as $key => &$value) {
            $callArgs = [];

            foreach ($arrays as &$arr) {
                $callArgs[] = &$arr[$key];
            }
            unset($arr);

            if (is_array($value)) {
                static::mapRecursiveRef($callable, $value, ...$callArgs);
            } else {
                array_unshift($callArgs, $value);

                $value = call_user_func_array($callable, [$callArgs]);
            }
        }
        unset($value);

        return $array;
    }

    public static function filterRecursive(array $array, ...$args)
    {
        return static::filterRecursiveRef($array, $args);
    }

    public static function &filterRecursiveRef(array &$array, ...$args)
    {
        foreach ($array as &$value) {
            if (is_array($value)) {
                static::filterRecursiveRef($value, ...$args);
            }
        }
        unset($value);

        $array = array_filter($array, ...$args);

        return $array;
    }

    public static function group(array $arrays, $maxLevel = 1, $replaceLast = true, $removeGroupedKey = false)
    {
        $grouped = [];

        foreach ($arrays as &$array) {
            if (($maxLevel instanceof \Closure)) {
                if ($replaceLast) {
                    $grouped[$maxLevel($array)] = $array;
                } else {
                    $grouped[$maxLevel($array)][] = $array;
                }
            } else {
                $current = &$grouped;

                if (is_numeric($maxLevel)) {
                    $i = 1;

                    foreach ($array as $key => &$value) {
                        if ($i > $maxLevel) {
                            break;
                        }

                        $current = &$current[$value];

                        if ($removeGroupedKey) {
                            unset($array[$key]);
                        }

                        ++$i;
                    }
                    unset($value);
                } else {
                    $maxLevel = (array) $maxLevel;

                    foreach ((array) $maxLevel as $level) {
                        $current = &$current[$array[$level]];

                        if ($removeGroupedKey) {
                            unset($array[$level]);
                        }
                    }
                }

                if ($replaceLast) {
                    $current = $array;
                } else {
                    $current[] = $array;
                }
            }
        }
        unset($array);

        return $grouped;
    }

    public static function inArrayValues($array, array $values, $strict = false)
    {
        return static::inArrayValuesRef($array, $values, $strict);
    }

    public static function inArrayValuesRef(&$array, array $values, $strict = false)
    {
        foreach ($values as $value) {
            if (!in_array($value, $array, $strict)) {
                return false;
            }
        }

        return true;
    }

    public static function pairs($array, $key, $value)
    {
        return array_combine(array_column($array, $key), array_column($array, $value));
    }

    public static function isFilled(array $array, ...$args)
    {
        return count(array_filter($array, ...$args)) == count($array);
    }

    public static function each(array $array, callable $callable)
    {
        $new = [];

        foreach ($array as $key => $value) {
            list($newValue, $newKey) = call_user_func_array($callable, [$value, $key]);

            static::setRefValueRef($new, $newKey, $newValue);
        }

        return $new;
    }

    public static function count($array, callable $callable)
    {
        return count(array_filter($array, $callable));
    }

    public static function pack(array $array, $glue = null, $saveKeys = false)
    {
        return static::packRef($array, $glue, $saveKeys);
    }

    public static function &packRef(array &$array, $glue = null, $saveKeys = false)
    {
        foreach ($array as $key => &$value) {
            $value = $key . $glue . $value;
        }

        if (!$saveKeys) {
            $array = array_values($array);
        }

        return $array;
    }

    public static function fixIndexes(array $array, $delimiter = self::INDEX_DELIMITER)
    {
        return static::unpackIndexes(static::packIndexes($array, $delimiter), $delimiter);
    }

    public static function packIndexes(array $array, $delimiter = self::INDEX_DELIMITER)
    {
        $new = [];

        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $value = static::packIndexes($value);

                foreach ($value as $k => $v) {
                    $new[$key . $delimiter . $k] = $v;
                }
            } else {
                $new[$key] = $value;
            }
        }

        return $new;
    }

    public static function unpackIndexes(array $array, $delimiter = self::INDEX_DELIMITER)
    {
        $new = [];

        foreach ($array as $key => $value) {
            $sub = &$new;

            foreach (explode($delimiter, $key) as $k) {
                if ($k === null) {
                    $sub = &$sub[];
                } else {
                    if (is_array($sub) and static::hasRef($sub, $k) and !is_array($sub[$k])) {
                        $sub[$k] = [];
                    }
                    $sub = &$sub[$k];
                }
            }

            $sub = $value;
        }

        return $new;
    }
}
