<?php

namespace Greg\Support\Validation;

class EnumValidator implements ValidatorStrategy
{
    protected $values = [];

    public function __construct(array $values)
    {
        $this->setValues($values);

        return $this;
    }

    public function validate($value, array $values = [])
    {
        if (!in_array($value, $this->getValues())) {
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
}
