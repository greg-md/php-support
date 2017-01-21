<?php

namespace Greg\Support;

class Image extends File
{
    public function getType()
    {
        return $this->checkedType($this->fileName());
    }

    public function getSize()
    {
        return $this->size($this->fileName());
    }

    public function getResource()
    {
        return $this->checkedResource($this->fileName());
    }

    public function getWidth()
    {
        return $this->checkedWidth($this->fileName());
    }

    public function getHeight()
    {
        return $this->checkedHeight($this->fileName());
    }

    public static function check($filename, $throwException = true)
    {
        if (!parent::check($filename, $throwException)) {
            return false;
        }

        if (!static::checkedType($filename)) {
            if ($throwException) {
                throw new \Exception('File is not a valid image.');
            }

            return false;
        }

        return true;
    }

    public static function type($fileName)
    {
        static::check($fileName);

        return static::checkedType($fileName);
    }

    public static function size($fileName)
    {
        static::check($fileName);

        return static::checkedSize($fileName);
    }

    public static function resource($fileName)
    {
        static::check($fileName);

        return static::checkedResource($fileName);
    }

    public static function width($fileName)
    {
        static::check($fileName);

        return static::checkedWidth($fileName);
    }

    public static function height($fileName)
    {
        static::check($fileName);

        return static::checkedHeight($fileName);
    }

    protected static function checkedType($fileName)
    {
        if (!$type = function_exists('exif_imagetype') ? @exif_imagetype($fileName) : null) {
            list($width, $height, $type) = @getimagesize($fileName);

            unset($width, $height);

            return $type;
        }

        return $type;
    }

    protected static function checkedSize($fileName)
    {
        list($width, $height) = @getimagesize($fileName);

        if (!$width or !$height) {
            $image = static::checkedResource($fileName);

            if (!$width) {
                $width = imagesx($image);
            }

            if (!$height) {
                $height = imagesy($image);
            }
        }

        return [$width, $height];
    }

    protected static function checkedResource($fileName)
    {
        $image = null;

        switch (static::checkedType($fileName)) {
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

    protected static function checkedWidth($fileName)
    {
        list($width, $height) = static::checkedSize($fileName);

        unset($height);

        return $width;
    }

    protected static function checkedHeight($fileName)
    {
        list($width, $height) = static::checkedSize($fileName);

        unset($width);

        return $height;
    }

    protected static function checkedExtension($fileName, $point = false)
    {
        $extension = image_type_to_extension(static::checkedType($fileName), $point);

        switch ($extension) {
            case 'jpeg':
                $extension = 'jpg';

                break;
            case 'tiff':
                $extension = 'tif';

                break;
        }

        return ($point ? '.' : '') . $extension;
    }

    protected static function checkedMime($fileName)
    {
        return image_type_to_mime_type(static::checkedType($fileName));
    }
}
