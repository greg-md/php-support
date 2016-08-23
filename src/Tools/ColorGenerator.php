<?php

namespace Greg\Support\Tools;

class ColorGenerator
{
    static public function generate($point, $palette = [0 => 'f00', 50 => '0f0', 100 => '00f'])
    {
        ksort($palette);

        $hex = null;

        $lowerP = key($palette);

        foreach($palette as $p => $upper) {
            if ($point <= $p) {

                $range = $p - $lowerP;

                if ($range < 1) {
                    $range = 1;
                }

                $rangePct = ($point - $lowerP) / $range;

                $pctLower = 1 - $rangePct;

                $pctUpper = $rangePct;

                $lower = $palette[$lowerP];

                $lowerRGB = static::toRGB($lower);

                $upperRGB = static::toRGB($upper);

                $rgb = [
                    'r' => floor($lowerRGB['r'] * $pctLower + $upperRGB['r'] * $pctUpper),
                    'g' => floor($lowerRGB['g'] * $pctLower + $upperRGB['g'] * $pctUpper),
                    'b' => floor($lowerRGB['b'] * $pctLower + $upperRGB['b'] * $pctUpper),
                ];

                $hex = static::rgb2hex($rgb);

                break;
            }

            $lowerP = $p;
        }

        if (!$hex) {
            $hex = static::rgb2hex(static::toRGB(end($palette)));
        }

        return $hex;
    }

    static protected function toRGB($color)
    {
        if (preg_match('/#?[0-9a-f]{3,6}/i', $color)) {
            return static::hex2rgb($color);
        }

        return $color;
    }

    static protected function hex2rgb($hex)
    {
        if ($hex[0] == '#') {
            $hex = substr($hex, 1);
        }

        if(strlen($hex) == 3) {
            $r = hexdec(substr($hex,0,1).substr($hex,0,1));

            $g = hexdec(substr($hex,1,1).substr($hex,1,1));

            $b = hexdec(substr($hex,2,1).substr($hex,2,1));
        } else {
            $r = hexdec(substr($hex,0,2));

            $g = hexdec(substr($hex,2,2));

            $b = hexdec(substr($hex,4,2));
        }

        return [
            'r' => $r,
            'g' => $g,
            'b' => $b
        ];
    }

    static protected function rgb2hex($rgb)
    {
        $hex = '#';

        $hex .= str_pad(dechex($rgb['r']), 2, "0", STR_PAD_LEFT);

        $hex .= str_pad(dechex($rgb['g']), 2, "0", STR_PAD_LEFT);

        $hex .= str_pad(dechex($rgb['b']), 2, "0", STR_PAD_LEFT);

        return $hex;
    }
}