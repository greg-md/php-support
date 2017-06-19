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

    public function getExtension($point = false)
    {
        return $this->checkedExtension($this->fileName, $point);
    }

    public function getMime()
    {
        return $this->checkedMime($this->fileName);
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

    public static function extension($fileName, $point = false)
    {
        static::check($fileName);

        return static::checkedExtension($fileName, $point);
    }

    public static function mime($fileName)
    {
        static::check($fileName);

        return static::checkedMime($fileName);
    }

    public static function makeDir($fileName, $recursive = false)
    {
        return Dir::make(dirname($fileName), $recursive);
    }

    public static function lines($file)
    {
        // Read file into an array of lines with auto-detected line endings
        $autodetect = ini_get('auto_detect_line_endings');

        ini_set('auto_detect_line_endings', '1');

        $lines = file($file, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        ini_set('auto_detect_line_endings', $autodetect);

        return $lines;
    }

    protected static function checkedExtension($fileName, $point = false)
    {
        $fileName = explode('.', $fileName);

        return ($point ? '.' : '') . (count($fileName) > 1 ? end($fileName) : null);
    }

    protected static function checkedMime($fileName)
    {
        return (new \finfo())->file($fileName, FILEINFO_MIME_TYPE);
    }
}
