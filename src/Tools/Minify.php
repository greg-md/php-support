<?php

namespace Greg\Support\Tools;

class Minify
{
    /**
     * Better don't use it. It is very slow with big data.
     *
     * @param $html
     *
     * @return mixed
     */
    public static function html($html)
    {
        return preg_replace('%(?>[^\S]\s*|\s{2,})(?=(?:(?:[^<]++|<(?!/?(?:textarea|pre)\b))*+)(?:<(?>textarea|pre)\b|\z))%ix', ' ', $html);
    }
}
