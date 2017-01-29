<?php

namespace Greg\Support;

use Greg\Support\Tools\Math;

class Str
{
    const ACCENTS = [
        'àáâãäåăâ' => 'a',
        'æ'        => 'ae',
        'ç'        => 'c',
        'èéêë'     => 'e',
        'ìíîï'     => 'i',
        'ð'        => 'o',
        'ñ'        => 'n',
        'òóôõöø'   => 'o',
        'ùúûü'     => 'u',
        '÷'        => '-',
        'ýÿ'       => 'y',
        'þ'        => 'b',
        'œ'        => 'oe',
        'šș'       => 's',
        'ƒ'        => 'f',
        'ț'        => 't',
    ];

    public static function camelCase($string)
    {
        $string = static::extractWords($string);

        return str_replace(' ', '', ucwords($string));
    }

    public static function lowerCamelCase($string)
    {
        return lcfirst(static::camelCase($string));
    }

    public static function snakeCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '_', $string);
    }

    public static function lowerSnakeCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '_', mb_strtolower($string));
    }

    public static function upperSnakeCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '_', mb_strtoupper($string));
    }

    public static function upperWordsSnakeCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '_', ucwords(mb_strtolower($string)));
    }

    public static function kebabCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '-', $string);
    }

    public static function spinalCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '-', mb_strtolower($string));
    }

    public static function trainCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '-', ucwords(mb_strtolower($string)));
    }

    public static function lispCase($string, $splitCamelCase = false)
    {
        $string = static::prepareCase($string, $splitCamelCase);

        return str_replace(' ', '-', ucfirst(mb_strtolower($string)));
    }

    public static function phpCamelCase($string)
    {
        return static::preparePhpCase(static::camelCase($string));
    }

    public static function phpLowerCamelCase($string)
    {
        return static::preparePhpCase(static::lowerCamelCase($string));
    }

    public static function phpSnakeCase($string, $splitCamelCase = false)
    {
        return static::preparePhpCase(static::snakeCase($string, $splitCamelCase));
    }

    public static function phpLowerSnakeCase($string, $splitCamelCase = false)
    {
        return static::preparePhpCase(static::lowerSnakeCase($string, $splitCamelCase));
    }

    public static function phpUpperSnakeCase($string, $splitCamelCase = false)
    {
        return static::preparePhpCase(static::upperSnakeCase($string, $splitCamelCase));
    }

    public static function phpUpperWordsSnakeCase($string, $splitCamelCase = false)
    {
        return static::preparePhpCase(static::upperWordsSnakeCase($string, $splitCamelCase));
    }

    public static function abbreviation($string)
    {
        $string = static::prepareCase($string);

        $string = mb_strtolower($string);

        $string = explode(' ', $string);

        $string = array_diff($string, ['to', 'the']);

        $string = array_map(function ($string) {
            return $string[0];
        }, $string);

        $string = implode('', $string);

        return mb_strtoupper($string);
    }

    public static function replaceLetters($string, $search, $replace)
    {
        $lower = preg_split('//u', mb_strtolower($search), null, PREG_SPLIT_NO_EMPTY);

        $string = str_replace($lower, mb_strtolower($replace), $string);

        $upper = preg_split('//u', mb_strtoupper($search), null, PREG_SPLIT_NO_EMPTY);

        $string = str_replace($upper, mb_strtoupper($replace), $string);

        return $string;
    }

    public static function replaceAccents($string)
    {
        foreach (static::ACCENTS as $search => $replace) {
            $string = static::replaceLetters($string, $search, $replace);
        }

        return $string;
    }

    public static function is($string, $pattern)
    {
        if ($pattern == $string) {
            return true;
        }

        $pattern = preg_quote($pattern, '#');

        // Asterisks are translated into zero-or-more regular expression wildcards
        // to make it convenient to check if the strings starts with the given
        // pattern such as "library/*", making any string check convenient.
        $pattern = str_replace('\*', '.*', $pattern);

        return (bool) preg_match('#^' . $pattern . '$#', $string);
    }

    public static function startsWith($string, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (strpos($string, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    public static function endsWith($string, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (mb_substr($string, -mb_strlen($needle)) === $needle) {
                return true;
            }
        }

        return false;
    }

    public static function shift($string, $shift)
    {
        return mb_substr($string, mb_strlen($shift));
    }

    public static function pop($string, $pop)
    {
        return mb_substr($string, 0, mb_strlen($string) - mb_strlen($pop));
    }

    public static function quote($string, $start = '"', $end = null)
    {
        if ($end === null) {
            $end = $start;
        }

        return $start . $string . $end;
    }

    public static function split($string, $delimiter = '', $limit = null)
    {
        if (static::isEmpty($string)) {
            return [];
        }

        if (static::isEmpty($delimiter)) {
            return preg_split('//u', $string, $limit, PREG_SPLIT_NO_EMPTY);
        }

        if ($limit === null) {
            $limit = PHP_INT_MAX;
        }

        return explode($delimiter, $string, $limit);
    }

    public static function splitPath($string, $limit = null)
    {
        return static::split(trim($string, '/'), '/', $limit);
    }

    public static function splitQuoted($string, $delimiter = ',', $quotes = '"')
    {
        $string = static::split($string, $delimiter);

        $string = array_map(function ($column) use ($quotes) {
            return trim(trim($column), $quotes);
        }, $string);

        return $string;
    }

    public static function parse($string, $delimiter = '&', $keyValueDelimiter = '=')
    {
        if ($delimiter === '&' and $keyValueDelimiter === '=') {
            parse_str($string, $output);

            return $output;
        }

        $output = [];

        foreach (explode($delimiter, $string) as $part) {
            list($key, $value) = explode($keyValueDelimiter, $part);

            $output[$key] = $value;
        }

        return $output;
    }

    public static function generate($length, $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $token = '';

        for ($i = 0; $i < $length; ++$i) {
            $token .= $characters[Math::cryptoRandSecure(0, strlen($characters))];
        }

        return $token;
    }

    public static function nth($number)
    {
        if ($number > 3 && $number < 21) {
            return $number . 'th';
        }

        switch ($number % 10) {
            case 1:  return $number . 'st';
            case 2:  return $number . 'nd';
            case 3:  return $number . 'rd';
            default: return $number . 'th';
        }
    }

    public static function systemName($string)
    {
        $replacement = [
            'а'  => 'a',
            'б'  => 'b',
            'в'  => 'v',
            'г'  => 'g',
            'д'  => 'd',
            'е'  => 'e',
            'ё'  => 'yo',
            'ж'  => 'j',
            'з'  => 'z',
            'и'  => 'i',
            'й'  => 'i',
            'к'  => 'k',
            'л'  => 'l',
            'м'  => 'm',
            'н'  => 'n',
            'о'  => 'o',
            'п'  => 'p',
            'р'  => 'r',
            'с'  => 's',
            'т'  => 't',
            'у'  => 'u',
            'ф'  => 'f',
            'х'  => 'h',
            'ц'  => 'c',
            'ч'  => 'ch',
            'ш'  => 'sh',
            'щ'  => 'shi',
            'ъ'  => 'i',
            'ы'  => 'y',
            'ь'  => 'i',
            'э'  => 'e',
            'ю'  => 'yu',
            'я'  => 'ya',
            'ă'  => 'a',
            'â'  => 'a',
            'î'  => 'i',
            'șş' => 's',
            'țţ' => 't',
        ];

        $string = static::replaceAccents($string);

        foreach ($replacement as $search => $replace) {
            $string = static::replaceLetters($string, $search, $replace);
        }

        return static::spinalCase($string, true);
    }

    public static function parseUrls($string, callable $callable)
    {
        $regex = '(?:(?:(?:(?:https?|ftps?)\:)?\/\/)|www\.)?(?:[a-z0-9](?:[a-z0-9\-]{0,61}[a-z0-9])?\.)+[a-z]{2,8}(?:(?:\/|\?)\S*[a-z0-9-_])?';

        return preg_replace_callback('#(' . $regex . ')#i', function ($matches) use ($callable) {
            return call_user_func_array($callable, [$matches[1], Url::schema($matches[1])]);
        }, $string);
    }

    public static function isEmpty($var)
    {
        return $var === null or $var === '';
    }

    public static function isScalar($var)
    {
        return is_scalar($var) or is_null($var);
    }

    public static function isDigit($var)
    {
        return ctype_digit((string) $var);
    }

    protected static function extractWords($string, $delimiter = ' ')
    {
        $string = preg_replace('#[^a-z0-9]+#i', $delimiter, $string);

        $string = trim(trim($string), $delimiter);

        return $string;
    }

    protected static function splitCamelCase($string, $delimiter = ' ')
    {
        return preg_replace('#([a-z0-9]+)([A-Z]+)#', '$1' . $delimiter . '$2', $string);
    }

    protected static function prepareCase($string, $splitCamelCase = false)
    {
        $string = static::extractWords($string);

        if ($splitCamelCase) {
            $string = static::splitCamelCase($string);
        }

        return $string;
    }

    protected static function preparePhpCase($string)
    {
        if (!$string or static::isDigit($string[0])) {
            $string = '_' . $string;
        }

        return $string;
    }
}
