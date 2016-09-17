<?php

namespace Greg\Support\Config;

class StringConfigIni extends ConfigIniAbstract
{
    public function __construct($string, $section = null, $indexDelimiter = null)
    {
        return $this->setContents($this->parse($string), $section, $indexDelimiter);
    }

    public static function parse($string)
    {
        return parse_ini_string($string, true);
    }

    public static function fetch($string, $section = null, $indexDelimiter = false)
    {
        return parent::fetchContents(static::parse($string), $section, $indexDelimiter);
    }
}
