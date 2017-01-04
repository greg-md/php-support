<?php

namespace Greg\Support\Accessor;

trait IteratorAggregateTrait
{
    protected $iteratorClass = \ArrayIterator::class;

    public function getIterator()
    {
        return new $this->iteratorClass($this->getAccessor());
    }

    public function getIteratorClass()
    {
        return $this->iteratorClass;
    }

    public function setIteratorClass($name)
    {
        $this->iteratorClass = (string) $name;

        return $this;
    }

    abstract public function getAccessor();
}
