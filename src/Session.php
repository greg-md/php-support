<?php

namespace Greg\Support;

class Session
{
    private static $persistent = false;

    private static $handler = null;

    private static $flashKey = '__FLASH__';

    private static $flash = [];

    private static $flashLoaded = false;

    public static function reloadFlash()
    {
        $flash = static::get(static::$flashKey);

        static::del(static::$flashKey);

        static::$flashLoaded = true;

        return static::$flash = $flash;
    }

    public static function loadFlash()
    {
        if (!static::$flashLoaded) {
            static::reloadFlash();
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
            return Arr::get($flash, $key);
        }

        return $flash;
    }

    public static function setIniMore(array $config)
    {
        foreach ($config as $key => $value) {
            static::setIni($key, $value);
        }

        return true;
    }

    public static function setIni($var, $value)
    {
        return ServerIni::set('session.' . $var, $value);
    }

    public static function getIni($var)
    {
        return ServerIni::get('session.' . $var);
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
            static::$persistent = (bool) $value;
        }

        return static::$persistent;
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

    public static function decode($data, $return = false)
    {
        return $return ? static::unserialize($data) : session_decode($data);
    }

    public static function resetLifetime($time = null, $path = null, $domain = null, $secure = null, $httpOnly = null)
    {
        if ($time === null) {
            $time = static::getIni('cookie_lifetime');
        }

        if ($path === null) {
            $path = static::getIni('cookie_path');
        }

        if ($domain === null) {
            $domain = static::getIni('cookie_domain');
        }

        if ($secure === null) {
            $secure = static::getIni('cookie_secure');
        }

        if ($httpOnly === null) {
            $httpOnly = static::getIni('cookie_httponly');
        }

        if ($time > 0) {
            $time += time();
        }

        return setcookie(static::getName(), static::getId(), $time, $path, $domain, $secure, $httpOnly);
    }

    public static function setSaveHandler(\SessionHandlerInterface $handler, $registerShutdown = true)
    {
        session_set_save_handler($handler, $registerShutdown);

        static::$handler = $handler;

        return true;
    }

    public static function getSaveHandler()
    {
        return static::$handler;
    }

    // Start standard array methods

    public static function has($key = null)
    {
        static::start();

        return func_num_args() ? Arr::has($_SESSION, $key) : (bool) $_SESSION;
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

    public static function del($key)
    {
        static::start();

        return Arr::del($_SESSION, $key);
    }

    // End standard array methods

    public static function destroy()
    {
        static::start();

        return session_destroy();
    }
}
