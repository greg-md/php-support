<?php

namespace Greg\Support;

class File
{
    private $path = null;

    public function __construct($path)
    {
        $this->path = (string) $path;

        return $this;
    }

    public function path()
    {
        return $this->path;
    }

    public function extension($point = false)
    {
        return $this->getExtension($this->path, $point);
    }

    public function mime()
    {
        return $this->getMime($this->path);
    }

    public static function getExtension($file, $point = false)
    {
        $file = explode('.', $file);

        return ($point ? '.' : '') . (count($file) > 1 ? end($file) : null);
    }

    public static function getMime($file)
    {
        return (new \finfo())->file($file, FILEINFO_MIME_TYPE);
    }

    public static function makeDir($file, $recursive = false)
    {
        return Dir::make(dirname($file), $recursive);
    }
}
