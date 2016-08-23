<?php

namespace Greg\Support;

class Str
{
    const SPLIT_CASE = 'splitCase';

    const SPLIT_UPPER_CASE = 'splitUpperCase';

    const CAMEL_CASE = 'camelCase';

    const TRAIN_CASE = 'trainCase';

    const SPINAL_CASE = 'spinalCase';

    static public function splitCase($var, $delimiter = ' ')
    {
        $var = preg_replace('#[^a-z0-9]+#i', $delimiter, $var);

        $var = trim($var);

        $var = trim($var, $delimiter);

        return $var;
    }

    static public function splitUpperCase($var, $delimiter = ' ')
    {
        $var = static::splitCase($var, $delimiter);

        $var = preg_replace('#([a-z]+)([A-Z]+)#', '$1' . $delimiter . '$2', $var);

        return $var;
    }

    static public function camelCase($var)
    {
        $var = static::splitCase($var);

        $var = ucwords($var);

        $var = str_replace(' ', '', $var);

        return $var;
    }

    static public function trainCase($var, $delimiter = '-')
    {
        $var = static::splitUpperCase($var);

        $var = ucwords($var);

        if ($delimiter !== ' ') {
            $var = str_replace(' ', $delimiter, $var);
        }

        return $var;
    }

    static public function spinalCase($var, $uppercase = true)
    {
        return mb_strtolower($uppercase ? static::splitUpperCase($var, '-') : static::splitCase($var, '-'));
    }

    static public function phpName($var, $type = self::CAMEL_CASE)
    {
        $var = static::$type($var);

        if (!$var or Type::isNaturalNumber($var[0])) {
            $var = '_' . $var;
        }

        return $var;
    }

    static public function abbreviation($var)
    {
        $var = static::splitUpperCase($var);

        $var = ucwords($var);

        $var = explode(' ', $var);

        $var = array_map(function($var) {
            return $var[0];
        }, $var);

        $var = implode('', $var);

        return $var;
    }

    static public function replaceAccents($str)
    {
        $search = explode(',', 'ç,æ,œ,á,é,í,ó,ú,à,è,ì,ò,ù,ä,ë,ï,ö,ü,ÿ,â,ê,î,ô,û,å,ø,Ø,Å,Á,À,Â,Ä,È,É,Ê,Ë,Í,Î,Ï,Ì,Ò,Ó,Ô,Ö,Ú,Ù,Û,Ü,Ÿ,Ç,Æ,Œ');

        $replace = explode(',', 'c,ae,oe,a,e,i,o,u,a,e,i,o,u,a,e,i,o,u,y,a,e,i,o,u,a,o,O,A,A,A,A,A,E,E,E,E,I,I,I,I,O,O,O,O,U,U,U,U,Y,C,AE,OE');

        return str_replace($search, $replace, $str);
    }

    /**
     * Determine if a given string matches a given pattern.
     *
     * @param  string  $pattern
     * @param  string  $value
     * @return bool
     */
    static public function is($pattern, $value)
    {
        if ($pattern == $value) return true;

        $pattern = preg_quote($pattern, '#');

        // Asterisks are translated into zero-or-more regular expression wildcards
        // to make it convenient to check if the strings starts with the given
        // pattern such as "library/*", making any string check convenient.
        $pattern = str_replace('\*', '.*', $pattern);

        return (bool)preg_match('#^' . $pattern . '$#', $value);
    }

