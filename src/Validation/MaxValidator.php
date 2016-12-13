<?php

namespace Greg\Support\Validation;

class MaxValidator implements ValidatorStrategy
{
    protected $max = null;

    public function __construct($max)
    {
        $this->setMax($max);

        return $this;
    }

    public function validate($value, array $values = [])
    {
        $max = $this->getMax();

        if ($value > $max) {
            return ['MaxError' => 'Value should be less or equal with ' . $max . '.'];
        }

        return [];
    }

    public function setMax($length)
    {
        $this->max = (int) $length;

        return $this;
    }

    public function getMax()
    {
        return $this->max;
    }
}
