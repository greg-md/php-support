<?php

namespace Greg\Support;

use Greg\Support\Http\Request;

class Url
{
    const UA = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.0.3705; .NET CLR 1.1.4322)';

    public static function isFull($url)
    {
        return preg_match('#^(?:https?\:)?//#i', $url);
    }

    public static function full($url = '/')
    {
        if (static::isFull($url)) {
            return $url;
        }

        return static::fix(Request::clientHost() . $url, Request::isSecured());
    }

    public static function fix($url, $secured = false)
    {
        if (static::isFull($url)) {
            return $url;
        }

        return ($secured ? 'https' : 'http') . '://' . $url;
    }

    public static function fixShort($url)
    {
        if (static::isFull($url)) {
            return $url;
        }

        return '//' . $url;
    }

    public static function host($url, $stripWWW = true)
    {
        $url = self::fix($url);

        $host = parse_url($url, PHP_URL_HOST);

        if ($stripWWW and substr($host, 0, 4) == 'www.') {
            $host = substr($host, 4);
        }

        return $host;
    }

    public static function sameHost($url1, $url2, $level = 2)
    {
        return static::hostName($url1, $level) == static::hostName($url2, $level);
    }

    public static function hostName($url, $level = 2)
    {
        $url = static::fix($url);

        $host = parse_url($url, PHP_URL_HOST);

        $host = mb_strtolower($host);

        if (substr($host, 0, 4) == 'www.') {
            $host = substr($host, 4);
        }

        $parts = explode('.', $host);

        if ($level < count($parts)) {
            $host = implode('.', array_slice($parts, $level * -1, $level));
        }

        return $host;
    }

    public static function home($url)
    {
        $url = self::fix($url);

        $info = parse_url($url);

        return $info['scheme'] . '://' . $info['host'];
    }

    public static function removeQueryString($url)
    {
        list($url) = explode('?', $url, 2);

        return $url;
    }

    public static function serverRelative($url)
    {
        if (static::isFull($url) and parse_url($url, PHP_URL_HOST) == Request::serverHost()) {
            return parse_url($url, PHP_URL_PATH);
        }

        return $url;
    }

    public static function base($url = '/')
    {
        return Request::baseUri() . $url;
    }

    public static function addQuery($url, $query)
    {
        list($urlPath, $urlQuery) = array_pad(explode('?', $url, 2), 2, null);

        $allQuery = array_filter([$urlQuery, $query]);

        return $urlPath . ($allQuery ? '?' . implode('&', $allQuery) : '');
    }

    public static function init($url, $verbose = false)
    {
        $ch = curl_init(static::fix($url));

        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

        if ($verbose) {
            curl_setopt($ch, CURLOPT_VERBOSE, true);
        }

        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_setopt($ch, CURLOPT_MAXREDIRS, 5);

        curl_setopt($ch, CURLOPT_USERAGENT, static::UA);

        return $ch;
    }

    public static function effective($url)
    {
        $ch = static::init($url);

        curl_exec($ch);

        return curl_getinfo($ch, CURLINFO_EFFECTIVE_URL);
    }

    public static function contents($url)
    {
        $ch = static::init($url);

        return curl_exec($ch);
    }

    public static function transform($string, $type = Str::SPINAL_CASE)
    {
        $string = Str::replaceAccents($string);

        $replacement = [
            'а' => 'a', 'А' => 'A',
            'б' => 'b', 'Б' => 'B',
            'в' => 'v', 'В' => 'V',
            'г' => 'g', 'Г' => 'G',
            'д' => 'd', 'Д' => 'D',
            'е' => 'e', 'Е' => 'E',
            'ё' => 'yo', 'Ё' => 'YO',
            'ж' => 'j', 'Ж' => 'J',
            'з' => 'z', 'З' => 'Z',
            'и' => 'i', 'И' => 'I',
            'й' => 'i', 'Й' => 'I',
            'к' => 'k', 'К' => 'K',
            'л' => 'l', 'Л' => 'L',
            'м' => 'm', 'М' => 'M',
            'н' => 'n', 'Н' => 'N',
            'о' => 'o', 'О' => 'O',
            'п' => 'p', 'П' => 'P',
            'р' => 'r', 'Р' => 'R',
            'с' => 's', 'С' => 'S',
            'т' => 't', 'Т' => 'T',
            'у' => 'u', 'У' => 'U',
            'ф' => 'f', 'Ф' => 'F',
            'х' => 'h', 'Х' => 'H',
            'ц' => 'c', 'Ц' => 'C',
            'ч' => 'ch', 'Ч' => 'CH',
            'ш' => 'sh', 'Ш' => 'SH',
            'щ' => 'shi', 'Щ' => 'SHI',
            'ъ' => 'i', 'Ъ' => 'I',
            'ы' => 'y', 'Ы' => 'Y',
            'ь' => 'i', 'Ь' => 'I',
            'э' => 'e', 'Э' => 'E',
            'ю' => 'yu', 'Ю' => 'YU',
            'я' => 'ya', 'Я' => 'YA',
            'ă' => 'a', 'â' => 'a', 'î' => 'i', 'Ă' => 'A', 'Â' => 'A', 'Î' => 'I',
            'ş' => 's', 'ţ' => 't',
            'ț' => 't', 'ș' => 's', 'Ș' => 's', 'Ț' => 't',
        ];

        $string = strtr($string, $replacement);

        if ($type) {
            $string = Str::$type($string);
        }

        return $string;
    }
}
