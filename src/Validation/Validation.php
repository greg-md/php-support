<?php

namespace Greg\Support\Validation;

use Greg\Support\Arr;

class Validation
{
    protected $namespaces = [
        'Greg\\Support\\Validation',
    ];

    protected $suffix = 'Validator';

    /**
     * @var ValidatorStrategy[][]
     */
    protected $validators = [];

    public function __construct(array $validators = [], array $namespaces = [], $suffix = null)
    {
        if ($num = func_num_args()) {
            $this->addValidators($validators);
        }

        if ($num > 1) {
            $this->addNamespaces($namespaces);
        }

        if ($num > 2) {
            $this->setSuffix($suffix);
        }

        return $this;
    }

    public function addValidators(array $validators)
    {
        $this->validators = array_merge($this->validators, $validators);

        return $this;
    }

    public function addNamespaces(array $namespaces)
    {
        $this->namespaces = array_merge($this->namespaces, $namespaces);

        return $this;
    }

    public function setSuffix($name)
    {
        $this->suffix = (string) $name;

        return $this;
    }

    public function validate(array $params = [])
    {
        $errors = [];

        foreach ($this->validators as $key => $keyValidators) {
            if (is_scalar($keyValidators)) {
                $keyValidators = explode('|', $keyValidators);
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
        foreach ($this->namespaces as $namespace) {
            $className = $namespace . '\\' . ucfirst($name) . $this->suffix;

            if (class_exists($className)) {
                return $className;
            }
        }

        throw new \Exception('Validator `' . $name . '` not found.');
    }

    /**
     * @param $validator
     *
     * @throws \Exception
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
            throw new \Exception('Validator should be an instance of `' . ValidatorStrategy::class . '`.');
        }

        return $validator;
    }
}
