<?php

namespace Greg\Support\Validation;

class EnumValidator implements ValidatorStrategy
{
    protected $values = [];

    protected $strict = false;

    public function __construct(array $values, $strict = null)
    {
        $this->setValues($values);

        if ($strict !== null) {
            $this->strict($strict);
        }

        return $this;
    }

    public function validate($value, array $values = [])
    {
        if (!in_array($value, $this->getValues(), $this->isStrict())) {
            return ['EnumError' => 'Value is not found in the enum.'];
        }

        return [];
    }

    public function setValues(array $values)
    {
        $this->values = $values;

        return $this;
    }

    public function getValues()
    {
        return $this->values;
    }

    public function strict($value = true)
    {
        $this->strict = (bool) $value;

        return $this;
    }

    public function isStrict()
    {
        return $this->strict;
    }
}
