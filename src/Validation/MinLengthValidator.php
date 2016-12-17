<?php

namespace Greg\Support\Validation;

class MinLengthValidator implements ValidatorStrategy
{
    protected $length = null;

    public function __construct($length)
    {
        $this->setLength($length);

        return $this;
    }

    public function validate($value, array $values = [])
    {
        $length = $this->getLength();

        if (mb_strlen($value) < $length) {
            return ['MinLengthError' => 'Value length should be grater or equal with ' . $length . '.'];
        }

        return [];
    }

    public function setLength($length)
    {
        $this->length = (int) $length;

        return $this;
    }

    public function getLength()
    {
        return $this->length;
    }
}
