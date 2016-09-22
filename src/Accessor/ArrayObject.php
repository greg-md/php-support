<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

class ArrayObject implements ArrayAccessInterface, \IteratorAggregate, \Serializable, \Countable
{
    use ArrayAccessTrait, IteratorAggregateTrait, SerializableTrait, CountableTrait;

    public function __construct($input = [], $iteratorClass = null)
    {
        $this->merge((array) $input);

        if ($iteratorClass !== null) {
            $this->setIteratorClass($iteratorClass);
        }

        return $this;
    }

    public function exchange($input)
    {
        return $this->exchangeRef($input);
    }

    public function exchangeRef(&$input)
    {
        $input = (array) $input;

        $this->accessor = &$input;

        return $this;
    }

    public function toArray()
    {
        return $this->accessor;
    }

    public function append($value = null, ...$values)
    {
        array_push($this->accessor, $value, ...$values);

        return $this;
    }

    public function appendRef(&$value = null, &...$values)
    {
        Arr::appendRefValueRef($this->accessor, $value, ...$values);

        return $this;
    }

    public function appendKey($key = null, $value = null)
    {
        Arr::appendKeyRefValueRef($this->accessor, $key, $value);

        return $this;
    }

    public function appendKeyRef($key = null, &$value = null)
    {
        Arr::appendKeyRefValueRef($this->accessor, $key, $value);

        return $this;
    }

    public function prepend($value = null, ...$values)
    {
        array_unshift($this->accessor, $value, ...$values);

        return $this;
    }

    public function prependRef(&$value, &...$values)
    {
        Arr::prependRefValueRef($this->accessor, $value, ...$values);

        return $this;
    }

    public function prependKey($key = null, $value = null)
    {
        Arr::prependKeyRefValueRef($this->accessor, $key, $value);

        return $this;
    }

    public function prependKeyRef($key = null, &$value = null)
    {
        Arr::prependKeyRefValueRef($this->accessor, $key, $value);

        return $this;
    }

    public function asort($flag = SORT_REGULAR)
    {
        asort($this->accessor, $flag);

        return $this;
    }

    public function ksort($flag = SORT_REGULAR)
    {
        ksort($this->accessor, $flag);

        return $this;
    }

    public function natcasesort()
    {
        natcasesort($this->accessor);

        return $this;
    }

    public function natsort()
    {
        natsort($this->accessor);

        return $this;
    }

    public function uasort($function)
    {
        uasort($this->accessor, $function);

        return $this;
    }

    public function uksort($function)
    {
        uksort($this->accessor, $function);

        return $this;
    }

    public function reset()
    {
        reset($this->accessor);

        return $this;
    }

    public function clear()
    {
        $this->accessor = [];

        return $this;
    }

    public function inArray($value, $strict = false)
    {
        return in_array($value, $this->accessor, $strict);
    }

    public function inArrayValues(array $values, $strict = false)
    {
        return Arr::inArrayValuesRef($this->accessor, $values, $strict);
    }

    public function merge(array $array, array ...$arrays)
    {
        $this->accessor = array_merge($this->accessor, $array, ...$arrays);

        return $this;
    }

    public function mergeRecursive(array $array, array ...$arrays)
    {
        $this->accessor = array_merge_recursive($this->accessor, $array, ...$arrays);

        return $this;
    }

    public function mergePrepend(array $array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->accessor;

        $this->accessor = array_merge(...$arrays);

        return $this;
    }

    public function mergePrependRecursive(array $array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->accessor;

        $this->accessor = array_merge_recursive(...$arrays);

        return $this;
    }

    public function mergeValues()
    {
        $this->accessor = array_merge(...$this->accessor);

        return $this;
    }

    public function replace($array, array ...$arrays)
    {
        $this->accessor = array_replace($this->accessor, $array, ...$arrays);

        return $this;
    }

    public function replaceRecursive($array, array ...$arrays)
    {
        $this->accessor = array_replace_recursive($this->accessor, $array, ...$arrays);

        return $this;
    }

    public function replacePrepend($array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->accessor;

        $this->accessor = array_replace(...$arrays);

        return $this;
    }

    public function replacePrependRecursive($array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->accessor;

        $this->accessor = array_replace_recursive(...$arrays);

        return $this;
    }

    public function replaceValues()
    {
        $this->accessor = array_replace(...$this->accessor);

        return $this;
    }

    public function diff($array, array ...$arrays)
    {
        $this->accessor = array_diff($this->accessor, $array, ...func_get_args());

        return $this;
    }

    public function map(callable $callable = null, array ...$arrays)
    {
        $this->accessor = array_map($callable, $this->accessor, ...$arrays);

        return $this;
    }

    public function mapRecursive(callable $callable = null, array ...$arrays)
    {
        Arr::mapRecursiveRef($callable, $this->accessor, ...$arrays);

        return $this;
    }

    public function filter(callable $callable = null, $flag = 0)
    {
        $this->accessor = array_filter($this->accessor, ...func_get_args());

        return $this;
    }

    public function filterRecursive(callable $callable = null, $flag = 0)
    {
        Arr::filterRecursiveRef($this->accessor, ...func_get_args());

        return $this;
    }

    public function reverse($preserveKeys = false)
    {
        $this->accessor = array_reverse($this->accessor, $preserveKeys);

        return $this;
    }

    public function chunk($size, $preserveKeys = false)
    {
        $this->accessor = array_chunk($this->accessor, $size, $preserveKeys);

        return $this;
    }

    public function implode($param = '')
    {
        return implode($param, $this->accessor);
    }

    public function join($param = '')
    {
        return $this->implode($param);
    }

    public function shift()
    {
        return array_shift($this->accessor);
    }

    public function pop()
    {
        return array_pop($this->accessor);
    }

    public function first()
    {
        reset($this->accessor);

        return current($this->accessor);
    }

    public function last()
    {
        return end($this->accessor);
    }

    public function current()
    {
        return key($this->accessor);
    }

    public function next()
    {
        return next($this->accessor);
    }

    public function group($maxLevel = 1, $replaceLast = true, $removeGroupedKey = false)
    {
        $this->accessor = Arr::group($this->accessor, $maxLevel, $replaceLast, $removeGroupedKey);

        return $this;
    }

    public function column($key, $indexKey = null)
    {
        return array_column($this->accessor, ...func_get_args());
    }

    public function walk(callable $callable, $data = null)
    {
        array_walk($this->accessor, $callable, $data);

        return $this;
    }

    public function shuffle()
    {
        shuffle($this->accessor);

        return $this;
    }

    public function sort($flags = SORT_REGULAR)
    {
        sort($this->accessor, $flags);

        return $this;
    }

    public function arsort($flags = SORT_REGULAR)
    {
        arsort($this->accessor, $flags);

        return $this;
    }

    public function krsort($flags = SORT_REGULAR)
    {
        krsort($this->accessor, $flags);

        return $this;
    }

    public function keys()
    {
        return array_keys($this->accessor);
    }

    public function values()
    {
        return array_values($this->accessor);
    }
}
