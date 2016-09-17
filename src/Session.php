<?php

namespace Greg\Support;

class Session
{
    protected static $persistent = false;

    protected static $handler = null;

    protected static $flashKey = '__FLASH__';

    protected static $flash = [];

    protected static $flashLoaded = false;

    public static function reloadFlash()
    {
        $flash = static::get(static::$flashKey);

        static::del(static::$flashKey);

        return static::$flash = $flash;
    }

    public static function loadFlash()
    {
        if (!static::$flashLoaded) {
            static::reloadFlash();

            static::$flashLoaded = true;
        }

        return static::$flash;
    }

    public static function setFlash($key, $value = null)
    {
        static::loadFlash();

        $flash = &static::getForceRef(static::$flashKey);

        if (is_array($key)) {
            $flash = array_merge($flash, $key);

            static::$flash = array_merge(static::$flash, $key);
        } else {
            $flash[$key] = $value;

            static::$flash[$key] = $value;
        }

        return $flash;
    }

    public static function getFlash($key = null)
    {
        static::loadFlash();

        $flash = &static::getForceRef(static::$flashKey);

        if (func_num_args()) {
            return Arr::getRef($flash, $key);
        }

        return $flash;
    }

    public static function ini($var, $value = null)
    {
        if (is_array($var)) {
            foreach (($param = $var) as $var => $value) {
                static::iniSet($var, $value);
            }

            return true;
        }

        if (func_num_args() > 1) {
            return static::iniSet($var, $value);
        }

        return static::iniGet($var);
    }

    public static function iniSet($var, $value)
    {
        return ServerIni::set('session.'.$var, $value);
    }

    public static function iniGet($var)
    {
        return ServerIni::get('session.'.$var);
    }

    public static function id($id = null)
    {
        return session_id(...func_get_args());
    }

    public static function getId()
    {
        static::start();

        return static::id();
    }

    public static function persistent($value = null)
    {
        if (func_num_args()) {
            static::$persistent = (bool) $value;
        }

        return static::$persistent;
    }

    public static function name($name = null)
    {
        return session_name(...func_get_args());
    }

    public static function start()
    {
        if (!isset($_SESSION)) {
            session_start();

            if (static::persistent()) {
                static::resetLifetime();
            }
        }

        return true;
    }

    public static function unserialize($data)
    {
        return static::unserializePart($data);
    }

    protected static function unserializePart($data, $startIndex = 0, &$dict = null)
    {
        isset($dict) or $dict = [];

        $nameEnd = strpos($data, '|', $startIndex);

        if ($nameEnd !== false) {
            $name = substr($data, $startIndex, $nameEnd - $startIndex);

            $rest = substr($data, $nameEnd + 1);

            $value = unserialize($rest); // PHP will unserialize up to "|" delimiter.

            $dict[$name] = $value;

            return static::unserializePart($data, $nameEnd + 1 + strlen(serialize($value)), $dict);
        }

        return $dict;
    }

    public static function decode($data, $return = false)
    {
        return $return ? static::unserialize($data) : session_decode($data);
    }

    public static function resetLifetime($time = null, $path = null, $domain = null, $secure = null, $httpOnly = null)
    {
        if ($time === null) {
            $time = ini_get('session.cookie_lifetime');
        }

        if ($path === null) {
            $path = ini_get('session.cookie_path');
        }

        if ($domain === null) {
            $domain = ini_get('session.cookie_domain');
        }

        if ($secure === null) {
            $secure = ini_get('session.cookie_secure');
        }

        if ($httpOnly === null) {
            $httpOnly = ini_get('session.cookie_httponly');
        }

        if ($time > 0) {
            $time += time();
        }

        setcookie(static::name(), static::getId(), $time, $path, $domain, $secure, $httpOnly);

        return true;
    }

    public static function saveHandler($handler = null)
    {
        if ($handler !== null) {
            session_set_save_handler($handler);

            static::$handler = $handler;
        }

        return static::$handler;
    }

    // Start standard array methods

    public static function is()
    {
        return (bool) $_SESSION;
    }

    public static function all()
    {
        return $_SESSION;
    }

    public static function has($key)
    {
        return Arr::hasRef($_SESSION, $key);
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_SESSION, $index, $delimiter);
    }

    public static function set($key, $value)
    {
        return static::setRef($key, $value);
    }

    public static function setRef($key, &$value)
    {
        return Arr::setRefValueRef($_SESSION, $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexRef($index, $value, $delimiter);
    }

    public static function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_SESSION, $index, $value, $delimiter);
    }

    public static function get($key, $else = null)
    {
        return static::getRef($key, $else);
    }

    public static function &getRef($key, $else = null)
    {
        return Arr::getRef($_SESSION, $key, $else);
    }

    public static function getForce($key, $else = null)
    {
        return static::getForceRef($key, $else);
    }

    public static function &getForceRef($key, $else = null)
    {
        return Arr::getForceRef($_SESSION, $key, $else);
    }

    public static function getArray($key, $else = null)
    {
        return static::getArrayRef($key, $else);
    }

    public static function &getArrayRef($key, $else = null)
    {
        return Arr::getArrayRef($_SESSION, $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        return static::getArrayForceRef($key, $else);
    }

    public static function &getArrayForceRef($key, $else = null)
    {
        return Arr::getArrayForceRef($_SESSION, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexRef($index, $else, $delimiter);
    }

    public static function &getIndexRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_SESSION, $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceRef($index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_SESSION, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_SESSION, $index, $else, $delimiter);
    }

    public static function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_SESSION, $index, $else, $delimiter);
    }

    public static function del($key)
    {
        return Arr::delRef($_SESSION, $key);
    }

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_SESSION, $index, $delimiter);
    }

    // End standard array methods

    public static function destroy()
    {
        static::start();

        return session_destroy();
    }
}
