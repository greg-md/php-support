<?php

namespace Greg\Support;

class Str
{
    const ACCENTS = [
        'àáâãäåăâ' => 'a',
        'æ' => 'ae',
        'ç' => 'c',
        'èéêë' => 'e',
        'ìíîï' => 'i',
        'ð' => 'o',
        'ñ' => 'n',
        'òóôõöø' => 'o',
        'ùúûü' => 'u',
        '÷' => '-',
        'ýÿ' => 'y',
        'þ' => 'b',
        'œ' => 'oe',
        'šș' => 's',
        'ƒ' => 'f',
        'ț' => 't',
    ];

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

    public static function camelCase($string)
    {
        $string = static::extractWords($string);

        return str_replace(' ', '', ucwords($string));
    }

    public static function lowerCamelCase($string)
    {
        return lcfirst(static::camelCase($string));
    }

    protected static function prepareCase($string, $splitCamelCase = false)
    {
        $string = static::extractWords($string);

        if ($splitCamelCase) {
            $string = static::splitCamelCase($string);
        }

        return $string;
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

    protected static function preparePhpCase($string)
    {
        if (!$string or static::isDigit($string[0])) {
            $string = '_' . $string;
        }

        return $string;
    }

    public static function phpCamelCase($var)
    {
        return static::preparePhpCase(static::camelCase($var));
    }

    public static function phpLowerCamelCase($var)
    {
        return static::preparePhpCase(static::lowerCamelCase($var));
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

    public static function abbreviation($var)
    {
        $var = static::prepareCase($var);

        $var = ucwords($var);

        $var = explode(' ', $var);

        $var = array_map(function ($var) {
            return $var[0];
        }, $var);

        $var = implode('', $var);

        return $var;
    }

    public static function replace($search, $replace, $string)
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
            $string = static::replace($search, $replace, $string);
        }

        return $string;
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param string $pattern
     * @param string $value
     *
     * @return bool
     */
    public static function is($pattern, $value)
    {
        if ($pattern == $value) {
            return true;
        }

        $pattern = preg_quote($pattern, '#');

        // Asterisks are translated into zero-or-more regular expression wildcards
        // to make it convenient to check if the strings starts with the given
        // pattern such as "library/*", making any string check convenient.
        $pattern = str_replace('\*', '.*', $pattern);

        return (bool) preg_match('#^' . $pattern . '$#', $value);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param string       $haystack
     * @param string|array $needles
     *
     * @return bool
     */
    public static function startsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (strpos($haystack, $needle) === 0) {
                return true;
            }
        }

        return false;
    }

    public static function endsWith($haystack, $needles)
    {
        foreach ((array) $needles as $needle) {
            if (mb_substr($haystack, -mb_strlen($needle)) === $needle) {
                return true;
            }
        }

        return false;
    }

    public static function shift($str, $shift)
    {
        return mb_substr($str, mb_strlen($shift));
    }

    public static function quote($str, $with = '"')
    {
        return $with . $str . $with;
    }

    public static function isEmpty($var)
    {
        return $var === null or $var === '';
    }

    public static function isScalar($var)
    {
        return is_scalar($var) or is_null($var);
    }

    public static function split($string, $delimiter = '', $limit = null)
    {
        if (static::isEmpty($string)) {
            return [];
        }

        $args = [$delimiter, $string];

        if ($limit !== null) {
            $args[] = $limit;
        }

        return explode(...$args);
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

    protected static function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;

        /*
        if ($range < 0) {
            return $min;  // not so random...
        }
        */

        $log = log($range, 2);

        $bytes = (int) ($log / 8) + 1; // length in bytes

        $bits = (int) $log + 1; // length in bits

        $filter = (int) (1 << $bits) - 1; // set all lower bits to 1

        do {
            $random = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));

            $random = $random & $filter; // discard irrelevant bits
        } while ($random >= $range);

        return $min + $random;
    }

    public static function generate($length, $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $token = '';

        for ($i = 0; $i < $length; ++$i) {
            $token .= $characters[static::cryptoRandSecure(0, strlen($characters))];
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

    public static function isDigit($var)
    {
        return ctype_digit((string) $var);
    }

    public static function systemName($string)
    {
        $replacement = [
            'а' => 'a',
            'б' => 'b',
            'в' => 'v',
            'г' => 'g',
            'д' => 'd',
            'е' => 'e',
            'ё' => 'yo',
            'ж' => 'j',
            'з' => 'z',
            'и' => 'i',
            'й' => 'i',
            'к' => 'k',
            'л' => 'l',
            'м' => 'm',
            'н' => 'n',
            'о' => 'o',
            'п' => 'p',
            'р' => 'r',
            'с' => 's',
            'т' => 't',
            'у' => 'u',
            'ф' => 'f',
            'х' => 'h',
            'ц' => 'c',
            'ч' => 'ch',
            'ш' => 'sh',
            'щ' => 'shi',
            'ъ' => 'i',
            'ы' => 'y',
            'ь' => 'i',
            'э' => 'e',
            'ю' => 'yu',
            'я' => 'ya',
            'ă' => 'a',
            'â' => 'a',
            'î' => 'i',
            'șş' => 's',
            'țţ' => 't',
        ];

        $string = static::replaceAccents($string);

        foreach ($replacement as $search => $replace) {
            $string = static::replace($search, $replace, $string);
        }

        return static::spinalCase($string, true);
    }
}
