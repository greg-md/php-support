<?php

namespace Greg\Support\Accessor;

trait SerializableTrait
{
    public function serialize()
    {
        return serialize($this->getAccessor());
    }

    public function unserialize($accessor)
    {
        $this->setAccessor(unserialize($accessor));

        return $this;
    }

    abstract function &getAccessor();

    abstract function setAccessor(array $accessor);
}
