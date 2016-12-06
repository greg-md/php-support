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
        $this->accessor = $accessor;

        return $this;
    }

    private function inAccessor($key)
    {
        return array_key_exists($key, $this->accessor);
    }

    private function getFromAccessor($key)
    {
        return $this->inAccessor($key) ? $this->accessor[$key] : null;
    }

    private function setToAccessor($key, $value)
    {
        Arr::set($this->accessor, $key, $value);

        return $this;
    }

    private function addToAccessor(array $array)
    {
        $this->accessor = array_merge($this->accessor, $array);

        return $this;
    }

    private function removeFromAccessor($key)
    {
        unset($this->accessor[$key]);

        return $this;
    }

    private function clearAccessor()
    {
        $this->accessor = [];

        return $this;
    }
}
