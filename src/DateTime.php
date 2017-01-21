<?php

namespace Greg\Support;

class DateTime extends \DateTime
{
    public static function yearInterval($start, $delimiter = ' - ')
    {
        $interval = $start;

        $y = date('Y');

        if ($y > $start) {
            $interval .= $delimiter . $y;
        }

        return $interval;
    }

    public static function transform($format, $time = 'now')
    {
        return date($format, static::timestamp($time));
    }

    public static function transformLocale($format, $time = 'now')
    {
        $string = strftime($format, static::timestamp($time));

        return static::fixCharset($string);
    }

    public static function timestamp($time)
    {
        return Str::isDigit($time) ? $time : strtotime($time);
    }

    public static function diffTime($time1, $time2 = 'now')
    {
        $time1 = static::timestamp($time1);

        $time2 = static::timestamp($time2);

        return ($time1 === $time2) ? 0 : ($time1 > $time2 ? 1 : -1);
    }

    public static function dateTimeString($time = 'now', $second = true)
    {
        return static::transform('Y-m-d H:i' . ($second ? ':s' : ''), $time);
    }

    public static function iso8601($time)
    {
        return static::transform('c', $time);
    }

    public static function dateString($time = 'now')
    {
        return static::transform('Y-m-d', $time);
    }

    public static function timeString($time = 'now', $second = true)
    {
        return static::transform('H:i' . ($second ? ':s' : ''), $time);
    }

    public static function year($time = 'now', $full = true)
    {
        return static::transform($full ? 'Y' : 'y', $time);
    }

    public static function month($time = 'now', $withZero = true)
    {
        return static::transform($withZero ? 'm' : 'n', $time);
    }

    public static function day($time = 'now', $withZero = true)
    {
        return static::transform($withZero ? 'd' : 'j', $time);
    }

    public static function untilNow($time)
    {
        return time() - static::timestamp($time);
    }

    /* Don't know the meaning of this methods.
    public static function passedTimeUntilNow($time, $interval)
    {
        return static::passedTimeUntil($time, $interval);
    }

    public static function passedTimeUntil($time, $interval, $until = 'now')
    {
        $time = static::toTimestamp($time);

        $until = static::toTimestamp($until);

        $newTime = strtotime($interval, $time);

        return $newTime <= $until;
    }
    */

    protected static function fixCharset($string)
    {
        if (PHP_OS == 'WINNT') {
            $string = iconv('windows-1251', 'UTF-8', $string);
        }

        return $string;
    }
}
