<?php

namespace Greg\Support;

class Server
{
    public static function scriptName()
    {
        return static::get('SCRIPT_NAME');
    }

    public static function scriptFile()
    {
        return static::get('SCRIPT_FILENAME');
    }

    public static function requestTime()
    {
        return static::get('REQUEST_TIME');
    }

    public static function requestMicroTime()
    {
        return static::get('REQUEST_TIME_FLOAT');
    }

    public static function documentRoot()
    {
        return static::get('DOCUMENT_ROOT');
    }

    public static function has($key)
    {
        return Arr::has($_SERVER, $key);
    }

    public static function get($key, $else = null)
    {
        return Arr::get($_SERVER, $key, $else);
    }

    public static function encoding($encoding = null)
    {
        return mb_internal_encoding(...func_get_args());
    }

    public static function timezone($timezone = null)
    {
        return func_num_args() ? date_default_timezone_set($timezone) : date_default_timezone_get();
    }

    public static function iniAll($extension = null, $details = true)
    {
        return ini_get_all(...func_get_args());
    }

    public static function iniGet($var)
    {
        if (($value = ini_get($var)) === false) {
            throw new \Exception('Server option `' . $var . '` does not exists.');
        }

        return $value;
    }

    public static function iniSet($var, $value)
    {
        if (($oldValue = ini_set($var, $value)) === false) {
            throw new \Exception('Server option `' . $var . '` can not be set.');
        }

        return $oldValue;
    }

    public static function appendIncPath($path)
    {
        return static::addIncPath($path);
    }

    public static function prependIncPath($path)
    {
        return static::addIncPath($path, true);
    }

    protected static function addIncPath($path, $prepend = false)
    {
        $path = (array) $path;

        $incPaths = explode(PATH_SEPARATOR, get_include_path());

        $path = array_values($path);

        $path = $prepend ? array_merge($path, $incPaths) : array_merge($incPaths, $path);

        $path = array_unique($path);

        $path = array_filter($path);

        return set_include_path(implode(PATH_SEPARATOR, $path));
    }

    public static function resetIncPath()
    {
        return set_include_path('.');
    }

    public static function existsInIncPaths($fileName)
    {
        return stream_resolve_include_path($fileName) !== false;
    }

    public static function errorsAsExceptions($exception = \Exception::class)
    {
        set_error_handler(function ($errNo, $errStr/*, $errFile, $errLine*/) use ($exception) {
            unset($errNo);

            throw new $exception($errStr);
        });

        return true;
    }

    public static function disableErrors()
    {
        set_error_handler(function ($errNo, $errStr, $errFile, $errLine) {
        });

        return true;
    }

    public static function restoreErrors()
    {
        return restore_error_handler();
    }
}
