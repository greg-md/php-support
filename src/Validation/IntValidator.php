<?php

namespace Greg\Support\Validation;

class IntValidator implements ValidatorStrategy
{
    protected $unsigned = false;

    public function __construct($unsigned = null)
    {
        if ($unsigned !== null) {
            $this->unsigned($unsigned);
        }

        return $this;
    }

    public function validate($value, array $values = [])
    {
        if (!is_numeric($value) or $value != (int) $value) {
            return ['IntError' => 'Value is not integer.'];
        }

        if ($this->isUnsigned() and $value < 0) {
            return ['IntUnsignedError' => 'Value is not unsigned.'];
        }

        return [];
    }

    public function unsigned($value = true)
    {
        $this->unsigned = (bool) $value;

        return $this;
    }

    public function isUnsigned()
    {
        return $this->unsigned;
    }
}
