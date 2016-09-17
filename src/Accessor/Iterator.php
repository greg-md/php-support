<?php

namespace Greg\Support\Accessor;

class Iterator implements \Iterator
{
    private $accessor = [];

    public function __construct(array &$storage = [])
    {
        $this->accessor = $storage;
    }

    public function current()
    {
        return current($this->accessor);
    }

    public function key()
    {
        return key($this->accessor);
    }

    public function next()
    {
        return next($this->accessor);
    }

    public function rewind()
    {
        return reset($this->accessor);
    }

    public function valid()
    {
        return $this->key() !== null;
    }
}
