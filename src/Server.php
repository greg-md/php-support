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
}
