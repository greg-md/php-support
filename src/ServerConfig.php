<?php

namespace Greg\Support;

class ServerConfig
{
    public static function encoding($encoding = null)
    {
        return mb_internal_encoding(...func_get_args());
    }

    public static function timezone($timezone = null)
    {
        return func_num_args() ? date_default_timezone_set($timezone) : date_default_timezone_get();
    }
}
