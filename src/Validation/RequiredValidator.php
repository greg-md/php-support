<?php

namespace Greg\Support\Validation;

class RequiredValidator implements ValidatorStrategy
{
    public function validate($value, array $values = [])
    {
        if (!$value) {
            return ['RequiredError' => 'Value is required.'];
        }

        return [];
    }
}
