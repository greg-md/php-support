<?php

namespace Greg\Support\Validation;

use Greg\Support\Arr;
use Greg\Support\Obj;

class Validation
{
    protected $prefixes = [
        'Greg\\Support\\Validation\\',
    ];

    protected $suffixes = [
        'Validator',
    ];

    /**
     * @var ValidatorStrategy[][]
     */
    protected $validators = [];

    public function __construct(array $validators = [], $prefix = null, $suffix = null)
    {
        if ($num = func_num_args()) {
            $this->addValidators((array) $validators);
        }

        if ($num > 1) {
            $this->addPrefix((array) $prefix);
        }

        if ($num > 2) {
            $this->addSuffix((array) $suffix);
        }

        return $this;
    }

    public function addValidators(array $validators)
    {
        $this->validators = array_merge($this->validators, $validators);

        return $this;
    }

    public function addPrefix($prefix)
    {
        $this->prefixes = array_merge($this->prefixes, (array) $prefix);

        return $this;
    }

    public function addSuffix($suffix)
    {
        $this->suffixes = array_merge($this->suffixes, (array) $suffix);

        return $this;
    }

    public function validate(array $params = [])
    {
        $errors = [];

        foreach ($this->validators as $key => $keyValidators) {
            if (is_scalar($keyValidators)) {
                $keyValidators = explode('|', $keyValidators);
            }

            if (is_object($keyValidators)) {
                $keyValidators = [$keyValidators];
            }

            foreach ($keyValidators as $keyValidator) {
                $validator = $this->fetchValidator($keyValidator);

                if ($validatorErrors = $validator->validate(Arr::get($params, $key), $params)) {
                    $errors[$key] = isset($errors[$key]) ? array_merge($errors[$key], $validatorErrors) : $validatorErrors;
                }
            }
        }

        return $errors;
    }

    protected function getClassByName($name)
    {
        if ($className = Obj::exists(ucfirst($name), $this->prefixes, $this->suffixes)) {
            return $className;
        }

        throw new ValidationException('Validator `' . $name . '` not found.');
    }

    /**
     * @param $validator
     *
     * @throws ValidationException
     *
     * @return ValidatorStrategy
     */
    protected function fetchValidator($validator)
    {
        if (!is_object($validator)) {
            if (is_array($validator)) {
                $name = array_shift($validator);

                $args = $validator;
            } else {
                $parts = explode(':', $validator, 2);

                $name = array_shift($parts);

                $args = $parts ? explode(',', array_shift($parts)) : [];
            }

            $className = $this->getClassByName($name);

            $validator = new $className(...$args);
        }

        if (!($validator instanceof ValidatorStrategy)) {
            throw new ValidationException('Validator `' . get_class($validator) . '` should be an instance of `' . ValidatorStrategy::class . '`.');
        }

        return $validator;
    }
}
