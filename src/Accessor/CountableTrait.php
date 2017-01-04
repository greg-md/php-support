<?php

namespace Greg\Support\Accessor;

trait CountableTrait
{
    public function count()
    {
        return count($this->getAccessor());
    }

    abstract public function &getAccessor();
}
