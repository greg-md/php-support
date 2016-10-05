<?php

namespace Greg\Support\Accessor;

trait SerializableTrait
{
    public function serialize()
    {
        return serialize($this->accessor);
    }

    public function unserialize($accessor)
    {
        $this->accessor = unserialize($accessor);

        return $this;
    }
}
