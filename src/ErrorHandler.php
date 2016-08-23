<?php

namespace Greg\Support;

class ErrorHandler
{
    static public function throwException()
    {
        set_error_handler(function($errNo, $errStr/*, $errFile, $errLine*/) {
            unset($errNo);

            throw new \Exception($errStr);
        });

        return true;
    }

    static public function disable()
    {
        set_error_handler(function($errNo, $errStr, $errFile, $errLine) {

        });

        return true;
    }

    static public function restore()
    {
        return restore_error_handler();
    }
}