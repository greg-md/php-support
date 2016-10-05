<?php

namespace Greg\Support;

use Greg\Support\Accessor\AccessorTrait;

class Binder
{
    use AccessorTrait;

    public function loadInstance($className, ...$args)
    {
        return $this->loadInstanceArgs($className, $args);
    }

    public function loadInstanceArgs($className, array $args = [])
    {
        $class = new \ReflectionClass($className);

        $self = $class->newInstanceWithoutConstructor();

        method_exists($self, '__bind') && $this->call([$self, '__bind']);

        // Call all methods which starts with __bind
        foreach (get_class_methods($self) as $methodName) {
            if ($methodName[0] === '_' and $methodName !== '__bind' and Str::startsWith($methodName, '__bind')) {
                $this->call([$self, $methodName]);
            }
        }

        if ($constructor = $class->getConstructor()) {
            if ($expectedArgs = $constructor->getParameters()) {
                $args = $this->addExpectedArgs($args, $expectedArgs);
            }

            $constructor->invokeArgs($self, $args);
        }

        return $self;
    }

    public function call(callable $callable, ...$args)
    {
        return $this->callRef($callable, ...$args);
    }

    public function callRef(callable $callable, &...$args)
    {
        return $this->callArgs($callable, $args);
    }

    public function callArgs(callable $callable, array $args = [])
    {
        return call_user_func_array($callable, $this->getCallableArgs($callable, $args));
    }

    public function callWith(callable $callable, ...$args)
    {
        return $this->callWithRef($callable, ...$args);
    }

    public function callWithRef(callable $callable, &...$args)
    {
        return $this->callWithArgs($callable, $args);
    }

    public function callWithArgs(callable $callable, array $args = [])
    {
        return call_user_func_array($callable, $this->getCallableMixedArgs($callable, $args));
    }

    public function getCallableArgs(callable $callable, array $args = [])
    {
        if ($expectedArgs = Obj::expectedArgs($callable)) {
            return $this->addExpectedArgs($args, $expectedArgs);
        }

        return [];
    }

    public function getCallableMixedArgs(callable $callable, array $args = [])
    {
        if ($expectedArgs = Obj::expectedArgs($callable)) {
            return Obj::fetchExpectedArgs($expectedArgs, $args, function (\ReflectionParameter $expectedArg) {
                return $this->expectedArg($expectedArg);
            }, true);
        }

        return [];
    }

    public function addExpectedArgs(array $args, array $expectedArgs)
    {
        /* @var $expectedArgs \ReflectionParameter[] */

        if ($args) {
            $expectedArgs = array_slice($expectedArgs, count($args));
        }

        $newArgs = Obj::fetchExpectedArgs($expectedArgs, [], function (\ReflectionParameter $expectedArg) {
            return $this->expectedArg($expectedArg);
        });

        if ($newArgs) {
            $args = array_merge($args, $newArgs);
        }

        return $args;
    }

    public function expectedArg(\ReflectionParameter $expectedArg)
    {
        if ($expectedType = $expectedArg->getClass()) {
            $className = $expectedType->getName();

            $arg = $expectedArg->isOptional() ? $this->get($className) : $this->getExpected($className);
        } else {
            $arg = Obj::expectedArg($expectedArg);
        }

        return $arg;
    }

    public function setObject($object)
    {
        if (!is_object($object)) {
            throw new \Exception('Item is not an object.');
        }

        return $this->set(get_class($object), $object);
    }

    public function set($name, $object)
    {
        if ($this->inAccessor($name)) {
            throw new \Exception('Object `' . $name . '` is already in use in binder.');
        }

        $this->setToAccessor($name, $object);

        return $this;
    }

    public function getExpected($name)
    {
        if (!$object = $this->get($name)) {
            throw new \Exception('Object `' . $name . '` is not registered in binder.');
        }

        return $object;
    }

    public function get($name)
    {
        $object = $this->getFromAccessor($name);

        if ($object and !is_object($object)) {
            if (is_callable($object)) {
                $object = $this->call($object);
            } else {
                $object = (array) $object;

                $object = Obj::loadInstance(...$object);
            }

            $this->setToAccessor($name, $object);
        }

        return $object;
    }
}
