<?php

namespace Greg\Support;

class Dir
{
    public static function make($dir, $recursive = false)
    {
        if (!file_exists($dir)) {
            ErrorHandler::throwException();

            @mkdir($dir, 0777, $recursive);

            ErrorHandler::restore();
        }

        return true;
    }

    public static function unlink($dir)
    {
        foreach (glob($dir . '/*') as $file) {
            echo PHP_EOL; print_r($file); echo PHP_EOL;
            is_dir($file) ? static::unlink($file) : unlink($file);
        }

        rmdir($dir);

        return true;
    }

    public static function copy($source, $destination, $permissions = 0755)
    {
        // Check for symlinks
        if (is_link($source)) {
            return symlink(readlink($source), $destination);
        }

        // Simple copy for a file
        if (is_file($source)) {
            return copy($source, $destination);
        }

        // Make destination directory
        if (!is_dir($destination)) {
            mkdir($destination, $permissions);
        }

        return static::copyFolder($source, $destination, $permissions);
    }

    protected static function copyFolder($source, $destination, $permissions = 0755)
    {
        // Loop through the folder
        $dir = dir($source);

        while (false !== $entry = $dir->read()) {
            // Skip pointers
            if ($entry == '.' || $entry == '..') {
                continue;
            }

            // Deep copy directories
            static::copy("$source/$entry", "$destination/$entry", $permissions);
        }

        // Clean up
        $dir->close();

        return true;
    }
}
