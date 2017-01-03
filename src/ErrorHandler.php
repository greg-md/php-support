<?php

namespace Greg\Support;

class ErrorHandler
{
    public static function throwException($e = \Exception::class)
    {
        set_error_handler(function ($errNo, $errStr/*, $errFile, $errLine*/) use ($e) {
            unset($errNo);

            throw new $e($errStr);
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
