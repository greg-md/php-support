<?php

namespace Greg\Support\IoC;

use Greg\Support\Accessor\AccessorTrait;
use Greg\Support\Arr;
use Greg\Support\Obj;

class IoCContainer
{
    use AccessorTrait;

    protected $prefixes = [];

    protected $concrete = [];

    public function loadInstance($className, ...$args)
    {
        return $this->loadInstanceArgs($className, $args);
    }

    public function loadInstanceArgs($className, array $args = [])
    {
        $class = new \ReflectionClass($className);

        $self = $class->newInstanceWithoutConstructor();

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

            $arg = $expectedArg->isOptional() ? $this->get($className) : $this->expect($className);
        } else {
            $arg = Obj::expectedArg($expectedArg);
        }

        return $arg;
    }

    public function inject($abstract, $loader = null)
    {
        if ($this->inAccessor($abstract)) {
            throw new \Exception('`' . $abstract . '` is already in use in IoC Container.');
        }

        if (!$loader) {
            $loader = function () use ($abstract) {
                return $this->loadInstance($abstract);
            };
        }

        return $this->register($abstract, null, $loader);
    }

    public function concrete($abstract, $concrete)
    {
        if ($this->inAccessor($abstract)) {
            throw new \Exception('`' . $abstract . '` is already in use in IoC Container.');
        }

        return $this->register($abstract, $concrete);
    }

    public function object($object)
    {
        if (!is_object($object)) {
            throw new \Exception('Item is not an object.');
        }

        return $this->concrete(get_class($object), $object);
    }

    protected function register($abstract, $concrete = null, $loader = null)
    {
        return $this->setToAccessor($abstract, [
            'concrete' => $concrete,
            'loader'   => $loader,
        ]);
    }

    public function get($abstract)
    {
        if (!$this->inConcrete($abstract)) {
            if ($item = $this->getFromAccessor($abstract)) {
                if ($loader = $item['loader']) {
                    if (is_callable($loader)) {
                        $this->setToConcrete($abstract, $this->call($loader));
                    } elseif (!is_object($loader)) {
                        if (is_array($loader)) {
                            $concrete = $this->loadInstance(...$loader);
                        } else {
                            $concrete = $this->expect($loader);
                        }

                        $this->setToConcrete($abstract, $concrete);
                    }
                } else {
                    $this->setToConcrete($abstract, $item['concrete']);
                }
            } elseif ($this->prefixIsRegistered($abstract)) {
                $concrete = $this->loadInstance($abstract);

                $this->setToConcrete($abstract, $concrete);
            }
        }

        return $this->getFromConcrete($abstract);
    }

    public function expect($abstract)
    {
        if (!$concrete = $this->get($abstract)) {
            throw new \Exception('`' . $abstract . '` is not registered in IoC Container.');
        }

        return $concrete;
    }

    public function addPrefixes(array $prefixes)
    {
        $this->prefixes = array_merge($this->prefixes, $prefixes);

        return $this;
    }

    public function addPrefix($prefix)
    {
        $this->prefixes[] = $prefix;

        return $this;
    }

    public function prefixIsRegistered($className)
    {
        foreach ($this->prefixes as $prefix) {
            if (strpos($className, $prefix) === 0) {
                return true;
            }
        }

        return false;
    }

    protected function inConcrete($abstract)
    {
        return array_key_exists($abstract, $this->concrete);
    }

    protected function getFromConcrete($abstract)
    {
        return $this->inConcrete($abstract) ? $this->concrete[$abstract] : null;
    }

    protected function setToConcrete($abstract, $concrete)
    {
        Arr::setRefValueRef($this->concrete, $abstract, $concrete);

        return $this;
    }
}
