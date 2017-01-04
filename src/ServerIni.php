<?php

namespace Greg\Support;

class ServerIni
{
    public static function getAll($extension = null, $details = true)
    {
        return ini_get_all(...func_get_args());
    }

    public static function get($var)
    {
        if (($value = ini_get($var)) === false) {
            throw new \Exception('Server option `' . $var . '` does not exists.');
        }

        return $value;
    }

    public static function set($var, $value)
    {
        if (($oldValue = ini_set($var, $value)) === false) {
            throw new \Exception('Server option `' . $var . '` can not be set.');
        }

        return $oldValue;
    }
}
