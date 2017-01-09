<?php

namespace Greg\Support;

class DateTime extends \DateTime
{
    public static function toCurrentYearInterval($start, $delimiter = ' - ')
    {
        $interval = $start;

        $y = date('Y');

        if ($y > $start) {
            $interval .= $delimiter . $y;
        }

        return $interval;
    }

    public static function formatTime($format, $time = 'now')
    {
        return date($format, static::toTimestamp($time));
    }

    public static function formatTimeLocale($format, $time = 'now')
    {
        $string = strftime($format, static::toTimestamp($time));

        return static::fixCharset($string);
    }

    public static function toTimestamp($time)
    {
        return Str::isDigit($time) ? $time : strtotime($time);
    }

    public static function diffTime($time1, $time2 = 'now')
    {
        $time1 = static::toTimestamp($time1);

        $time2 = static::toTimestamp($time2);

        return ($time1 === $time2) ? 0 : ($time1 > $time2 ? 1 : -1);
    }

    public static function toDateTimeString($time = 'now', $second = true)
    {
        return static::formatTime('Y-m-d H:i' . ($second ? ':s' : ''), $time);
    }

    public static function toISO8601($time)
    {
        return static::formatTime('c', $time);
    }

    public static function toDateString($time = 'now')
    {
        return static::formatTime('Y-m-d', $time);
    }

    public static function toTimeString($time = 'now', $second = true)
    {
        return static::formatTime('H:i' . ($second ? ':s' : ''), $time);
    }

    public static function toYearString($time = 'now', $full = true)
    {
        return static::formatTime($full ? 'Y' : 'y', $time);
    }

    public static function toMonthString($time = 'now', $withZero = true)
    {
        return static::formatTime($withZero ? 'm' : 'n', $time);
    }

    public static function toDayString($time = 'now', $withZero = true)
    {
        return static::formatTime($withZero ? 'd' : 'j', $time);
    }

    public static function untilNowTime($time)
    {
        return time() - static::toTimestamp($time);
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
