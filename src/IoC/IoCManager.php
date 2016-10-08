<?php

namespace Greg\Support\IoC;

use Greg\Support\Obj;

class IoCManager implements IoCManagerInterface
{
    protected $callable = null;

    protected $callableWith = null;

    public function __construct(callable $callable = null, callable $callableWith = null)
    {
        if ($callable) {
            $this->setCallable($callable);
        }

        if ($callableWith) {
            $this->setCallableWith($callableWith);
        }
    }

    public function setCallable(callable $callable)
    {
        $this->callable = $callable;

        return $this;
    }

    public function setCallableWith(callable $callable)
    {
        $this->callableWith = $callable;

        return $this;
    }

    public function setIoCContainer(IoCContainer $container)
    {
        $this->setCallable([$container, 'call']);

        $this->setCallableWith([$container, 'callWith']);

        return $this;
    }

    public function callCallable(callable $callable, ...$args)
    {
        if ($this->callable) {
            return Obj::callCallable($this->callable, $callable, ...$args);
        }

        return Obj::callCallable($callable, ...$args);
    }

    public function callCallableWith(callable $callable, ...$args)
    {
        if ($this->callableWith) {
            return Obj::callCallable($this->callableWith, $callable, ...$args);
        }

        return Obj::callCallableWith($callable, ...$args);
    }
}