<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait AccessorTrait
{
    private $accessor = [];

    protected function getAccessor()
    {
        return $this->accessor;
    }

    protected function setAccessor(array $accessor)
    {
        $this->accessor = $accessor;

        return $this;
    }

    protected function inAccessor($key)
    {
        return array_key_exists($key, $this->accessor);
    }

    protected function getFromAccessor($key)
    {
        return $this->inAccessor($key) ? $this->accessor[$key] : null;
    }

    protected function setToAccessor($key, $value)
    {
        Arr::setRefValueRef($this->accessor, $key, $value);

        return $this;
    }

    protected function addToAccessor(array $items)
    {
        $this->accessor = array_merge($this->accessor, $items);

        return $this;
    }

    protected function &accessor()
    {
        return $this->accessor;
    }
}
