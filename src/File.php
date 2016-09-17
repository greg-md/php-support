<?php

namespace Greg\Support;

class File
{
    protected $filePath = null;

    public function __construct($filePath)
    {
        $this->setFilePath($filePath);

        return $this;
    }

    public function ext($point = false)
    {
        return $this->extFile($this->getFilePath(), $point);
    }

    public function mime()
    {
        return $this->mimeFile($this->getFilePath());
    }

    public static function extFile($file, $point = false)
    {
        $file = explode('.', $file);

        return ($point ? '.' : '').(count($file > 1) ? end($file) : null);
    }

    public static function mimeFile($file)
    {
        return (new \finfo())->file($file, FILEINFO_MIME_TYPE);
    }

    public static function fixFileDir($file, $recursive = false)
    {
        return Dir::fix(dirname($file), $recursive);
    }

    public static function fixFileDirRecursive($file)
    {
        return static::fixFileDir($file, true);
    }

    public function setFilePath($file)
    {
        $this->filePath = (string) $file;

        return $this;
    }

    public function getFilePath()
    {
        return $this->filePath;
    }
}
