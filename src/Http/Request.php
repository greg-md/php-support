<?php

namespace Greg\Support\Http;

use Greg\Support\Accessor\AccessorTrait;
use Greg\Support\Accessor\ArrayAccessTrait;
use Greg\Support\Arr;

class Request implements RequestInterface
{
    use RequestStaticTrait,
        AccessorTrait,
        ArrayAccessTrait;

    public function __construct(array $params = [])
    {
        $this->setAccessor($params);

        return $this;
    }

    public function hasParams()
    {
        return (bool) $this->accessor;
    }

    public function getAll()
    {
        return $this->accessor;
    }

    public function setAll(array $params)
    {
        $this->setAccessor($params);

        return $this;
    }

    public function &getRef($key, &$else = null)
    {
        return Arr::getRef($this->accessor, $key, $this->getRequestRef($key, $else));
    }

    public function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef($this->accessor, $key, $this->getForceRequestRef($key, $else));
    }

    public function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef($this->accessor, $key, $this->getArrayRequestRef($key, $else));
    }

    public function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($this->accessor, $key, $this->getArrayForceRequestRef($key, $else));
    }

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(
            $this->accessor,
            $index,
            $this->getIndexRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(
            $this->accessor,
            $index,
            $this->getIndexForceRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(
            $this->accessor,
            $index,
            $this->getIndexArrayRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef(
            $this->accessor,
            $index,
            $this->getIndexArrayForceRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function __call($method, array $args)
    {
        return $this->__callStatic($method, $args);
    }
}
