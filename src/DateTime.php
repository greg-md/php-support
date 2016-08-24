<?php

namespace Greg\Support;

class DateTime extends \DateTime
{
    static public function toCurrentYearInterval($start, $delimiter = ' - ')
    {
        $interval = $start;

        $y = date('Y');

        if ($y > $start) {
            $interval .= $delimiter . $y;
        }

        return $interval;
    }

    static public function formatTime($format, $time = 'now')
    {
        return date($format, static::toTimestamp($time));
    }

    static public function formatTimeLocale($format, $time = 'now')
    {
        $string = strftime($format, static::toTimestamp($time));

        if (PHP_OS == 'WINNT') {
            $string = iconv('windows-1251', 'UTF-8', $string);
        }

        return $string;
    }

    static public function toTimestamp($time)
    {
        return Str::isNaturalNumber($time) ? $time : strtotime($time);
    }

    static public function diffTime($time1, $time2 = 'now')
    {
        $time1 = static::toTimestamp($time1);

        $time2 = static::toTimestamp($time2);

        return ($time1 === $time2) ? 0 : ($time1 > $time2 ? 1 : -1);
    }

    static public function toStringDateTime($time = 'now', $second = true)
    {
        return static::formatTime('Y-m-d H:i' . ($second ? ':s' : ''), $time);
    }

    static public function toISO8601($time)
    {
        return static::formatTime('c', $time);
    }

    static public function toStringDate($time = 'now')
    {
        return static::formatTime('Y-m-d', $time);
    }

    static public function toStringTime($time = 'now', $second = true)
    {
        return static::formatTime('H:i' . ($second ? ':s' : ''), $time);
    }

    static public function untilNowTime($time)
    {
        return time() - static::toTimestamp($time);
    }

    static public function passedTimeUntilNow($time, $interval)
    {
        return static::passedTimeUntil($time, $interval);
    }

    static public function passedTimeUntil($time, $interval, $until = 'now')
    {
        $time = static::toTimestamp($time);

        $until = static::toTimestamp($until);

        $newTime = strtotime($interval, $time);

        return $newTime <= $until;
    }
}