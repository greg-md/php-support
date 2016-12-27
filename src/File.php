<?php

namespace Greg\Support;

class File
{
    private $fileName = null;

    public function __construct($fileName)
    {
        $this->fileName = (string) $fileName;

        $this->check($this->fileName);

        return $this;
    }

    public function fileName()
    {
        return $this->fileName;
    }

    public static function check($filename, $throwException = true)
    {
        if (!file_exists($filename)) {
            if ($throwException) {
                throw new \Exception('File does not exists.');
            }

            return false;
        }

        return true;
    }

    public static function isValid($fileName)
    {
        return static::check($fileName, false);
    }

    public function extension($point = false)
    {
        return $this->getCheckedExtension($this->fileName, $point);
    }

    public static function getExtension($fileName, $point = false)
    {
        static::check($fileName);

        return static::getCheckedExtension($fileName, $point);
    }

    protected static function getCheckedExtension($fileName, $point = false)
    {
        $fileName = explode('.', $fileName);

        return ($point ? '.' : '') . (count($fileName) > 1 ? end($fileName) : null);
    }

    public function mime()
    {
        return $this->getCheckedMime($this->fileName);
    }

    public static function getMime($fileName)
    {
        static::check($fileName);

        return static::getCheckedMime($fileName);
    }

    protected static function getCheckedMime($fileName)
    {
        return (new \finfo())->file($fileName, FILEINFO_MIME_TYPE);
    }

    public static function makeDir($fileName, $recursive = false)
    {
        return Dir::make(dirname($fileName), $recursive);
    }
}
