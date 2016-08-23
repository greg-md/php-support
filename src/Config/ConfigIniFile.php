<?php

namespace Greg\Support\Config;

class ConfigIniFile extends ConfigIni
{
    public function __construct($file, $section = null, $indexDelimiter = null)
    {
        return $this->setContents($this->parse($file), $section, $indexDelimiter);
    }

    static public function parse($file)
    {
        return parse_ini_file($file, true);
    }

    static public function fetch($file, $section = null, $indexDelimiter = false)
    {
        return parent::fetchContents(static::parse($file), $section, $indexDelimiter);
    }
}