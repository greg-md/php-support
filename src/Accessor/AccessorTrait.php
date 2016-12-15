<?php

namespace Greg\Support\Accessor;

use Greg\Support\Arr;

trait AccessorTrait
{
    private $accessor = [];

    private function &getAccessor()
    {
        return $this->accessor;
    }

    private function setAccessor(array $accessor)
    {
        return $this->accessor = $accessor;
    }

    private function inAccessor($key)
    {
        return Arr::has($this->accessor, $key);
    }

    private function getFromAccessor($key, $else = null)
    {
        return Arr::get($this->accessor, $key, $else);
    }

    private function setToAccessor($key, $value)
    {
        return Arr::set($this->accessor, $key, $value);
    }

    private function addToAccessor(array $data)
    {
        return $this->accessor = array_merge($this->accessor, $data);
    }

    private function removeFromAccessor($key)
    {
        unset($this->accessor[$key]);

        return $this->accessor;
    }

    private function resetAccessor()
    {
        return $this->accessor = [];
    }
}
