<?php

namespace Greg\Support\Accessor;

trait ArrayAccessTrait
{
    use AccessorTrait, ArrayAccessorTrait;

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
