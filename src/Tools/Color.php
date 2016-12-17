<?php

namespace Greg\Support\Tools;

class Color
{
    public static function generate($point, $palette = [0 => 'f00', 50 => '0f0', 100 => '00f'])
    {
        ksort($palette);

        $lowerP = key($palette);

        foreach ($palette as $p => $upper) {
            if ($point <= $p) {
                $range = $p - $lowerP;

                if ($range < 1) {
                    $range = 1;
                }

                $rangePct = ($point - $lowerP) / $range;

                $pctLower = 1 - $rangePct;

                $pctUpper = $rangePct;

                $lower = $palette[$lowerP];

                list($lowerR, $lowerG, $lowerB) = static::hex2rgb($lower);

                list($upperR, $upperG, $upperB) = static::hex2rgb($upper);

                return static::rgb2hex([
                    floor($lowerR * $pctLower + $upperR * $pctUpper),
                    floor($lowerG * $pctLower + $upperG * $pctUpper),
                    floor($lowerB * $pctLower + $upperB * $pctUpper),
                ]);
            }

            $lowerP = $p;
        }

        return end($palette);
    }

    public static function hex2rgb($hex)
    {
        if ($hex[0] == '#') {
            $hex = substr($hex, 1);
        }

        if (strlen($hex) == 3) {
            $r = hexdec(substr($hex, 0, 1) . substr($hex, 0, 1));
            $g = hexdec(substr($hex, 1, 1) . substr($hex, 1, 1));
            $b = hexdec(substr($hex, 2, 1) . substr($hex, 2, 1));
        } else {
            $r = hexdec(substr($hex, 0, 2));
            $g = hexdec(substr($hex, 2, 2));
            $b = hexdec(substr($hex, 4, 2));
        }

        return [$r, $g, $b];
    }

    public static function rgb2hex(array $rgb)
    {
        list($r, $g, $b) = $rgb;

        $hex = '#';

        $hex .= str_pad(dechex($r), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($g), 2, '0', STR_PAD_LEFT);
        $hex .= str_pad(dechex($b), 2, '0', STR_PAD_LEFT);

        return $hex;
    }
}
