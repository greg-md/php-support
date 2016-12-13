<?php

namespace Greg\Support\Validation;

interface ValidatorStrategy
{
    /**
     * @param $value
     * @param array $values
     *
     * @return array
     */
    public function validate($value, array $values = []);
}
