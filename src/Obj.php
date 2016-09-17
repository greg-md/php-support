<?php

namespace Greg\Support;

class Obj
{
    public static function loadInstance($className, ...$args)
    {
        return static::loadInstanceArgs($className, $args);
    }

    /**
     * @param $className
     * @param array $args
     *
     * @return object
     */
    public static function loadInstanceArgs($className, array $args = [])
    {
        $class = new \ReflectionClass($className);

        $self = $class->newInstanceWithoutConstructor();

        method_exists($self, '__bind') && $self->__bind();

        // Call all methods which starts with __bind
        foreach (get_class_methods($self) as $methodName) {
            if ($methodName[0] === '_' and $methodName !== '__bind' and Str::startsWith($methodName, '__bind')) {
                $self->{$methodName}();
            }
        }

        if ($constructor = $class->getConstructor()) {
            $constructor->invokeArgs($self, $args);
        }

        return $self;
    }

    public static function expectedArgs(callable $callable)
    {
        if (Str::isScalar($callable) and strpos($callable, '::')) {
            $callable = explode('::', $callable, 2);
        }

        if (is_array($callable)) {
            return (new \ReflectionMethod($callable[0], $callable[1]))->getParameters();
        }

        return (new \ReflectionFunction($callable))->getParameters();
    }

    public static function callWith(callable $callable, ...$args)
    {
        return static::callWithRef($callable, ...$args);
    }

    public static function callWithRef(callable $callable, &...$args)
    {
        return static::callWithArgs($callable, $args);
    }

    public static function callWithArgs(callable $callable, array $args = [])
    {
        return call_user_func_array($callable, static::getCallableMixedArgs($callable, $args));
    }

    public static function getCallableMixedArgs(callable $callable, array $args = [])
    {
        if ($expectedArgs = static::expectedArgs($callable)) {
            return static::fetchExpectedArgs($expectedArgs, $args);
        }

        return [];
    }

    public static function fetchExpectedArgs(array $expectedArgs, array $customArgs = [], callable $expectedCallback = null, $allowMixed = false)
    {
        $assocArgs = [];

        $mixedArgs = [];

        foreach ($customArgs as $key => $value) {
            if (is_int($key)) {
                if (is_object($value)) {
                    $assocArgs[get_class($value)] = $value;
                } else {
                    if ($allowMixed) {
                        $mixedArgs[] = $value;
                    } else {
                        throw new \Exception('Expected value is not an object.');
                    }
                }
            } else {
                $assocArgs[$key] = $value;
            }
        }

        /* @var $expectedArgs \ReflectionParameter[] */
        $expectedArgs = array_reverse($expectedArgs);

        $returnArgs = [];

        $countMixedExpected = $allowMixed ? Arr::count($expectedArgs, function (\ReflectionParameter $expectedArg) {
            try {
                return !$expectedArg->getClass();
            } catch (\Exception $e) {
                return false;
            }
        }) : 0;

        foreach ($expectedArgs as $expectedArg) {
            $expectedType = $expectedArg->getClass();

            if ($allowMixed and !$expectedType) {
                --$countMixedExpected;

                if (Arr::hasRef($mixedArgs, $countMixedExpected)) {
                    $returnArgs[] = $mixedArgs[$countMixedExpected];
                } else {
                    if (!$returnArgs and $expectedArg->isOptional()) {
                        continue;
                    }

                    $returnArgs[] = static::expectedArg($expectedArg);
                }
            } else {
                if (!$returnArgs and !$expectedType and $expectedArg->isOptional()) {
                    continue;
                }

                if ($assocArgs and Arr::hasRef($assocArgs, $expectedType->getName())) {
                    $returnArgs[] = $assocArgs[$expectedType->getName()];
                } elseif (is_callable($expectedCallback)) {
                    $returnArgs[] = call_user_func_array($expectedCallback, [$expectedArg]);
                } else {
                    $returnArgs[] = static::expectedArg($expectedArg);
                }
            }
        }

        $returnArgs = array_reverse($returnArgs);

        return $returnArgs;
    }

    public static function expectedArg(\ReflectionParameter $expectedArg)
    {
        if (!$expectedArg->isOptional()) {
            throw new \Exception('Argument `' . $expectedArg->getName() . '` is required in `'
                . $expectedArg->getDeclaringClass()->getName() . '::' . $expectedArg->getDeclaringFunction()->getName() . '`');
        }

        $arg = $expectedArg->getDefaultValue();

        return $arg;
    }

    public static function classExists($name, array $prefixes = [], $namePrefix = null)
    {
        $name = array_map(function ($name) {
            return Str::phpName($name);
        }, (array) $name);

        $name = implode('\\', $name);

        foreach ($prefixes as $prefix) {
            $class = $prefix . $namePrefix . $name;

            if (class_exists($class)) {
                return $class;
            }
        }

        return false;
    }

    public static function usesRecursive($class, $breakOn = null)
    {
        $results = [];

        foreach (array_merge([$class => $class], class_parents($class)) as $class) {
            if ($breakOn === $class) {
                break;
            }

            $results += static::traitUsesRecursive($class);
        }

        return array_unique($results);
    }

    public static function traitUsesRecursive($trait)
    {
        $traits = class_uses($trait);

        foreach ($traits as $trait) {
            $traits += static::traitUsesRecursive($trait);
        }

        return $traits;
    }

    public static function baseName($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
    }
}
