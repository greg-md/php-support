<?php

namespace Greg\Support\Storage;

trait CountableTrait
{
    public function count()
    {
        return count($this->storage);
    }
}
