<?php

namespace Greg\Support;

class Math
{
    static public function canonicalDivision($number)
    {
        $parts = explode('/', $number, 2);

        $up = (int)array_shift($parts);

        if (!$parts) {
            return $up;
        }

        $down = (int)array_shift($parts);

        if ($down === 0) {
            return $down;
        }

        if ($up === $down) {
            return 1;
        }

        $cf = $up / $down;

        if (round($cf) !== $cf) {
            $func = function($more, $less) use (&$func) {
                if ($more % $less === 0) {
                    return [$more / $less, 1];
                }

                $max = floor($less / 2);

                $newMore = $more;
                $newLess = $less;

                for($i = 2; $i <= $max; ++$i) {
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
                    return $func($newMore, $newLess);
                }

                return [$newMore, $newLess];
            };

            if ($up > $down) {
                list($up, $down) = $func($up, $down);
            } else {
                list($down, $up) = $func($down, $up);
            }
        }

        return $up . '/' . $down;
    }
}