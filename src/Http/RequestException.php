<?php

namespace Greg\Support\Http;

class RequestException extends \Exception
{
    private $inputErrors = [];

    public function setInputErrors(array $errors)
    {
        $this->inputErrors = $errors;

        return $this;
    }

    public function getInputErrors()
    {
        return $this->inputErrors;
    }
}
