<?php

namespace Greg\Support;

class Session
{
    private static $persistent = false;

    private static $flashKey = '__FLASH__';

    private static $flash = [];

    private static $flashLoaded = false;

    public static function reloadFlash()
    {
        $flash = static::getArray(self::$flashKey);

        static::del(self::$flashKey);

        self::$flashLoaded = true;

        return self::$flash = $flash;
    }

    public static function loadFlash()
    {
        if (!self::$flashLoaded) {
            static::reloadFlash();
        }

        return self::$flash;
    }

    public static function setFlash($key, $value = null)
    {
        static::loadFlash();

        $flash = &static::getArrayForceRef(self::$flashKey);

        if (is_array($key)) {
            $flash = array_merge($flash, $key);

            self::$flash = array_merge(self::$flash, $key);
        } else {
            $flash[$key] = $value;

            self::$flash[$key] = $value;
        }

        return $flash;
    }

    public static function getFlash($key = null)
    {
        static::loadFlash();

        if (func_num_args()) {
            return Arr::get(self::$flash, $key);
        }

        return self::$flash;
    }

    public static function unloadFlash()
    {
        static::loadFlash();

        self::$flash = [];

        self::$flashLoaded = false;

        return self::$flash;
    }

    public static function iniSet($var, $value)
    {
        return Server::iniSet('session.' . $var, $value);
    }

    public static function iniGet($var)
    {
        return Server::iniGet('session.' . $var);
    }

    public static function hasId()
    {
        return (bool) session_id();
    }

    public static function getId()
    {
        return static::start();
    }

    public static function setId($id)
    {
        return session_id($id);
    }

    public static function persistent($value = null)
    {
        if (func_num_args()) {
            self::$persistent = (bool) $value;
        }

        return self::$persistent;
    }

    public static function setName($name)
    {
        return session_name($name);
    }

    public static function getName()
    {
        return session_name();
    }

    public static function start()
    {
        if (!isset($_SESSION)) {
            session_start();

            if (static::persistent()) {
                static::resetLifetime();
            }
        }

        return session_id();
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

    public static function resetLifetime($time = null, $path = null, $domain = null, $secure = null, $httpOnly = null)
    {
        if ($time === null) {
            $time = static::iniGet('cookie_lifetime');
        }

        if ($path === null) {
            $path = static::iniGet('cookie_path');
        }

        if ($domain === null) {
            $domain = static::iniGet('cookie_domain');
        }

        if ($secure === null) {
            $secure = static::iniGet('cookie_secure');
        }

        if ($httpOnly === null) {
            $httpOnly = static::iniGet('cookie_httponly');
        }

        if ($time > 0) {
            $time += time();
        }

        return setcookie(static::getName(), static::getId(), $time, $path, $domain, $secure, $httpOnly);
    }

    // Start standard array methods

    public static function has($key = null)
    {
        static::start();

        return func_num_args() ? Arr::has($_SESSION, $key) : (bool) $_SESSION;
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::hasIndex($_SESSION, $index, $delimiter);
    }

    public static function set($key, $value)
    {
        static::start();

        return Arr::set($_SESSION, $key, $value);
    }

    public static function setRef($key, &$value)
    {
        static::start();

        return Arr::setRef($_SESSION, $key, $value);
    }

    public static function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::setIndex($_SESSION, $index, $value, $delimiter);
    }

    public static function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::setIndexRef($_SESSION, $index, $value, $delimiter);
    }

    public static function get($key = null, $else = null)
    {
        static::start();

        return func_num_args() ? Arr::get($_SESSION, $key, $else) : $_SESSION;
    }

    public static function &getRef($key = null, &$else = null)
    {
        static::start();

        if (func_num_args()) {
            return Arr::getRef($_SESSION, $key, $else);
        }

        return $_SESSION;
    }

    public static function getForce($key, $else = null)
    {
        static::start();

        return Arr::getForce($_SESSION, $key, $else);
    }

    public static function &getForceRef($key, &$else = null)
    {
        static::start();

        return Arr::getForceRef($_SESSION, $key, $else);
    }

    public static function getArray($key, $else = null)
    {
        static::start();

        return Arr::getArray($_SESSION, $key, $else);
    }

    public static function &getArrayRef($key, &$else = null)
    {
        static::start();

        return Arr::getArrayRef($_SESSION, $key, $else);
    }

    public static function getArrayForce($key, $else = null)
    {
        static::start();

        return Arr::getArrayForce($_SESSION, $key, $else);
    }

    public static function &getArrayForceRef($key, &$else = null)
    {
        static::start();

        return Arr::getArrayForceRef($_SESSION, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndex($_SESSION, $index, $else, $delimiter);
    }

    public static function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexRef($_SESSION, $index, $else, $delimiter);
    }

    public static function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexForce($_SESSION, $index, $else, $delimiter);
    }

    public static function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexForceRef($_SESSION, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexArray($_SESSION, $index, $else, $delimiter);
    }

    public static function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexArrayRef($_SESSION, $index, $else, $delimiter);
    }

    public static function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexArrayForce($_SESSION, $index, $else, $delimiter);
    }

    public static function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::getIndexArrayForceRef($_SESSION, $index, $else, $delimiter);
    }

    public static function del($key)
    {
        static::start();

        return Arr::del($_SESSION, $key);
    }

    public static function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        static::start();

        return Arr::delIndex($_SESSION, $index, $delimiter);
    }

    // End standard array methods

    public static function destroy()
    {
        static::start();

        $_SESSION = [];

        return true;
    }
}
