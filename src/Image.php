<?php

namespace Greg\Support;

class Image extends File
{
    public function type()
    {
        return $this->typeFile($this->getFilePath());
    }

    public function size()
    {
        return $this->sizeFile($this->getFilePath());
    }

    public function width()
    {
        return $this->widthFile($this->getFilePath());
    }

    public function height()
    {
        return $this->heightFile($this->getFilePath());
    }

    public function is()
    {
        return $this->isFile($this->getFilePath());
    }

    public function get()
    {
        return $this->getFile($this->getFilePath());
    }

    public function saveJPEG($image, $fixDir = false, $quality = 75)
    {
        return $this->saveJPEGFile($image, $this->getFilePath(), $fixDir, $quality);
    }

    public function saveGIF($image, $fixDir = false)
    {
        return $this->saveGIFFile($image, $this->getFilePath(), $fixDir);
    }

    public function savePNG($image, $fixDir = false, $quality = 9, $filters = PNG_NO_FILTER)
    {
        return $this->savePNGFile($image, $this->getFilePath(), $fixDir, $quality, $filters);
    }

    public static function typeFile($file)
    {
        $type = function_exists('exif_imagetype') ? @exif_imagetype($file) : null;

        if (!$type) {
            list($width, $height, $type) = @getimagesize($file);

            unset($width, $height);

            return $type;
        }

        return $type;
    }

    public static function typeToExt($type, $point = true)
    {
        return image_type_to_extension($type, $point);
    }

    public static function extFile($file, $point = false)
    {
        $type = static::typeFile($file);

        $ext = static::typeToExt($type, false);

        switch ($ext) {
            case 'jpeg':
                $ext = 'jpg';

                break;
            case 'tiff':
                $ext = 'tif';

                break;
        }

        if ($point) {
            $ext = '.' . $ext;
        }

        return $ext;
    }

    public static function sizeFile($file)
    {
        $width = $height = 0;

        if (file_exists($file)) {
            list($width, $height) = @getimagesize($file);

            if (!$width or !$height) {
                $theFile = static::getFile($file);

                if (!$width) {
                    $width = imagesx($theFile);
                }

                if (!$height) {
                    $height = imagesy($theFile);
                }
            }
        }

        return [$width, $height];
    }

    public static function widthFile($file)
    {
        list($width, $height) = static::sizeFile($file);

        unset($height);

        return $width;
    }

    public static function heightFile($file)
    {
        list($width, $height) = static::sizeFile($file);

        unset($width);

        return $height;
    }

    public static function isFile($file)
    {
        return static::typeFile($file) ? true : false;
    }

    public static function mimeFile($file)
    {
        return static::typeToMime(static::typeFile($file));
    }

    public static function typeToMime($type)
    {
        return image_type_to_mime_type($type);
    }

    public static function getFile($file)
    {
        $image = null;

        switch (static::typeFile($file)) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($file);

                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($file);

                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($file);

                break;
        }

        if (!$image) {
            $image = imagecreatefromstring(file_get_contents($file));

            if (!$image) {
                throw new \Exception('Wrong file type.');
            }
        }

        return $image;
    }

    public static function saveJPEGFile($image, $file, $fixDir = false, $quality = 75)
    {
        $fixDir && static::fixFileDir($file, true);

        imagejpeg($image, $file, $quality);

        return true;
    }

    public static function getJPEG($image, $quality = 75)
    {
        ob_start();

        imagejpeg($image, null, $quality);

        return ob_get_clean();
    }

    public static function saveGIFFile($image, $file, $fixDir = false)
    {
        $fixDir && static::fixFileDir($file, true);

        imagegif($image, $file);

        return true;
    }

    public static function getGIF($image)
    {
        ob_start();

        imagegif($image, null);

        return ob_get_clean();
    }

    public static function savePNGFile($image, $file, $fixDir = false, $quality = 9, $filters = PNG_NO_FILTER)
    {
        $fixDir && static::fixFileDir($file, true);

        imagepng($image, $file, $quality, $filters);

        return true;
    }

    public static function getPNG($image, $quality = 9, $filters = PNG_NO_FILTER)
    {
        ob_start();

        imagepng($image, null, $quality, $filters);

        return ob_get_clean();
    }
}
