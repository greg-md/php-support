<?php

namespace Greg\Support\Validation;

use Greg\Support\DateTime;

class DateTimeToValidator implements ValidatorStrategy
{
    protected $to = null;

    protected $includeTo = true;

    public function __construct($to, $includeTo = null)
    {
        $this->setTo($to);

        if ($includeTo !== null) {
            $this->includeTo($includeTo);
        }

        return $this;
    }

    public function validate($value, array $values = [])
    {
        if ($value) {
            $value = DateTime::toTimestamp($value);

            $to = DateTime::toTimestamp($this->getTo());

            if ($this->includeTo() ? $value > $to : $value >= $to) {
                return ['DateTimeToError' => 'Value should be less than ' . DateTime::toDateTimeString($to) . '.'];
            }
        }

        return [];
    }

    public function setTo($datetime)
    {
        $this->to = (string) $datetime;

        return $this;
    }

    public function getTo()
    {
        return $this->to;
    }

    public function includeTo($value = null)
    {
        if (func_num_args()) {
            $this->includeTo = (bool) $value;

            return $this;
        }

        return $this->includeTo;
    }
}
