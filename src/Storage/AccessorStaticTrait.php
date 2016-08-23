<?php

namespace Greg\Support\Storage;

trait AccessorStaticTrait
{
    static private $storage = [];

    static protected function getStorage()
    {
        return static::$storage;
    }

    static protected function setStorage(array $storage)
    {
        static::$storage = $storage;
    }

    static protected function inStorage($key)
    {
        return array_key_exists($key, static::$storage);
    }

    static protected function setToStorage($key, $value)
    {
        static::$storage[$key] = $value;
    }

    static protected function getFromStorage($key)
    {
        return static::inStorage($key) ? static::$storage[$key] : null;
    }
}