<?php

namespace Greg\Support\Validation;

use Greg\Support\Arr;

class EqualValidator implements ValidatorStrategy
{
    protected $with = null;

    public function __construct($with)
    {
        $this->setWith($with);

        return $this;
    }

    public function validate($value, array $values = [])
    {
        if ($value !== Arr::get($values, $with = $this->getWith())) {
            return ['EqualError' => 'Value is not equal with `' . $with . '`.'];
        }

        return [];
    }

    public function setWith($value)
    {
        $this->with = $value;

        return $this;
    }

    public function getWith()
    {
        return $this->with;
    }
}
