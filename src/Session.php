<?php

namespace Greg\Support;

class Session
{
    static protected $persistent = false;

    static protected $handler = null;

    static protected $flashKey = '__FLASH__';

    static protected $flash = [];

    static protected $flashLoaded = false;

    static public function reloadFlash()
    {
        $flash = static::get(static::$flashKey);

        static::del(static::$flashKey);

        return static::$flash = $flash;
    }

    static public function loadFlash()
    {
        if (!static::$flashLoaded) {
            static::reloadFlash();

            static::$flashLoaded = true;
        }

        return static::$flash;
    }

    static public function setFlash($key, $value = null)
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

    static public function getFlash($key = null)
    {
        static::loadFlash();

        $flash = &static::getForceRef(static::$flashKey);

        if (func_num_args()) {
            return Arr::getRef($flash, $key);
        }

        return $flash;
    }

    static public function ini($var, $value = null)
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

    static public function iniSet($var, $value)
    {
        return ServerIni::set('session.' . $var, $value);
    }

    static public function iniGet($var)
    {
        return ServerIni::get('session.' . $var);
    }

    static public function id($id = null)
    {
        return session_id(...func_get_args());
    }

    static public function getId()
    {
        static::start();

        return static::id();
    }

    static public function persistent($value = null)
    {
        if (func_num_args()) {
            static::$persistent = (bool)$value;
        }

        return static::$persistent;
    }

    static public function name($name = null)
    {
        return session_name(...func_get_args());
    }

    static public function start()
    {
        if (!isset($_SESSION)) {
            session_start();

            if (static::persistent()) {
                static::resetLifetime();
            }
        }

        return true;
    }

    static public function unserialize($data)
    {
        return static::unserializePart($data);
    }

    static protected function unserializePart($data, $startIndex = 0, &$dict = null)
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

    static public function decode($data, $return = false)
    {
        return $return ? static::unserialize($data) : session_decode($data);
    }

    static public function resetLifetime($time = null, $path = null, $domain = null, $secure = null, $httpOnly = null)
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

    static public function saveHandler($handler = null)
    {
        if ($handler !== null) {
            session_set_save_handler($handler);

            static::$handler = $handler;
        }

        return static::$handler;
    }

    // Start standard array methods

    static public function is()
    {
        return (bool)$_SESSION;
    }

    static public function all()
    {
        return $_SESSION;
    }

    static public function has($key)
    {
        return Arr::hasRef($_SESSION, $key);
    }

    static public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_SESSION, $index, $delimiter);
    }

    static public function set($key, $value)
    {
        return static::setRef($key, $value);
    }

    static public function setRef($key, &$value)
    {
        return Arr::setRefValueRef($_SESSION, $key, $value);
    }

    static public function setIndex($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexRef($index, $value, $delimiter);
    }

    static public function setIndexRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_SESSION, $index, $value, $delimiter);
    }

    static public function get($key, $else = null)
    {
        return static::getRef($key, $else);
    }

    static public function &getRef($key, $else = null)
    {
        return Arr::getRef($_SESSION, $key, $else);
    }

    static public function getForce($key, $else = null)
    {
        return static::getForceRef($key, $else);
    }

    static public function &getForceRef($key, $else = null)
    {
        return Arr::getForceRef($_SESSION, $key, $else);
    }

    static public function getArray($key, $else = null)
    {
        return static::getArrayRef($key, $else);
    }

    static public function &getArrayRef($key, $else = null)
    {
        return Arr::getArrayRef($_SESSION, $key, $else);
    }

    static public function getArrayForce($key, $else = null)
    {
        return static::getArrayForceRef($key, $else);
    }

    static public function &getArrayForceRef($key, $else = null)
    {
        return Arr::getArrayForceRef($_SESSION, $key, $else);
    }

    static public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexRef($index, $else, $delimiter);
    }

    static public function &getIndexRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_SESSION, $index, $else, $delimiter);
    }

    static public function getIndexForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceRef($index, $else, $delimiter);
    }

    static public function &getIndexForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_SESSION, $index, $else, $delimiter);
    }

    static public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_SESSION, $index, $else, $delimiter);
    }

    static public function getIndexArrayForce($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayForceRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_SESSION, $index, $else, $delimiter);
    }

    static public function del($key)
    {
        return Arr::delRef($_SESSION, $key);
    }

    static public function delIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_SESSION, $index, $delimiter);
    }

    // End standard array methods

    static public function destroy()
    {
        static::start();

        return session_destroy();
    }
}