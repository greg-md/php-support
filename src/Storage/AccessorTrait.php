<?php

namespace Greg\Support\Storage;

use Greg\Support\Arr;

trait AccessorTrait
{
    private $storage = [];

    protected function getStorage()
    {
        return $this->storage;
    }

    protected function setStorage(array $storage)
    {
        $this->storage = $storage;

        return $this;
    }

    protected function inStorage($key)
    {
        return array_key_exists($key, $this->storage);
    }

    protected function getFromStorage($key)
    {
        return $this->inStorage($key) ? $this->storage[$key] : null;
    }

    protected function setToStorage($key, $value)
    {
        Arr::setRefValueRef($this->storage, $key, $value);

        return $this;
    }

    protected function addToStorage(array $items)
    {
        $this->storage = array_merge($this->storage, $items);

        return $this;
    }
}
