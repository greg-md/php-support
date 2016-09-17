<?php

namespace Greg\Support\Accessor;

trait SerializableTrait
{
    public function serialize()
    {
        return serialize($this->accessor);
    }

    public function unserialize($storage)
    {
        $this->storage = unserialize($storage);

        return $this;
    }
}
