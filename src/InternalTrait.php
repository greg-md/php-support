<?php

namespace Greg\Support;

trait InternalTrait
{
    protected function callCallable(callable $callable, ...$args)
    {
        return call_user_func_array($callable, $args);
    }

    protected function callCallableWith(callable $callable, ...$args)
    {
        return call_user_func_array($callable, Obj::getCallableMixedArgs($callable, $args));
    }

    protected function loadClassInstance($className, ...$args)
    {
        return Obj::loadInstanceArgs($className, $args);
    }

    public function __debugInfo()
    {
        return Debug::fixInfo($this, get_object_vars($this));
    }
}