    /**
     * Determine if a given string starts with a given substring.
     *
     * @param  string  $haystack
     * @param  string|array  $needles
     * @return bool
     */
    static public function startsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if (strpos($haystack, $needle) === 0) return true;
            //if (mb_substr($haystack, 0, mb_strlen($needle)) === $needle) return true;
        }

        return false;
    }

    static public function endsWith($haystack, $needles)
    {
        foreach ((array)$needles as $needle) {
            if (mb_substr($haystack, -mb_strlen($needle)) === $needle) return true;
        }

        return false;
    }

    static public function shift($str, $shift)
    {
        return mb_substr($str, mb_strlen($shift));
    }

    static public function quote($str, $with = '"')
    {
        return $with . $str . $with;
    }

    static public function splitPath($string, $delimiter = '/', $limit = null)
    {
        $string = trim($string, $delimiter);

        return static::split($string, $delimiter, $limit);
    }

    static public function split($string, $delimiter = '', $limit = null)
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

    static public function splitQuoted($string, $delimiter = ',', $quotes = '"')
    {
        $string = static::split($string, $delimiter);

        $string = array_map(function($column) use ($quotes) {
            return trim($column, $quotes);
        }, $string);

        return $string;
    }

    static public function isEmpty($var)
    {
        return $var === null or $var === '';
    }

    static public function isScalar($var)
    {
        return is_scalar($var) or is_null($var);
    }

    static public function parse($string, $delimiter = '&', $keyValueDelimiter = '=')
    {
        if ($delimiter === '&' and $keyValueDelimiter === '=') {
            parse_str($string, $output);

            return $output;
        }

        $output = [];

        foreach(explode($delimiter, $string) as $part) {
            list($key, $value) = explode($keyValueDelimiter, $part);

            $output[$key] = $value;
        }

        return $output;
    }

    static public function substringHtml($string, $start = 0, $length = null, $delimiter = null, $suffix = null, $forceSuffix = null)
    {
        $textLength = mb_strlen(strip_tags(html_entity_decode($string, ENT_QUOTES, 'UTF-8')));

        if (!$textLength) {
            return $string;
        }

        if (is_null($length)) {
            $length = mb_strlen(html_entity_decode($string, ENT_QUOTES, 'UTF-8')) - $start;
        }

        $delimiter = (array)$delimiter;

        $string = '>' . $string . '<';

        $newString  = '';

        $remainString = '';

        $strLen = 0;

        $delimiterFound = false;

        $k = 0;

        preg_replace_callback('#>([^<]+)<#s', function($match)
            use(&$string, &$newString, &$remainString, $start, $length,
                $delimiter, $suffix, $forceSuffix, $textLength,
                &$strLen, &$delimiterFound, &$k) {
            $index = mb_strpos($string, $match[0]);

            if ($index) {
                $subStrNew = mb_substr($string, 1, $index);
            } else {
                $subStrNew = '';
            }

            $string = '>' . mb_substr($string, mb_strlen($subStrNew) + 1 + mb_strlen($match[1]));

            if ($strLen >= $length and (!$delimiter or $delimiterFound)) {
                $remainString .= $subStrNew;
                return '><';
            }

            $subStr = max(0, ($start - $strLen));

            if ($subStr) {
                while(true) {
                    $replaced = preg_replace(array(
                        '#<[^/][^>]*/>#s',
                        '#<[^/][^>]*(?<!/)></[^>]+>#s',
                    ), '', $subStrNew);

                    if ($replaced == $subStrNew) {
                        break;
                    }

                    $subStrNew = $replaced;
                };
            }

            $newString .= $subStrNew;

            $htmlStr = html_entity_decode($match[1], ENT_QUOTES, 'UTF-8');

            $htmlStrLen = mb_strlen($htmlStr);

            if ($htmlStrLen <= $subStr) {
                $strLen += $htmlStrLen;
                return '><';
            }

            $subLen = $length - $strLen;

            if ($subLen < 0) {
                $subLen = 0;
            }

            $dFetch = false;

            $del = null;

            if ($delimiter and $htmlStrLen > $subLen) {
                $offset = $subLen + $subStr;

                $pos = false;

                if ($offset < $htmlStrLen) {
                    $offset -= 1;

                    if ($offset < 0) {
                        $offset = 0;
                    }

                    foreach($delimiter as $del => $dFetch) {
                        if (is_int($del)) {
                            $del = $dFetch;

                            $dFetch = true;
                        }

                        $pos = mb_strpos($htmlStr, $del, $offset);

                        if ($pos !== false) {
                            break;
                        }
                    }
                }

                if ($pos !== false) {
                    $delimiterFound = true;

                    $subLen = $pos;
                } else {
                    $subLen = $htmlStrLen;
                }
            }

            $htmlStr = mb_substr($htmlStr, $subStr, $subLen);

            $strLen += mb_strlen($htmlStr);

            $htmlStr = htmlentities($htmlStr, ENT_QUOTES, 'UTF-8');

            if (($forceSuffix and $strLen >= $textLength) or ($suffix and $strLen >= $length and (!$delimiter or $delimiterFound))) {
                if ($delimiter and $dFetch) {
                    $suffix = str_replace('%d%', $del, $suffix);
                }

                $htmlStr .= $suffix;
            }

            $newString .= $htmlStr;

            ++$k;

            return '>' . $htmlStr . '<';
        }, $string);

        $string = ltrim($string, '>');

        $string = rtrim($string, '<');

        $string = trim($string);

        if ($remainString) {
            $remainString .= $string;

            while(true) {
                $replaced = preg_replace(array(
                    '#<[^/][^>]*/>#s',
                    '#<([^\s>]*)(\b)?[^>]*(?<!/)></\1>#si',
                    '#<(area|base|br|col|command|embed|hr|img|input|keygen|link|meta|param|source|track|wbr|basefont|bgsound|frame|isindex)\b[^>]*>#si',
                ), '', $remainString);

                if ($replaced == $remainString) {
                    break;
                }

                $remainString = $replaced;
            };
        } else {
            $remainString .= $string;
        }

        $return = $newString . $remainString;

        return $return;
    }

    static public function cutHtmlTag($html, $tag, $offset = 0, $limit = null, $cleanAfter = false)
    {
        // match html tag: <(\w)[^>]*(?<!\/)(\/>|>.*?<\/\1>)
        $regex = '<(' . preg_quote($tag, '#') . ')[^>]*(?<!\/)(\/>|>.*?<\/\1>)';

        $pregLimit = $cleanAfter ? abs($offset) + 1 : -1;

        $count = 0;

        $lastClean = $cleanAfter ? uniqid('cut_', true) : null;

        $html = preg_replace_callback('#' . $regex . '#i', function($matches) use (&$count, $offset, $limit, $lastClean) {
            ++$count;

            if ($count > $offset and ($limit < 1 or ($count <= ($offset + $limit)))) {
                return $lastClean;
            }

            return $matches[0];
        }, $html, $pregLimit);

        if ($cleanAfter and $count > $offset) {
            $html = static::substringHtml($html, 0, 0, $lastClean);
        }

        return $html;
    }

    static public function cryptoRandSecure($min, $max)
    {
        $range = $max - $min;

        if ($range < 0) {
            return $min;  // not so random...
        }

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

    static public function generate($length, $characters = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789')
    {
        $token = '';

        for($i = 0; $i < $length; ++$i) {
            $token .= $characters[static::cryptoRandSecure(0, strlen($characters))];
        }

        return $token;
    }

    static public function nth($number)
    {
        if($number > 3 && $number < 21) {
            return $number . 'th';
        }

        switch ($number % 10) {
            case 1:  return $number . 'st';
            case 2:  return $number . 'nd';
            case 3:  return $number . 'rd';
            default: return $number . 'th';
        }
    }
}