<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait ArrayAccessorTrait
{
    abstract public function &getAccessor();

    public function has($key)
    {
        return Arr::has($this->getAccessor(), $key);
    }

    public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($this->getAccessor(), $index, $delimiter);
    }

    public function set($key, $value)
    {
        return Arr::set($this->getAccessor(), $key, $value);
    }

    public function setRef($key, &$value)
    {
        return Arr::setRef($this->getAccessor(), $key, $value);
    }

    public function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndex($this->getAccessor(), $index, $value, $delimiter);
    }

    public function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRef($this->getAccessor(), $index, $value, $delimiter);
    }

    public function get($key, $else = null)
    {
        return Arr::get($this->getAccessor(), $key, $else);
    }

    public function &getRef($key, &$else = null)
    {
        return Arr::getRef($this->getAccessor(), $key, $else);
    }

    public function getForce($key, $else = null)
    {
        return Arr::getForce($this->getAccessor(), $key, $else);
    }

    public function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef($this->getAccessor(), $key, $else);
    }

    public function getArray($key, $else = null)
    {
        return Arr::getArray($this->getAccessor(), $key, $else);
    }

    public function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef($this->getAccessor(), $key, $else);
    }

    public function getArrayForce($key, $else = null)
    {
        return Arr::getArrayForce($this->getAccessor(), $key, $else);
    }

    public function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($this->getAccessor(), $key, $else);
    }

    public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($this->getAccessor(), $index, $else, $delimiter);
    }

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($this->getAccessor(), $index, $else, $delimiter);
    }

    public function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForce($this->getAccessor(), $index, $else, $delimiter);
    }

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($this->getAccessor(), $index, $else, $delimiter);
    }

    public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($this->getAccessor(), $index, $else, $delimiter);
    }

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($this->getAccessor(), $index, $else, $delimiter);
    }

    public function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForce($this->getAccessor(), $index, $else, $delimiter);
    }

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($this->getAccessor(), $index, $else, $delimiter);
    }

    public function remove($key)
    {
        return Arr::remove($this->getAccessor(), $key);
    }

    public function removeIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::removeIndex($this->getAccessor(), $index, $delimiter);
    }
}
