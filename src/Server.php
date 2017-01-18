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
}
