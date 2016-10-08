<?php

namespace Greg\Support\IoC;

interface IoCManagerInterface
{
    public function callCallable(callable $callable, ...$args);

    public function callCallableWith(callable $callable, ...$args);
}