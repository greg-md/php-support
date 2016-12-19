<?php

namespace Greg\Support;

class Arr
{
    const INDEX_DELIMITER = '.';

    public static function has(array &$array, $key)
    {
        if (is_array($key)) {
            foreach (($keys = $key) as $k) {
                if (!static::has($array, $k)) {
                    return false;
                }
            }

            return true;
        }

        return array_key_exists($key, $array);
    }

    public static function hasIndex(array &$array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            foreach (($indexes = $index) as $index) {
                if (!static::hasIndex($array, $index, $delimiter)) {
                    return false;
                }
            }

            return true;
        }

        if (strpos($index, $delimiter) === false) {
            return static::has($array, $index);
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

    public static function &set(array &$array, $key, $value)
    {
        if ($key === null or $key === '') {
            $array[] = $value;
        } else {
            $array[$key] = $value;
        }

        return $array;
    }

    public static function &setRef(array &$array, $key, &$value)
    {
        if ($key === null or $key === '') {
            $array[] = &$value;
        } else {
            $array[$key] = &$value;
        }

        return $array;
    }

    public static function setIndex(array &$array, $index, $value, $delimiter = self::INDEX_DELIMITER)
    {
        if (strpos($index, $delimiter) === false) {
            return static::set($array, $index, $value);
        }

        $parts = static::findLastIndex($array, $index, $delimiter);

        static::set($parts[0], $parts[1], $value);

        return $array;
    }

    public static function &setIndexRef(array &$array, $index, &$value, $delimiter = self::INDEX_DELIMITER)
    {
        if (strpos($index, $delimiter) === false) {
            return static::setRef($array, $index, $value);
        }

        $parts = static::findLastIndex($array, $index, $delimiter);

        static::setRef($parts[0], $parts[1], $value);

        return $array;
    }

    public static function get(array &$array, $key, $else = null)
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

                $return[is_int($kv) ? $kk : $kv] = $value;
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

                $return[is_int($kv) ? $kk : $kv] = $value;
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

    public static function getArray(array &$array, $key, $else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = static::getArray($array, $kk, $else[$kk]);
                } else {
                    $value = static::getArray($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = $value;
            }

            return $return;
        }

        if (array_key_exists($key, $array)) {
            return (array)$array[$key];
        }

        return (array)$else;
    }

    public static function &getArrayRef(array &$array, $key, &$else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = &static::getArrayRef($array, $kk, $else[$kk]);
                } else {
                    $value = &static::getArrayRef($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = &$value;
            }

            return $return;
        }

        if (array_key_exists($key, $array)) {
            $ref = &$array[$key];
        } else {
            $ref = &$else;
        }

        $ref = (array) $ref;

