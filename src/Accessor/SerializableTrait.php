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
        $this->accessor = unserialize($storage);

        return $this;
    }
}
