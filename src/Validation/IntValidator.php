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
        if ($value != (int) $value) {
            return ['IntError' => 'Value is not integer.'];
        }

        if ($this->unsigned() and $value < 0) {
            return ['IntUnsignedError' => 'Value is not unsigned.'];
        }

        return [];
    }

    public function unsigned($value = null)
    {
        if (func_num_args()) {
            if (!is_bool($value)) {
                $value = ($value === 'unsigned');
            }

            $this->unsigned = (bool) $value;

            return $this;
        }

        return $this->unsigned;
    }
}
