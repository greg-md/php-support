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
        return call_user_func_array($callable, static::mixedArgs($callable, $args));
    }

    public static function callMixedRef(callable $callable, &...$args)
    {
        return call_user_func_array($callable, static::mixedArgs($callable, $args));
    }

    public static function baseName($class)
    {
        $class = is_object($class) ? get_class($class) : $class;

        return basename(str_replace('\\', '/', $class));
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

    public static function parentClasses($className)
    {
        return static::fetchParentClasses(new \ReflectionClass($className));
    }

    protected static function fetchParentClasses(\ReflectionClass $class, &$classes = [])
    {
        if ($parent = $class->getParentClass()) {
            $classes[$parent->getName()] = $parent->getName();

            return static::fetchParentClasses($parent, $classes);
        }

        return $classes;
    }

    protected static function mixedArgs(callable $callable, array &$args = [])
    {
        if ($expectedArgs = static::expectedArgs($callable)) {
            return static::fetchExpectedArgs($expectedArgs, $args, null, true);
        }

        return [];
    }

    protected static function expectedArgs(callable $callable)
    {
        if (Str::isScalar($callable) and strpos($callable, '::')) {
            $callable = explode('::', $callable, 2);
        }

        if (is_array($callable)) {
            return (new \ReflectionMethod($callable[0], $callable[1]))->getParameters();
        }

        return (new \ReflectionFunction($callable))->getParameters();
    }

    protected static function fetchExpectedArgs(array $expectedArgs, array &$customArgs = [], callable $expectedCallback = null, $allowMixed = false)
    {
        static::splitCustomArgs($customArgs, $allowMixed, $assocArgs, $mixedArgs);

        /* @var $expectedArgs \ReflectionParameter[] */
        $expectedArgs = array_reverse($expectedArgs);

        $returnArgs = [];

        $countMixedExpected = $allowMixed ? static::countMixableParams($expectedArgs) : 0;

        foreach ($expectedArgs as $expectedArg) {
            if ($expectedArg->isVariadic()) {
                $returnArgs = array_merge($returnArgs, array_reverse(array_slice($customArgs, $expectedArg->getPosition())));

                continue;
            }

            $expectedType = $expectedArg->getClass();

            if ($allowMixed and !$expectedType) {
                --$countMixedExpected;

                if (Arr::has($mixedArgs, $countMixedExpected)) {
                    $returnArgs[] = &$mixedArgs[$countMixedExpected];
                } else {
                    if (!$returnArgs and $expectedArg->isOptional()) {
                        continue;
                    }

                    if (Arr::has($customArgs, $expectedArg->getPosition())) {
                        $returnArgs[] = $customArgs[$expectedArg->getPosition()];
                    } else {
                        $returnArgs[] = static::expectedArg($expectedArg);
                    }
                }
            } else {
                //                if (!$returnArgs and !$expectedType and $expectedArg->isOptional()) {
//                    continue;
//                }

                if ($assocArgs and Arr::has($assocArgs, $expectedType->getName())) {
                    $returnArgs[] = &$assocArgs[$expectedType->getName()];
//                } elseif (is_callable($expectedCallback)) {
//                    $returnArgs[] = &call_user_func_array($expectedCallback, [$expectedArg]);
                } else {
                    $returnArgs[] = static::expectedArg($expectedArg);
                }
            }
        }

        $returnArgs = array_reverse($returnArgs);

        return $returnArgs;
    }

    protected static function splitCustomArgs($customArgs, $allowMixed = false, &$assocArgs = [], &$mixedArgs = [])
    {
        foreach ($customArgs as $key => &$value) {
            if (is_int($key)) {
                if (is_object($value)) {
                    $assocArgs[get_class($value)] = &$value;

                    foreach (class_implements($value) as $interface) {
                        $assocArgs[$interface] = &$value;
                    }

                    foreach (static::parentClasses($value) as $class) {
                        $assocArgs[$class] = &$value;
                    }
                } else {
                    if ($allowMixed) {
                        $mixedArgs[] = &$value;
                    } else {
                        throw new \Exception('Expected value is not an object.');
                    }
                }
            } else {
                $assocArgs[$key] = &$value;
            }
        }
        unset($value);

        return [$assocArgs, $mixedArgs];
    }

    protected static function countMixableParams($expectedArgs)
    {
        return Arr::count($expectedArgs, function (\ReflectionParameter $expectedArg) {
            try {
                return !$expectedArg->getClass();
            } catch (\Exception $e) {
                return false;
            }
        });
    }

    protected static function expectedArg(\ReflectionParameter $expectedArg)
    {
        if (!$expectedArg->isOptional()) {
            if ($function = $expectedArg->getDeclaringFunction() and $class = $expectedArg->getDeclaringClass()) {
                throw new \Exception('Argument `' . $expectedArg->getName() . '` is required in `' . $class->getName() . '::' . $function->getName() . '`.');
            }

            throw new \Exception('Argument `' . $expectedArg->getName() . '` is required in `' . $function->getName() . '`.');
        }

        return $expectedArg->getDefaultValue();
    }
}
