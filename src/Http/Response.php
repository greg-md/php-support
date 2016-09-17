<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;
use Greg\Support\Image;
use Greg\Support\Str;

class Response implements ResponseInterface
{
    protected $contentType = 'text/html';

    protected $charset = 'UTF-8';

    protected $location = null;

    protected $code = null;

    protected $content = null;

    protected $disposition = null;

    protected $fileName = null;

    public function __construct($content = null, $contentType = null)
    {
        if ($content !== null) {
            $this->setContent($content);
        }

        if ($contentType !== null) {
            $this->setContentType($contentType);
        }

        return $this;
    }

    public function back()
    {
        return $this->setLocation(Request::referrer());
    }

    public function download($content, $name = null, $type = 'application/octet-stream')
    {
        $this->setContent($content);

        if ($name) {
            $this->setFileName($name);
        }

        $this->setContentType($type);

        $this->setDisposition('download');

        return $this;
    }

    public function inline($content, $name = null, $type = 'application/octet-stream')
    {
        $this->setContent($content);

        if ($name) {
            $this->setFileName($name);
        }

        $this->setContentType($type);

        $this->setDisposition('inline');

        return $this;
    }

    public function json($data)
    {
        $this->setContentType('application/json');

        $this->setContent(json_encode($data));

        return $this;
    }

    public function refresh()
    {
        return $this->setLocation(Request::uri());
    }

    public function send()
    {
        if ($disposition = $this->getDisposition()) {
            $this->sendDisposition($disposition, $this->getFileName());
        }

        $contentType = [];

        if ($type = $this->getContentType()) {
            $contentType[] = $type;
        }

        if ($charset = $this->getCharset()) {
            $contentType[] = 'charset='.$charset;
        }

        if ($contentType) {
            $this->sendContentType(implode('; ', $contentType));
        }

        if ($code = $this->getCode()) {
            $this->sendCode($code);
        }

        if ($location = $this->getLocation()) {
            $this->sendLocation($location);
        }

        echo $this->getContent();

        return $this;
    }

    public function isHtml()
    {
        return $this->getContentType() == 'text/html';
    }

    public function setContentType($type)
    {
        $this->contentType = (string) $type;

        return $this;
    }

    public function getContentType()
    {
        return $this->contentType;
    }

    public function setDisposition($name)
    {
        $this->disposition = (string) $name;

        return $this;
    }

    public function getDisposition()
    {
        return $this->disposition;
    }

    public function setFileName($name)
    {
        $this->fileName = (string) $name;

        return $this;
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    public function setCharset($name)
    {
        $this->charset = (string) $name;

        return $this;
    }

    public function getCharset()
    {
        return $this->charset;
    }

    public function setLocation($path)
    {
        $this->location = (string) $path;

        return $this;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setCode($number)
    {
        $this->code = $number ? (int) $number : null;

        return $this;
    }

    public function getCode()
    {
        return $this->code;
    }

    public function setContent($content)
    {
        $this->content = (string) $content;

        return $this;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function toString()
    {
        return (string) $this->getContent();
    }

    public function __toString()
    {
        return $this->toString();
    }

    public static function sendCode($code)
    {
        if (Str::isNaturalNumber($code) and Arr::has(static::CODES, $code)) {
            $code .= ' '.static::CODES[$code];
        }

        header('HTTP/1.1 '.$code);

        return true;
    }

    public static function sendLocation($url = '/', $code = null)
    {
        if ($code !== null) {
            static::sendCode($code);
        }

        if (!$url) {
            $url = '/';
        }

        header('Location: '.$url, false, $code);

        return true;
    }

    public static function sendRefresh()
    {
        return static::sendLocation(Request::uri(), null);
    }

    public static function sendBack()
    {
        return static::sendLocation(Request::referrer(), null);
    }

    public static function sendJson($param = [])
    {
        static::sendContentType('application/json');

        echo json_encode($param);

        return true;
    }

    public static function sendHtml($html)
    {
        static::sendContentType('text/html');

        echo $html;

        return true;
    }

    public static function sendImageFile($file)
    {
        $mime = Image::mimeFile($file);

        if (!$mime) {
            throw new \Exception('File is not an image.');
        }

        self::sendContentType($mime);

        readfile($file);

        return true;
    }

    public static function sendText($text)
    {
        static::sendContentType('text/plain');

        echo $text;

        return true;
    }

    public static function sendJpeg($image, $quality = 75)
    {
        static::sendContentType('image/jpeg');

        imagejpeg($image, null, $quality);

        return true;
    }

    public static function sendGif($image)
    {
        static::sendContentType('image/gif');

        imagegif($image);

        return true;
    }

    public static function sendPng($image)
    {
        static::sendContentType('image/png');

        imagepng($image);

        return true;
    }

    public static function sendContentType($type)
    {
        header('Content-Type: '.$type);

        return true;
    }

    public static function sendDisposition($name, $fileName = null)
    {
        header('Content-disposition: '.$name.'; filename="'.addslashes($fileName).'"');

        return true;
    }

    public static function flushContent()
    {
        echo str_pad('', 4096);

        ob_flush();

        flush();

        return true;
    }

    public static function isModifiedSince($timestamp, $maxAge = 0)
    {
        if (!Str::isNaturalNumber($timestamp)) {
            $timestamp = strtotime($timestamp);
        }

        $modifiedSince = Request::modifiedSince();

        if ($maxAge > 0) {
            $serverTime = Request::time();

            if ($modifiedSince) {
                $modifiedSinceTime = new \DateTime($modifiedSince, new \DateTimeZone('UTC'));

                $modifiedSinceTime = strtotime($modifiedSinceTime->format('Y-m-d H:i:s'));

                if ($modifiedSinceTime < $serverTime - $maxAge) {
                    $timestamp = $serverTime;
                } elseif ($timestamp < $modifiedSinceTime) {
                    $timestamp = $modifiedSinceTime;
                }
            } else {
                $timestamp = $serverTime;
            }
        }

        $lastModified = substr(date('r', $timestamp), 0, -5).'GMT';

        $eTag = '"'.md5($lastModified).'"';

        // Send the headers
        header('Last-Modified: '.$lastModified);

        header('ETag: '.$eTag);

        $match = Request::match();

        // See if the client has provided the required headers
        if (!$modifiedSince && !$match) {
            return false;
        }

        // At least one of the headers is there - check them
        if ($match && $match != $eTag) {
            return false; // eTag is there but doesn't match
        }

        if ($modifiedSince && $modifiedSince != $lastModified) {
            return false; // if-modified-since is there but doesn't match
        }

        // Nothing has changed since their last request - serve a 304
        static::sendCode(304);

        return true;
    }
}
