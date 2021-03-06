<?php

namespace Greg\Support;

class Dir
{
    public static function make($dir, $recursive = false)
    {
        if (!file_exists($dir)) {
            Server::errorsAsExceptions();

            @mkdir($dir, 0777, $recursive);

            Server::restoreErrors();
        }

        return true;
    }

    public static function unlink($dir)
    {
        $dir = str_replace('/*', '/{,.}[!.,!..]*', $dir);

        foreach (glob($dir, GLOB_BRACE) as $path) {
            static::unlinkRecursive($path);
        }

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

    public static function absolute($path)
    {
        $path = str_replace(['/', '\\'], DIRECTORY_SEPARATOR, $path);

        $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');

        $absolutes = [];

        foreach ($parts as $part) {
            if ('.' == $part) {
                continue;
            }

            if ('..' == $part) {
                array_pop($absolutes);

                continue;
            }

            $absolutes[] = $part;
        }

        $absolute = implode(DIRECTORY_SEPARATOR, $absolutes);

        if ($path[0] === DIRECTORY_SEPARATOR) {
            $absolute = DIRECTORY_SEPARATOR . $absolute;
        }

        return $absolute;
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

    private static function unlinkRecursive($path)
    {
        if (is_file($path)) {
            unlink($path);
        } else {
            foreach (glob($path . '/{,.}[!.,!..]*', GLOB_BRACE) as $file) {
                static::unlinkRecursive($file);
            }

            rmdir($path);
        }

        return true;
    }
}
