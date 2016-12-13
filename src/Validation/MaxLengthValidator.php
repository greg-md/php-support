<?php

namespace Greg\Support\Validation;

class MaxLengthValidator implements ValidatorStrategy
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

        if (mb_strlen($value) > $length) {
            return ['MaxLength' => 'Value length should be less or equal with ' . $length . '.'];
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
