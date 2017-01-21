<?php

namespace Greg\Support\Validation;

use Greg\Support\DateTime;

class DateTimeFromValidator implements ValidatorStrategy
{
    protected $from = null;

    protected $includeFrom = true;

    public function __construct($from, $includeFrom = null)
    {
        $this->setFrom($from);

        if ($includeFrom !== null) {
            $this->includeFrom($includeFrom);
        }

        return $this;
    }

    public function validate($value, array $values = [])
    {
        if (!$value) {
            return [];
        }

        $value = DateTime::timestamp($value);

        $from = DateTime::timestamp($this->getFrom());

        if ($this->includeFrom() ? $value < $from : $value <= $from) {
            return ['DateTimeFromError' => 'Value should be greater than ' . DateTime::dateTimeString($from) . '.'];
        }

        return [];
    }

    public function setFrom($datetime)
    {
        $this->from = (string) $datetime;

        return $this;
    }

    public function getFrom()
    {
        return $this->from;
    }

    public function includeFrom($value = null)
    {
        if (func_num_args()) {
            $this->includeFrom = (bool) $value;

            return $this;
        }

        return $this->includeFrom;
    }
}
