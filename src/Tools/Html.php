<?php

namespace Greg\Support\Tools;

class Html
{
    public static function sub($html, $start = 0, $length = null, $delimiter = null, $suffix = null, $forceSuffix = null)
    {
        return (new SubHtml($start, $length, $delimiter, $suffix, $forceSuffix))->parse($html);
    }

    public static function cutTag($html, $tag, $offset = 0, $limit = null, $cleanAfter = false)
    {
        // match html tag: <(\w)[^>]*(?<!\/)(\/>|>.*?<\/\1>)
        $regex = '<(' . preg_quote($tag, '#') . ')[^>]*(?<!\/)(\/>|>.*?<\/\1>)';

        $pregLimit = $cleanAfter ? abs($offset) + 1 : -1;

        $count = 0;

        $lastClean = $cleanAfter ? uniqid('cut_', true) : null;

        $html = preg_replace_callback('#' . $regex . '#i', function ($matches) use (&$count, $offset, $limit, $lastClean) {
            $count++;

            if ($count > $offset and ($limit < 1 or ($count <= ($offset + $limit)))) {
                return $lastClean;
            }

            return $matches[0];
        }, $html, $pregLimit);

        if ($cleanAfter and $count > $offset) {
            $html = static::sub($html, 0, null, $lastClean);
        }

        return $html;
    }
}
