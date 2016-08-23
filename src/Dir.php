<?php

namespace Greg\Support;

class Dir
{
    static public function fix($dir, $recursive = false)
    {
        if (!file_exists($dir)) {
            ErrorHandler::throwException();

            @mkdir($dir, 0777, $recursive);

            ErrorHandler::restore();
        }

        return true;
    }

    static public function fixRecursive($dir)
    {
        return static::fix($dir, true);
    }

    static public function unlink($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            is_dir($file) ? static::unlink($file) : unlink($file);
        }

        rmdir($dir);

        return true;
    }
}