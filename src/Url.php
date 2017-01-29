<?php

namespace Greg\Support;

use Greg\Support\Http\Request;

class Url
{
    const UA = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

    public static function hasSchema($absolute)
    {
        return (bool) preg_match('#^(?:https?\:)?//#i', $absolute);
    }

    public static function noSchema($absolute)
    {
        if (preg_match('#^(?:https?\:)?//(.+)#i', $absolute, $matches)) {
            $absolute = $matches[1];
        }

        return $absolute;
    }

    public static function schema($absolute)
    {
        return static::currentSchema() . static::noSchema($absolute);
    }

    public static function shorted($absolute)
    {
        return '//' . static::noSchema($absolute);
    }

    public static function secured($absolute)
    {
        return 'https://' . static::noSchema($absolute);
    }

    public static function unsecured($absolute)
    {
        return 'http://' . static::noSchema($absolute);
    }

    public static function schemly($absolute)
    {
        return static::hasSchema($absolute) ? $absolute : static::currentSchema() . $absolute;
    }

    public static function shortly($absolute)
    {
        return static::hasSchema($absolute) ? $absolute : '//' . $absolute;
    }

    public static function securely($absolute)
    {
        return static::hasSchema($absolute) ? $absolute : 'https://' . $absolute;
    }

    public static function unsecurely($absolute)
    {
        return static::hasSchema($absolute) ? $absolute : 'http://' . $absolute;
    }

    public static function absolute($relative)
    {
        if (static::hasSchema($relative)) {
            return $relative;
        }

        return static::schema((Request::clientHost() ?: 'localhost') . $relative);
    }

    public static function relative($absolute)
    {
        return parse_url(static::shortly($absolute), PHP_URL_PATH);
    }

    public static function serverRelative($absolute)
    {
        if (parse_url($abs = static::shortly($absolute), PHP_URL_HOST) == Request::serverHost()) {
            return parse_url($abs, PHP_URL_PATH);
        }

        return $absolute;
    }

    public static function host($absolute, $stripWWW = true)
    {
        $host = parse_url(self::shortly($absolute), PHP_URL_HOST);

        if ($stripWWW and substr($host, 0, 4) == 'www.') {
            $host = substr($host, 4);
        }

        return $host;
    }

    public static function hostLevel($absolute, $level = 2, $stripWWW = true)
    {
        $host = parse_url(static::shortly($absolute), PHP_URL_HOST);

        $host = mb_strtolower($host);

        if ($stripWWW and substr($host, 0, 4) == 'www.') {
            $host = substr($host, 4);
        }

        $parts = explode('.', $host);

        if ($level < count($parts)) {
            $host = implode('.', array_slice($parts, $level * -1, $level));
        }

        return $host;
    }

    public static function hostEquals($absolute1, $absolute2, $level = 2)
    {
        return static::hostLevel($absolute1, $level) === static::hostLevel($absolute2, $level);
    }

    public static function root($absolute)
    {
        if (!$hasSchema = static::hasSchema($absolute)) {
            $absolute = static::unsecured($absolute);
        }

        $info = parse_url($absolute);

        $root = $info['host'];

        if ($hasSchema) {
            $root = (isset($info['scheme']) ? $info['scheme'] . '://' : '//') . $root;
        }

        return $root;
    }

    public static function removeQueryString($url)
    {
        list($url) = explode('?', $url, 2);

        return $url;
    }

    public static function base($path = '/', $absolute = false)
    {
        $relative = Request::baseUri() . $path;

        if ($absolute) {
            return static::absolute($relative);
        }

        return $relative;
    }

    public static function addQuery($url, $query)
    {
        list($url, $urlQuery) = array_pad(explode('?', $url, 2), 2, null);

        if (is_array($query)) {
            $query = http_build_query($query);
        }

        if ($query = array_filter([$urlQuery, $query])) {
            $url .= '?' . implode('&', $query);
        }

        return $url;
    }

    public static function init($absolute, $verbose = false)
    {
        $handle = curl_init(static::schemly($absolute));

        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

        if ($verbose) {
            curl_setopt($handle, CURLOPT_VERBOSE, true);
        }

        curl_setopt($handle, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($handle, CURLOPT_MAXREDIRS, 5);

        curl_setopt($handle, CURLOPT_USERAGENT, static::UA);

        return $handle;
    }

    public static function effective($absolute)
    {
        $handle = static::init($absolute);

        curl_exec($handle);

        return curl_getinfo($handle, CURLINFO_EFFECTIVE_URL);
    }

    public static function contents($absolute)
    {
        return curl_exec(static::init($absolute));
    }

    protected static function currentSchema()
    {
        return (Request::isSecured() ? 'https' : 'http') . '://';
    }
}
