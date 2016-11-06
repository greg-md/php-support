<?php

namespace Greg\Support;

class Dir
{
    public static function fix($dir, $recursive = false)
    {
        if (!file_exists($dir)) {
            ErrorHandler::throwException();

            @mkdir($dir, 0777, $recursive);

            ErrorHandler::restore();
        }

        return true;
    }

    public static function fixRecursive($dir)
    {
        return static::fix($dir, true);
    }

    public static function unlink($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            is_dir($file) ? static::unlink($file) : unlink($file);
        }

        rmdir($dir);

        return true;
    }

    public static function copy($source, $dest, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $dest);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $dest);
        }

        // Make destination directory
        if (!is_dir($dest)) {
            mkdir($dest, $permissions);
        }

        // Loop through the folder
        $dir = dir($source);

        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            static::copy("$source/$entry", "$dest/$entry", $permissions);
        }

        // Clean up
        $dir->close();

        return true;
    }
}
