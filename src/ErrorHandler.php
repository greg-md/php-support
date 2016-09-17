<?php

namespace Greg\Support;

class ErrorHandler
{
    public static function throwException()
    {
        set_error_handler(function ($errNo, $errStr/*, $errFile, $errLine*/) {
            unset($errNo);

            throw new \Exception($errStr);
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
