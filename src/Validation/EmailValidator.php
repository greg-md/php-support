<?php

namespace Greg\Support\Validation;

class EmailValidator implements ValidatorStrategy
{
    public function validate($value, array $values = [])
    {
        if ($value && filter_var($value, FILTER_VALIDATE_EMAIL) === false) {
            return ['EmailError' => 'Invalid email address format.'];
        }

        return [];
    }
}
