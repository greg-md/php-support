<?php

namespace Greg\Support\Config;

class FileConfigIni extends ConfigIniAbstract
{
    public function __construct($file, $section = null, $indexDelimiter = null)
    {
        return $this->setContents($this->parse($file), $section, $indexDelimiter);
    }

    public static function parse($file)
    {
        return parse_ini_file($file, true);
    }

    public static function fetch($file, $section = null, $indexDelimiter = false)
    {
        return parent::fetchContents(static::parse($file), $section, $indexDelimiter);
    }
}
