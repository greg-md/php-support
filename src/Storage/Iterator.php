<?php

namespace Greg\Support\Storage;

class Iterator implements \Iterator
{
    private $storage = [];

    public function __construct(array &$storage = [])
    {
        $this->storage = $storage;
    }

    public function current()
    {
        return current($this->storage);
    }

    public function key()
    {
        return key($this->storage);
    }

    public function next()
    {
        return next($this->storage);
    }

    public function rewind()
    {
        return reset($this->storage);
    }

    public function valid()
    {
        return $this->key() !== null;
    }
}
