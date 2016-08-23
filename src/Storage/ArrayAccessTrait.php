<?php

namespace Greg\Support\Storage;

use Greg\Support\Arr;

trait ArrayAccessTrait
{
    public function has($key)
    {
        return Arr::hasRef($this->storage, $key);
    }

    public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($this->storage, $index, $delimiter);
    }

    public function set($key, $value)
    {
        return $this->setRef($key, $value);
    }

    public function setRef($key, &$value)
    {
        Arr::setRefValueRef($this->storage, $key, $value);

        return $this;
    }

    public function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return $this->setIndexRef($index, $value, $delimiter);
    }

    public function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::setIndexRefValueRef($this->storage, $index, $value, $delimiter);

        return $this;
    }

    public function get($key, $else = null)
    {
        return $this->getRef($key, $else);
    }

    public function &getRef($key, &$else = null)
    {
        return Arr::getRef($this->storage, $key, $else);
    }

    public function getForce($key, $else = null)
    {
        return $this->getForceRef($key, $else);
    }

    public function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef($this->storage, $key, $else);
    }

    public function getArray($key, $else = null)
    {
        return $this->getArrayRef($key, $else);
    }

    public function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef($this->storage, $key, $else);
    }

    public function getArrayForce($key, $else = null)
    {
        return $this->getArrayForceRef($key, $else);
    }

    public function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($this->storage, $key, $else);
    }

    public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return $this->getIndexRef($index, $else, $delimiter);
    }

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($this->storage, $index, $else, $delimiter);
    }

    public function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return $this->getIndexForceRef($index, $else, $delimiter);
    }

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($this->storage, $index, $else, $delimiter);
    }

    public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return $this->getIndexArrayRef($index, $else, $delimiter);
    }

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($this->storage, $index, $else, $delimiter);
    }

    public function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return $this->getIndexArrayForceRef($index, $else, $delimiter);
    }

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($this->storage, $index, $else, $delimiter);
    }

    public function del($key)
    {
        Arr::delRef($this->storage, $key);

        return $this;
    }

    public function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        Arr::delIndexRef($this->storage, $index, $delimiter);

        return $this;
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

    /**
     * Leave this alone! It should return direct reference of accessor to be able to add recursive values.
     * It may return a warning of undefined key.
     * Bug: It will create new empty key in array if it does not exists.
     * Fix: I think this will not be a problem. You can use "has" method instead of getting by undefined keys.
     *
     * @param $key
     * @return array|null
     */
    public function &offsetGet($key)
    {
        return $this->storage[$key];
        //return $this->getRef($key);
    }

    public function offsetUnset($key)
    {
        return $this->del($key);
    }
}