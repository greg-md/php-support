<?php

namespace Greg\Support;

class ServerConfig
{
    static public function encoding($encoding = null)
    {
        return mb_internal_encoding(...func_get_args());
    }

    static public function timezone($timezone = null)
    {
        return func_num_args() ? date_default_timezone_set($timezone) : date_default_timezone_get();
    }

    static public function param($var, $value = null)
    {
        if (is_array($var)) {
            foreach($var as $key => $value) {
                static::set($key, $value);
            }
        } else {
            static::set($var, $value);
        }

        return true;
    }

    static public function set($var, $value)
    {
        if (!method_exists(get_called_class(), $var)) {
            throw new \Exception('Unknown config `' . $var . '`.');
        }

        return static::$var($value);
    }
}