<?php

namespace Greg\Support\Storage;

use Greg\Support\Arr;

class ArrayObject implements \ArrayAccess, \IteratorAggregate, \Serializable, \Countable
{
    use AccessorTrait, ArrayAccessTrait, IteratorAggregateTrait, SerializableTrait, CountableTrait;

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

        $this->storage = &$input;

        return $this;
    }

    public function toArray()
    {
        return $this->storage;
    }

    public function append($value = null, ...$values)
    {
        array_push($this->storage, $value, ...$values);

        return $this;
    }

    public function appendRef(&$value = null, &...$values)
    {
        Arr::appendRefValueRef($this->storage, $value, ...$values);

        return $this;
    }

    public function appendKey($key = null, $value = null)
    {
        Arr::appendKeyRefValueRef($this->storage, $key, $value);

        return $this;
    }

    public function appendKeyRef($key = null, &$value = null)
    {
        Arr::appendKeyRefValueRef($this->storage, $key, $value);

        return $this;
    }

    public function prepend($value = null, ...$values)
    {
        array_unshift($this->storage, $value, ...$values);

        return $this;
    }

    public function prependRef(&$value, &...$values)
    {
        Arr::prependRefValueRef($this->storage, $value, ...$values);

        return $this;
    }

    public function prependKey($key = null, $value = null)
    {
        Arr::prependKeyRefValueRef($this->storage, $key, $value);

        return $this;
    }

    public function prependKeyRef($key = null, &$value = null)
    {
        Arr::prependKeyRefValueRef($this->storage, $key, $value);

        return $this;
    }

    public function asort($flag = SORT_REGULAR)
    {
        asort($this->storage, $flag);

        return $this;
    }

    public function ksort($flag = SORT_REGULAR)
    {
        ksort($this->storage, $flag);

        return $this;
    }

    public function natcasesort()
    {
        natcasesort($this->storage);

        return $this;
    }

    public function natsort()
    {
        natsort($this->storage);

        return $this;
    }

    public function uasort($function)
    {
        uasort($this->storage, $function);

        return $this;
    }

    public function uksort($function)
    {
        uksort($this->storage, $function);

        return $this;
    }

    public function reset()
    {
        reset($this->storage);

        return $this;
    }

    public function clear()
    {
        $this->storage = [];

        return $this;
    }

    public function inArray($value, $strict = false)
    {
        return in_array($value, $this->storage, $strict);
    }

    public function inArrayValues(array $values, $strict = false)
    {
        return Arr::inArrayValuesRef($this->storage, $values, $strict);
    }

    public function merge(array $array, array ...$arrays)
    {
        $this->storage = array_merge($this->storage, $array, ...$arrays);

        return $this;
    }

    public function mergeRecursive(array $array, array ...$arrays)
    {
        $this->storage = array_merge_recursive($this->storage, $array, ...$arrays);

        return $this;
    }

    public function mergePrepend(array $array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->storage;

        $this->storage = array_merge(...$arrays);

        return $this;
    }

    public function mergePrependRecursive(array $array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->storage;

        $this->storage = array_merge_recursive(...$arrays);

        return $this;
    }

    public function mergeValues()
    {
        $this->storage = array_merge(...$this->storage);

        return $this;
    }

    public function replace($array, array ...$arrays)
    {
        $this->storage = array_replace($this->storage, $array, ...$arrays);

        return $this;
    }

    public function replaceRecursive($array, array ...$arrays)
    {
        $this->storage = array_replace_recursive($this->storage, $array, ...$arrays);

        return $this;
    }

    public function replacePrepend($array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->storage;

        $this->storage = array_replace(...$arrays);

        return $this;
    }

    public function replacePrependRecursive($array, array ...$arrays)
    {
        $arrays = array_reverse(func_get_args());

        $arrays[] = $this->storage;

        $this->storage = array_replace_recursive(...$arrays);

        return $this;
    }

    public function replaceValues()
    {
        $this->storage = array_replace(...$this->storage);

        return $this;
    }

    public function diff($array, array ...$arrays)
    {
        $this->storage = array_diff($this->storage, $array, ...func_get_args());

        return $this;
    }

    public function map(callable $callable = null, array ...$arrays)
    {
        $this->storage = array_map($callable, $this->storage, ...$arrays);

        return $this;
    }

    public function mapRecursive(callable $callable = null, array ...$arrays)
    {
        $this->storage = Arr::mapRecursive($callable, $this->storage, ...$arrays);

        return $this;
    }

    public function filter(callable $callable = null, $flag = 0)
    {
        $this->storage = array_filter($this->storage, ...func_get_args());

        return $this;
    }

    public function filterRecursive(callable $callable = null, $flag = 0)
    {
        $this->storage = Arr::filterRecursive($this->storage, ...func_get_args());

        return $this;
    }

    public function reverse($preserveKeys = false)
    {
        $this->storage = array_reverse($this->storage, $preserveKeys);

        return $this;
    }

    public function chunk($size, $preserveKeys = false)
    {
        $this->storage = array_chunk($this->storage, $size, $preserveKeys);

        return $this;
    }

    public function implode($param = '')
    {
        return implode($param, $this->storage);
    }

    public function join($param = '')
    {
        return $this->implode($param);
    }

    public function shift()
    {
        return array_shift($this->storage);
    }

    public function pop()
    {
        return array_pop($this->storage);
    }

    public function first()
    {
        reset($this->storage);

        return current($this->storage);
    }

    public function last()
    {
        return end($this->storage);
    }

    public function current()
    {
        return key($this->storage);
    }

    public function next()
    {
        return next($this->storage);
    }

    public function group($maxLevel = 1, $replaceLast = true, $removeGroupedKey = false)
    {
        $this->storage = Arr::group($this->storage, $maxLevel, $replaceLast, $removeGroupedKey);

        return $this;
    }

    public function column($key, $indexKey = null)
    {
        return array_column($this->storage, ...func_get_args());
    }

    public function walk(callable $callable, $data = null)
    {
        array_walk($this->storage, $callable, $data);

        return $this;
    }

    public function shuffle()
    {
        shuffle($this->storage);

        return $this;
    }

    public function sort($flags = SORT_REGULAR)
    {
        sort($this->storage, $flags);

        return $this;
    }

    public function arsort($flags = SORT_REGULAR)
    {
        arsort($this->storage, $flags);

        return $this;
    }

    public function krsort($flags = SORT_REGULAR)
    {
        krsort($this->storage, $flags);

        return $this;
    }

    public function keys()
    {
        return array_keys($this->storage);
    }

    public function values()
    {
        return array_values($this->storage);
    }
}
