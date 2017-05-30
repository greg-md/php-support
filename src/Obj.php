<?php

namespace Greg\Support;

class Obj
{
    public static function call(callable $callable, ...$args)
    {
        return call_user_func_array($callable, $args);
    }

    public static function callRef(callable $callable, &...$args)
    {
        return call_user_func_array($callable, $args);
    }

    public static function callMixed(callable $callable, ...$args)
    {
        if ($expectedArgs = static::parameters($callable)) {
            $args = static::populateParameters($expectedArgs, $args, true);
        }

        return call_user_func_array($callable, $args);
    }

    public static function callMixedRef(callable $callable, &...$args)
    {
        if ($expectedArgs = static::parameters($callable)) {
            $args = static::populateParameters($expectedArgs, $args, true);
        }

        return call_user_func_array($callable, $args);
    }

    public static function baseName($class)
    {
        return basename(str_replace('\\', '/', is_object($class) ? get_class($class) : $class));
    }

    public static function exists($name, $prefix = null, $suffix = null)
    {
        $name = array_map(function ($name) {
            return Str::phpCamelCase($name);
        }, (array) $name);

        $name = implode('\\', $name);

        foreach ((array) $prefix as $classPrefix) {
            foreach ((array) $suffix as $classSuffix) {
                $class = $classPrefix . $name . $classSuffix;

                if (class_exists($class)) {
                    return $class;
                }
            }
        }

        return false;
    }

    public static function uses($class)
    {
        $traits = class_uses($class);

        foreach ($traits as $trait) {
            $traits += static::uses($trait);
        }

        return array_unique($traits);
    }

    public static function usesRecursive($class, $breakOn = null)
    {
        $results = [];

        foreach (array_merge([$class => $class], class_parents($class)) as $class) {
            if ($breakOn === $class) {
                break;
            }

            $results += static::uses($class);
        }

        return array_unique($results);
    }

    public static function typeAliases($class)
    {
        return array_merge([get_class($class)], class_implements($class), class_parents($class));
    }

    public static function parameters(callable $callable)
    {
        if (Str::isScalar($callable) and strpos($callable, '::')) {
            $callable = explode('::', $callable, 2);
        }

        if (is_array($callable)) {
            return (new \ReflectionMethod($callable[0], $callable[1]))->getParameters();
        }

        return (new \ReflectionFunction($callable))->getParameters();
    }

    public static function parameterValue(\ReflectionParameter $parameter)
    {
        if (!$parameter->isOptional()) {
            if ($function = $parameter->getDeclaringFunction() and $class = $parameter->getDeclaringClass()) {
                throw new \Exception('Parameter `' . $parameter->getName() . '` is required in `' . $class->getName() . '::' . $function->getName() . '`.');
            }

            throw new \Exception('Parameter `' . $parameter->getName() . '` is required in `' . $function->getName() . '`.');
        }

        return $parameter->getDefaultValue();
    }

    public static function populateParameters(array $parameters, array $arguments = [], $mixed = false, callable $expectedCallable = null)
    {
        [$argumentsTypes, $mixedArguments] = static::extractArgumentsTypes($arguments, $mixed);

        /* @var $parameters \ReflectionParameter[] */
        $parameters = array_reverse($parameters);

        $returnArguments = [];

        $countMixedExpected = $mixed ? static::countMixableParameters($parameters) : 0;

        foreach ($parameters as $parameter) {
            if ($parameter->isVariadic()) {
                $returnArguments = array_merge($returnArguments, array_reverse(array_slice($arguments, $parameter->getPosition())));

                continue;
            }

            $expectedType = $parameter->getClass();

            if ($mixed and !$expectedType) {
                --$countMixedExpected;

                if (Arr::has($mixedArguments, $countMixedExpected)) {
                    $returnArguments[] = &$mixedArguments[$countMixedExpected];
                } else {
                    if (!$returnArguments and $parameter->isOptional()) {
                        continue;
                    }

                    if (Arr::has($arguments, $parameter->getPosition())) {
                        $returnArguments[] = &$arguments[$parameter->getPosition()];
                    } else {
                        $returnArguments[] = static::parameterValue($parameter);
                    }
                }
            } else {
                if ($argumentsTypes and Arr::has($argumentsTypes, $expectedType->getName())) {
                    $returnArguments[] = &$argumentsTypes[$expectedType->getName()];
                } elseif (is_callable($expectedCallable)) {
                    $returnArguments[] = &call_user_func_array($expectedCallable, [$parameter]);
                } else {
                    if (!$returnArguments and $parameter->isOptional()) {
                        continue;
                    }

                    $returnArguments[] = static::parameterValue($parameter);
                }
            }
        }

        $returnArguments = array_reverse($returnArguments);

        return $returnArguments;
    }

    private static function extractArgumentsTypes($arguments, $mixed = false)
    {
        $argumentsTypes = $mixedArguments = [];

        foreach ($arguments as &$argument) {
            if (is_object($argument)) {
                foreach (static::typeAliases($argument) as $type) {
                    $argumentsTypes[$type] = &$argument;
                }
            } else {
                if ($mixed) {
                    $mixedArguments[] = &$argument;
                } else {
                    throw new \Exception('Expected argument is not an object.');
                }
            }
        }
        unset($argument);

        return [$argumentsTypes, $mixedArguments];
    }

    private static function countMixableParameters(array $parameters)
    {
        return count(Arr::filter($parameters, function (\ReflectionParameter $parameter) {
            try {
                return !$parameter->getClass();
            } catch (\Exception $e) {
                return false;
            }
        }));
    }
}
