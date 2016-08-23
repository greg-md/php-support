<?php

namespace Greg\Support\Storage;

trait SerializableTrait
{
    public function serialize()
    {
        return serialize($this->storage);
    }

    public function unserialize($storage)
    {
        $this->storage = unserialize($storage);

        return $this;
    }
}