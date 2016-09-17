<?php

namespace Greg\Support\Accessor;

trait IteratorAggregateTrait
{
    protected $iteratorClass = \ArrayIterator::class;

    public function getIterator()
    {
        if (!$this->iteratorClass) {
            throw new \Exception('Undefined iterator.');
        }

        return new $this->iteratorClass($this->accessor);
    }

    public function getIteratorClass()
    {
        return $this->iteratorClass;
    }

    public function setIteratorClass($name = null)
    {
        $this->iteratorClass = (string) $name;

        return $this;
    }
}
