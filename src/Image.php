<?php

namespace Greg\Support;

class Image extends File
{
    public static function check($filename, $throwException = true)
    {
        if (!parent::check($filename, $throwException)) {
            return false;
        }

        if (!static::getCheckedType($filename)) {
            if ($throwException) {
                throw new \Exception('File is not a valid image.');
            }

            return false;
        }

        return true;
    }

    public function type()
    {
        return $this->getCheckedType($this->fileName());
    }

    public static function getType($fileName)
    {
        static::check($fileName);

        return static::getCheckedType($fileName);
    }

    protected static function getCheckedType($fileName)
    {
        if (!$type = function_exists('exif_imagetype') ? @exif_imagetype($fileName) : null) {
            list($width, $height, $type) = @getimagesize($fileName);

            unset($width, $height);

            return $type;
        }

        return $type;
    }

    public function size()
    {
        return $this->getSize($this->fileName());
    }

    public static function getSize($fileName)
    {
        static::check($fileName);

        return static::getCheckedSize($fileName);
    }

    protected static function getCheckedSize($fileName)
    {
        list($width, $height) = @getimagesize($fileName);

        if (!$width or !$height) {
            $image = static::getCheckedResource($fileName);

            if (!$width) {
                $width = imagesx($image);
            }

            if (!$height) {
                $height = imagesy($image);
            }
        }

        return [$width, $height];
    }

    public function resource()
    {
        return $this->getCheckedResource($this->fileName());
    }

    public static function getResource($fileName)
    {
        static::check($fileName);

        return static::getCheckedResource($fileName);
    }

    protected static function getCheckedResource($fileName)
    {
        $image = null;

        switch (static::getCheckedType($fileName)) {
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($fileName);

                break;
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($fileName);

                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($fileName);

                break;
        }

        if (!$image) {
            $image = imagecreatefromstring(file_get_contents($fileName));

            if (!$image) {
                throw new \Exception('Wrong image type.');
            }
        }

        return $image;
    }

    public function width()
    {
        return $this->getCheckedWidth($this->fileName());
    }

    public static function getWidth($fileName)
    {
        static::check($fileName);

        return static::getCheckedWidth($fileName);
    }

    protected static function getCheckedWidth($fileName)
    {
        list($width, $height) = static::getCheckedSize($fileName);

        unset($height);

        return $width;
    }

    public function height()
    {
        return $this->getCheckedHeight($this->fileName());
    }

    public static function getHeight($fileName)
    {
        static::check($fileName);

        return static::getCheckedHeight($fileName);
    }

    protected static function getCheckedHeight($fileName)
    {
        list($width, $height) = static::getCheckedSize($fileName);

        unset($width);

        return $height;
    }

    public function saveJPEG($image, $fixDir = false, $quality = 75)
    {
        return $this->saveJPEGFile($image, $this->fileName(), $fixDir, $quality);
    }

    public static function saveJPEGFile($image, $fileName, $fixDir = false, $quality = 75)
    {
        $fixDir && static::makeDir($fileName, true);

        imagejpeg($image, $fileName, $quality);

        return true;
    }

    public function saveGIF($image, $fixDir = false)
    {
        return $this->saveGIFFile($image, $this->fileName(), $fixDir);
    }

    public static function saveGIFFile($image, $fileName, $fixDir = false)
    {
        $fixDir && static::makeDir($fileName, true);

        imagegif($image, $fileName);

        return true;
    }

    public function savePNG($image, $fixDir = false, $quality = 9, $filters = PNG_NO_FILTER)
    {
        return $this->savePNGFile($image, $this->fileName(), $fixDir, $quality, $filters);
    }

    public static function savePNGFile($image, $fileName, $fixDir = false, $quality = 9, $filters = PNG_NO_FILTER)
    {
        $fixDir && static::makeDir($fileName, true);

        imagepng($image, $fileName, $quality, $filters);

        return true;
    }

    protected static function getCheckedExtension($fileName, $point = false)
    {
        $extension = image_type_to_extension(static::getCheckedType($fileName), $point);

        switch ($extension) {
            case 'jpeg':
                $extension = 'jpg';

                break;
            case 'tiff':
                $extension = 'tif';

                break;
        }

        if ($point) {
            $extension = '.' . $extension;
        }

        return $extension;
    }

    protected static function getCheckedMime($fileName)
    {
        return image_type_to_mime_type(static::getCheckedType($fileName));
    }

    public static function getJPEG($image, $quality = 75)
    {
        ob_start();

        imagejpeg($image, null, $quality);

        return ob_get_clean();
    }

    public static function getGIF($image)
    {
        ob_start();

        imagegif($image, null);

        return ob_get_clean();
    }

    public static function getPNG($image, $quality = 9, $filters = PNG_NO_FILTER)
    {
        ob_start();

        imagepng($image, null, $quality, $filters);

        return ob_get_clean();
    }
}
