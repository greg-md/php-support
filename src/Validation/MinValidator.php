<?php

namespace Greg\Support\Validation;

class MinValidator implements ValidatorStrategy
{
    protected $min = null;

    public function __construct($min)
    {
        $this->setMin($min);

        return $this;
    }

    public function validate($value, array $values = [])
    {
        $min = $this->getMin();

        if ($value < $min) {
            return ['MinError' => 'Value should be grater or equal with ' . $min . '.'];
        }

        return [];
    }

    public function setMin($length)
    {
        $this->min = (int) $length;

        return $this;
    }

    public function getMin()
    {
        return $this->min;
    }
}
