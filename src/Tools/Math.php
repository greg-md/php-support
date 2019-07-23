<?php

namespace Greg\Support\Tools;

class Math
{
    public static function canonicalDivision($number)
    {
        $parts = explode('/', $number, 2);

        $up = (int) array_shift($parts);

        if (!$parts) {
            return $up;
        }

        $down = (int) array_shift($parts);

        if ($down === 0) {
            return $down;
        }

        if ($up === $down) {
            return 1;
        }

        $cf = $up / $down;

        if (round($cf) !== $cf) {
            if ($up > $down) {
                list($up, $down) = static::getMoreCanonical($up, $down);
            } else {
                list($down, $up) = static::getMoreCanonical($down, $up);
            }
        }

        return $up . ($down !== 1 ? '/' . $down : '');
    }

    protected static function getMoreCanonical($more, $less)
    {
        if ($more % $less === 0) {
            return [$more / $less, 1];
        }

        $max = floor($less / 2);

        $newMore = $more;
        $newLess = $less;

        for ($i = 2; $i <= $max; $i++) {
            if ($less % $i !== 0) {
                continue;
            }

            if ($more % $i === 0) {
                $newMore = $more / $i;
                $newLess = $less / $i;
                break;
            }
        }

        if ($newMore !== $more or $newLess !== $less) {
            return static::getMoreCanonical($newMore, $newLess);
        }

        return [$newMore, $newLess];
    }

    public static function cryptoRandSecure($min, $max)
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
}
