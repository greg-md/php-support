<?php

namespace Greg\Support;

class Obj
{
    public static function &call(callable $callable, &...$arguments)
    {
        return static::callArgs($callable, $arguments);
    }

    public static function &callArgs(callable $callable, array $arguments)
    {
        // NOTE: Don't use call_user_func_array for return-by-reference because the function doesn't support it.
        if (self::callableReturnsReference($callable)) {
            if (is_array($callable)) {
                return $callable[0]->{$callable[1]}(...$arguments);
            }

            return $callable(...$arguments);
        }

        // Set value to an argument to return it's reference.
        $return = call_user_func_array($callable, $arguments);

        return $return;
    }

    public static function &callMixed(callable $callable, &...$arguments)
    {
        return static::callMixedArgs($callable, $arguments);
    }

    public static function &callMixedArgs(callable $callable, array $arguments)
    {
        if ($parameters = static::parameters($callable)) {
            $arguments = static::populateParameters($parameters, $arguments);
        }

        return static::callArgs($callable, $arguments);
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

        $prefix = $prefix ?: [''];

        $suffix = $suffix ?: [''];

        foreach ((array) $prefix as $classPrefix) {
            foreach ((array) $suffix as $classSuffix) {
                $class = $classPrefix . $name . $classSuffix;

                if (class_exists($class, false)) {
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

    public static function expectedParameterValue(\ReflectionParameter $parameter)
    {
        if (!$parameter->isOptional()) {
            if ($function = $parameter->getDeclaringFunction() and $class = $parameter->getDeclaringClass()) {
                throw new \Exception('Parameter `' . $parameter->getName() . '` is required in `' . $class->getName() . '::' . $function->getName() . '`.');
            }

            throw new \Exception('Parameter `' . $parameter->getName() . '` is required in `' . $function->getName() . '`.');
        }

        return $parameter->getDefaultValue();
    }

    public static function callableReturnsReference(callable $callable)
    {
        if (is_array($callable)) {
            $reflection = new \ReflectionMethod($callable[0], $callable[1]);
        } else {
            $reflection = new \ReflectionFunction($callable);
        }

        return $reflection->returnsReference();
    }

    public static function populateParameters(array $parameters, array $arguments = [], callable $fallback = null)
    {
        $countMixedExpected = self::countMixableParameters($parameters);

        list($argumentsTypes, $mixedArguments) = self::extractArgumentsTypes($arguments);

        $returnArguments = [];

        /* @var $parameter \ReflectionParameter */
        foreach (array_reverse($parameters) as $parameter) {
            if ($parameter->isVariadic()) {
                $returnArguments = array_merge($returnArguments, array_reverse(array_slice($arguments, $parameter->getPosition())));

                continue;
            }

            if ($expectedType = $parameter->getClass()) {
                if (array_key_exists($expectedType->getName(), $argumentsTypes)) {
                    $returnArguments[] = &$argumentsTypes[$expectedType->getName()];

                    continue;
                }

                if ($fallback) {
                    $returnArguments[] = call_user_func_array($fallback, [$parameter]);

                    continue;
                }

                if (!$returnArguments and $parameter->isOptional()) {
                    continue;
                }

                $returnArguments[] = self::expectedParameterValue($parameter);

                continue;
            }

            --$countMixedExpected;

            if (array_key_exists($countMixedExpected, $mixedArguments)) {
                $returnArguments[] = &$mixedArguments[$countMixedExpected];

                continue;
            }

            if (!$returnArguments and $parameter->isOptional()) {
                continue;
            }

            if (array_key_exists($parameter->getPosition(), $arguments)) {
                $returnArguments[] = &$arguments[$parameter->getPosition()];

                continue;
            }

            $returnArguments[] = self::expectedParameterValue($parameter);
        }

        return array_reverse($returnArguments);
    }

    private static function extractArgumentsTypes($arguments)
    {
        $argumentsTypes = $mixedArguments = [];

        foreach ($arguments as &$argument) {
            if (is_object($argument)) {
                foreach (self::typeAliases($argument) as $type) {
                    $argumentsTypes[$type] = &$argument;
                }
            } else {
                $mixedArguments[] = &$argument;
            }
        }
        unset($argument);

        return [$argumentsTypes, $mixedArguments];
    }

    private static function countMixableParameters(array $parameters)
    {
        return count(array_filter($parameters, function (\ReflectionParameter $parameter) {
            /*
             * In some of cases it throws an exception. Need to remember when.
             */
//            try {
            return !$parameter->getClass();
//            } catch (\Exception $e) {
//                return false;
//            }
        }));
    }
}
