<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait ArrayAccessTrait
{
    use AccessorTrait;

    public function has($key)
    {
        return Arr::has($this->accessor, $key);
    }

    public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($this->accessor, $index, $delimiter);
    }

    public function set($key, $value)
    {
        return Arr::set($this->accessor, $key, $value);
    }

    public function setRef($key, &$value)
    {
        return Arr::setRef($this->accessor, $key, $value);
    }

    public function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndex($this->accessor, $index, $value, $delimiter);
    }

    public function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRef($this->accessor, $index, $value, $delimiter);
    }

    public function get($key, $else = null)
    {
        return Arr::get($this->accessor, $key, $else);
    }

    public function &getRef($key, &$else = null)
    {
        return Arr::getRef($this->accessor, $key, $else);
    }

    public function getForce($key, $else = null)
    {
        return Arr::getForce($this->accessor, $key, $else);
    }

    public function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef($this->accessor, $key, $else);
    }

    public function getArray($key, $else = null)
    {
        return Arr::getArray($this->accessor, $key, $else);
    }

    public function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef($this->accessor, $key, $else);
    }

    public function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForce($this->accessor, $key, $else);
    }

    public function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($this->accessor, $key, $else);
    }

    public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($this->accessor, $index, $else, $delimiter);
    }

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($this->accessor, $index, $else, $delimiter);
    }

    public function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForce($this->accessor, $index, $else, $delimiter);
    }

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($this->accessor, $index, $else, $delimiter);
    }

    public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($this->accessor, $index, $else, $delimiter);
    }

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($this->accessor, $index, $else, $delimiter);
    }

    public function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForce($this->accessor, $index, $else, $delimiter);
    }

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($this->accessor, $index, $else, $delimiter);
    }

    public function del($key)
    {
        return Arr::del($this->accessor, $key);
    }

    public function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndex($this->accessor, $index, $delimiter);
    }

    /* Magic methods for ArrayAccess interface */

    public function offsetExists($key)
    {
        return $this->has($key);
    }

    public function offsetSet($key, $value)
    {
        return $this->set($key, $value);
    }

    public function &offsetGet($key)
    {
        return $this->accessor[$key];
    }

    public function offsetUnset($key)
    {
        return $this->del($key);
    }
}
