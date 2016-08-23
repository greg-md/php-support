<?php

namespace Greg\Support\Storage;

trait CountableTrait
{
    public function count()
    {
        return sizeof($this->storage);
    }
}