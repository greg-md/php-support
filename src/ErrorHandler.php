<?php

namespace Greg\Support;

class ErrorHandler
{
    public static function throwException($exception = \Exception::class)
    {
        set_error_handler(function ($errNo, $errStr/*, $errFile, $errLine*/) use ($exception) {
            unset($errNo);

            throw new $exception($errStr);
        });

        return true;
    }

    public static function disable()
    {
        set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
        });

        return true;
    }

    public static function restore()
    {
        return restore_error_handler();
    }
}