        return $ref;
    }

    public static function getArrayForce(array &$array, $key, $else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = static::getArrayForce($array, $kk, $else[$kk]);
                } else {
                    $value = static::getArrayForce($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = $value;
            }

            return $return;
        }

        if (!array_key_exists($key, $array)) {
            $array[$key] = $else;
        }

        $array[$key] = (array) $array[$key];

        return $array[$key];
    }

    public static function &getArrayForceRef(array &$array, $key, &$else = null)
    {
        if (is_array($key)) {
            $return = [];

            $else = (array) $else;

            foreach ($keys = $key as $kv => $kk) {
                if (array_key_exists($kk, $else)) {
                    $value = &static::getArrayForceRef($array, $kk, $else[$kk]);
                } else {
                    $value = &static::getArrayForceRef($array, $kk);
                }

                $return[is_int($kv) ? $kk : $kv] = &$value;
            }

            return $return;
        }

        if (!array_key_exists($key, $array)) {
            $array[$key] = &$else;
        }

        $array[$key] = (array) $array[$key];

        return $array[$key];
    }

    public static function getIndex(array &$array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (Arr::hasIndex($else, $ik)) {
                    $value = static::getIndex($array, $ik, static::getIndex($else, $ik), $delimiter);
                } else {
                    $value = static::getIndex($array, $ik, null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = $value;
            }

            $return = static::unpackIndexes($return, $delimiter);

            return $return;
        }

        if (strpos($index, $delimiter) === false) {
            return static::get($array, $index, $else);
        }

        return static::getIndexStrRef($array, $index, $else, $delimiter);
    }

    public static function &getIndexRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (Arr::hasIndex($else, $ik)) {
                    $value = &static::getIndexRef($array, $ik, static::getIndexRef($else, $ik), $delimiter);
                } else {
                    $newElse = null;

                    $value = &static::getIndexRef($array, $ik, $newElse, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            $return = static::unpackIndexesRef($return, $delimiter);

            return $return;
        }

        if (strpos($index, $delimiter) === false) {
            return static::getRef($array, $index, $else);
        }

        return static::getIndexStrRef($array, $index, $else, $delimiter);
    }

    public static function getIndexForce(array &$array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (Arr::hasIndex($else, $ik)) {
                    $value = static::getIndexForce($array, $ik, static::getIndexRef($else, $ik), $delimiter);
                } else {
                    $value = static::getIndexForce($array, $ik, null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = $value;
            }

            $return = static::unpackIndexes($return, $delimiter);

            return $return;
        }

        if (strpos($index, $delimiter) === false) {
            return static::getForce($array, $index, $else);
        }

        return static::getIndexStrForceRef($array, $index, $else, $delimiter);
    }

    public static function &getIndexForceRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (Arr::hasIndex($else, $ik)) {
                    $value = &static::getIndexForceRef($array, $ik, static::getIndexRef($else, $ik), $delimiter);
                } else {
                    $newElse = null;

                    $value = &static::getIndexForceRef($array, $ik, $newElse, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            $return = static::unpackIndexesRef($return, $delimiter);

            return $return;
        }

        if (strpos($index, $delimiter) === false) {
            return static::getForceRef($array, $index, $else);
        }

        return static::getIndexStrForceRef($array, $index, $else, $delimiter);
    }

    public static function getIndexArray(array &$array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (Arr::hasIndex($else, $ik)) {
                    $value = static::getIndex($array, $ik, static::getIndexRef($else, $ik), $delimiter);
                } else {
                    $value = static::getIndex($array, $ik, null, $delimiter);
                }

                $return[is_int($iv) ? $ik : $iv] = (array) $value;
            }

            $return = static::unpackIndexes($return, $delimiter);

            return $return;
        }

        if (strpos($index, $delimiter) === false) {
            return (array) static::get($array, $index, $else);
        }

        return (array) static::getIndexStrRef($array, $index, $else, $delimiter);
    }

    public static function &getIndexArrayRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            $return = [];

            $else = (array) $else;

            foreach ($indexes = $index as $iv => $ik) {
                if (Arr::hasIndex($else, $ik)) {
                    $value = &static::getIndexRef($array, $ik, static::getIndexRef($else, $ik), $delimiter);
                } else {
                    $newElse = null;

                    $value = &static::getIndexRef($array, $ik, $newElse, $delimiter);
                }

                $value = (array) $value;

                $return[is_int($iv) ? $ik : $iv] = &$value;
            }

            $return = static::unpackIndexesRef($return, $delimiter);

            return $return;
        }

        if (strpos($index, $delimiter) === false) {
            $ref = &static::getRef($array, $index, $else);
        } else {
            $ref = &static::getIndexStrRef($array, $index, $else, $delimiter);
        }

        $ref = (array) $ref;

        return $ref;
    }

    public static function getIndexArrayForce(array &$array, $index, $else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $ref = static::getIndexForce($array, $index, $else, $delimiter);

        $ref = (array) $ref;

        return $ref;
    }

    public static function &getIndexArrayForceRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $ref = &static::getIndexForceRef($array, $index, $else, $delimiter);

        $ref = (array) $ref;

        return $ref;
    }

    public static function del(array &$array, $key)
    {
        if (is_array($key)) {
            foreach (($keys = $key) as $k) {
                static::del($array, $k);
            }
        } else {
            unset($array[$key]);
        }

        return $array;
    }

    public static function &delIndex(array &$array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        if (is_array($index)) {
            foreach (($indexes = $index) as $index) {
                static::delIndex($array, $index, $delimiter);
            }
        } else {
            if (strpos($index, $delimiter) === false) {
                return static::del($array, $index);
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

    public static function suffix(array &$array, $suffix)
    {
        foreach ($array as &$value) {
            $value .= $suffix;
        }
        unset($value);

        return $array;
    }

    public static function prefix(array &$array, $prefix)
    {
        foreach ($array as &$value) {
            $value = $prefix . $value;
        }
        unset($value);

        return $array;
    }

    public static function append(array &$array, $value, ...$values)
    {
        return array_push($array, $value, ...$values);
    }

    public static function appendRef(array &$array, &$value, &...$values)
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

    public static function appendKey(array &$array, $key, $value = null)
    {
        return static::appendKeyRef($array, $key, $value);
    }

    public static function &appendKeyRef(array &$array, $key, &$value = null)
    {
        if ($key === null or $key === '') {
            $array[] = &$value;
        } else {
            unset($array[$key]);

            $array[$key] = &$value;
        }

        return $array;
    }

    public static function appendIndex(array &$array, $index, $value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::appendIndexRef($array, $index, $value, $delimiter);
    }

    public static function &appendIndexRef(array &$array, $index, &$value = null, $delimiter = self::INDEX_DELIMITER)
    {
        $indexes = explode($delimiter, $index);

        $lastIndex = array_pop($indexes);

        return static::appendKeyRef(static::getIndexArrayForceRef($array, implode($delimiter, $indexes)), $lastIndex, $value);
    }

    public static function prepend(array &$array, $value, ...$values)
    {
        return array_unshift($array, $value, ...$values);
    }

    public static function &prependRef(array &$array, &$value, &...$values)
    {
        array_unshift($values, null);

        $values[0] = &$value;

        foreach (array_reverse($values) as &$v) {
            static::prependKeyRef($array, null, $v);
        }
        unset($v);

        return $array;
    }

    public static function prependKey(array &$array, $key, $value = null)
    {
        return static::prependKeyRef($array, $key, $value);
    }

    public static function &prependKeyRef(array &$array, $key, &$value = null)
    {
        if ($key === null) {
            array_unshift($array, null);

            $array[0] = &$value;
        } else {
            $array = [$key => &$value] + $array;
        }

        return $array;
    }

    public static function prependIndex(array &$array, $index, $value = null, $delimiter = self::INDEX_DELIMITER)
    {
        return static::prependIndexRef($array, $index, $value, $delimiter);
    }

    public static function &prependIndexRef(array &$array, $index, &$value = null, $delimiter = self::INDEX_DELIMITER)
    {
        $indexes = explode($delimiter, $index);

        $lastIndex = array_pop($indexes);

        return static::prependKeyRef(static::getIndexArrayForceRef($array, implode($delimiter, $indexes)), $lastIndex, $value);
    }

    public static function first(array &$array, callable $callable = null, $else = null)
    {
        return static::firstRef($array, $callable, $else);
    }

    public static function &firstRef(array &$array, callable $callable = null, &$else = null)
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

    public static function last(array &$array, callable $callable = null, $else = null)
    {
        return static::lastRef($array, $callable, $else);
    }

    public static function &lastRef(array &$array, callable $callable = null, &$else = null)
    {
        if ($callable !== null) {
            $reversed = [];

            foreach ($array as $key => &$value) {
                $reversed[$key] = &$value;
            }

            $reversed = array_reverse($reversed);

            return static::firstRef($reversed, $callable, $else);
        }

        if ($array) {
            end($array);

            return $array[key($array)];
        }

        return $else;
    }

    public static function map(callable $callable, array &$array, array &...$arrays)
    {
        return array_map($callable, $array, ...$arrays);
    }

    public static function mapRecursive($until, callable $callable, array &$array, array &...$arrays)
    {
        $copy = $array;

        return static::_mapRecursive($until, $callable, $copy, ...$arrays);
    }

    public static function &_mapRecursive($until, callable $callable, array &$array, array &...$arrays)
    {
        $until = (int) $until;

        foreach ($array as $key => &$value) {
            $callArgs = [];

            $breakThis = false;

            if ($until and is_array($value)) {
                $lastValue = &$value;

                reset($lastValue);

                for ($k = 0; $k < $until; ++$k) {
                    $lastValue = &$lastValue[key($lastValue)];

                    if (!is_array($lastValue)) {
                        $breakThis = true;

                        break;
                    }
                }
            }

            if (!$breakThis and is_array($value)) {
                foreach ($arrays as &$arr) {
                    $callArgs[] = &$arr[$key];
                }
                unset($arr);

                static::_mapRecursive($until, $callable, $value, ...$callArgs);
            } else {
                $callArgs[] = $value;

                foreach ($arrays as &$arr) {
                    $callArgs[] = $arr[$key];
                }
                unset($arr);

                $value = call_user_func_array($callable, $callArgs);
            }
        }
        unset($value);

        return $array;
    }

    public static function filter(array &$array, callable $callable = null, $flag = 0)
    {
        return array_filter(...func_get_args());
    }

    public static function filterRecursive(array &$array, callable $callable = null, $flag = 0)
    {
        $args = func_get_args();

        $copy = array_shift($args);

        return static::_filterRecursive($copy, ...$args);
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

                    foreach ($array as $key => $value) {
                        if ($i > $maxLevel) {
                            break;
                        }

                        $current = &$current[$value];

                        if ($removeGroupedKey) {
                            unset($array[$key]);
                        }

                        ++$i;
                    }
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

    public static function inArrayValues(&$array, array $values, $strict = false)
    {
        foreach ($values as $value) {
            if (!in_array($value, $array, $strict)) {
                return false;
            }
        }

        return true;
    }

    public static function pairs(&$array, $key, $value)
    {
        return array_combine(array_column($array, $key), array_column($array, $value));
    }

    public static function isFilled(array &$array, ...$args)
    {
        return count(array_filter($array, ...$args)) == count($array);
    }

    public static function each(array &$array, callable $callable)
    {
        $new = [];

        foreach ($array as $key => &$value) {
            list($newValue, $newKey) = call_user_func_array($callable, [$value, $key]);

            static::setRef($new, $newKey, $newValue);
        }
        unset($value);

        return $new;
    }

    public static function count(&$array, callable $callable)
    {
        return count(array_filter($array, $callable));
    }

    public static function pack(array $array, $glue = null)
    {
        foreach ($array as $key => &$value) {
            $value = $key . $glue . $value;
        }
        unset($value);

        return $array;
    }

    public static function fixIndexes(array &$array, $delimiter = self::INDEX_DELIMITER)
    {
        $packed = static::packIndexes($array, $delimiter);

        return static::unpackIndexes($packed, $delimiter);
    }

    public static function packIndexes(array &$array, $delimiter = self::INDEX_DELIMITER)
    {
        $new = [];

        foreach ($array as $key => &$value) {
            if (is_array($value)) {
                foreach (static::packIndexes($value) as $k => $v) {
                    $new[$key . $delimiter . $k] = $v;
                }
            } else {
                $new[$key] = $value;
            }
        }

        return $new;
    }

    public static function unpackIndexes(array &$array, $delimiter = self::INDEX_DELIMITER)
    {
        $new = [];

        foreach ($array as $index => &$value) {
            $sub = static::unpackToIndexPath($new, $index, $delimiter);

            $sub[0][$sub[1]] = $value;
        }
        unset($value);

        return $new;
    }

    public static function unpackIndexesRef(array &$array, $delimiter = self::INDEX_DELIMITER)
    {
        $new = [];

        foreach ($array as $index => &$value) {
            $sub = static::unpackToIndexPath($new, $index, $delimiter);

            $sub[0][$sub[1]] = &$value;
        }
        unset($value);

        return $new;
    }

    protected static function unpackToIndexPath(&$array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        $sub = &$array;

        $indexes = explode($delimiter, $index);

        $lastKey = array_pop($indexes);

        foreach ($indexes as $k) {
            if ($k === null) {
                $sub = &$sub[];
            } else {
                if (is_array($sub) and static::has($sub, $k) and !is_array($sub[$k])) {
                    $sub[$k] = [];
                }

                $sub = &$sub[$k];
            }
        }

        return [&$sub, $lastKey];
    }

    protected static function findLastIndex(&$array, $index, $delimiter = self::INDEX_DELIMITER)
    {
        $lastArray = &$array;

        $indexes = explode($delimiter, $index);

        $lastKey = array_pop($indexes);

        foreach ($indexes as $index) {
            $lastArray = &$lastArray[$index];

            $lastArray = (array)$lastArray;
        }

        return [&$lastArray, &$lastKey];
    }

    protected static function &getIndexStrRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $myRef = &$array;

        foreach (explode($delimiter, $index) as $index) {
            if (!(is_array($myRef) and array_key_exists($index, $myRef))) {
                return $else;
            }

            $myRef = &$myRef[$index];
        }

        return $myRef;
    }

    protected static function &getIndexStrForceRef(array &$array, $index, &$else = null, $delimiter = self::INDEX_DELIMITER)
    {
        $myRef = &$array;

        $has = true;

        $keys = explode($delimiter, $index);

        $keysCount = count($keys);

        foreach ($keys as $k => $key) {
            if (!(is_array($myRef) and array_key_exists($key, $myRef))) {
                $has = false;
            }

            if (!$has && ($k + 1) === $keysCount) {
                $myRef[$key] = &$else;
            }

            $myRef = &$myRef[$key];
        }

        return $myRef;
    }

    protected static function _filterRecursive(array &$array, callable $callable = null, $flag = 0)
    {
        $args = func_get_args();

        array_shift($args);

        foreach ($array as &$value) {
            if (is_array($value)) {
                $value = static::_filterRecursive($value, ...$args);
            }
        }
        unset($value);

        return array_filter($array, ...$args);
    }
}
