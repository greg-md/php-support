<?php

namespace Greg\Support\Storage;

trait AccessorStaticTrait
{
    private static $storage = [];

    protected static function getStorage()
    {
        return static::$storage;
    }

    protected static function setStorage(array $storage)
    {
        static::$storage = $storage;
    }

    protected static function inStorage($key)
    {
        return array_key_exists($key, static::$storage);
    }

    protected static function setToStorage($key, $value)
    {
        static::$storage[$key] = $value;
    }

    protected static function getFromStorage($key)
    {
        return static::inStorage($key) ? static::$storage[$key] : null;
    }
}
