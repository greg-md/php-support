<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;
use Greg\Support\Server;

trait RequestStaticTrait
{
    private static $isHumanReadableFiles = false;

    private static $checkFileUpload = true;

    public static function protocol()
    {
        return Server::get('SERVER_PROTOCOL');
    }

    public static function clientHost()
    {
        return Server::get('HTTP_HOST');
    }

    public static function serverHost()
    {
        return Server::get('SERVER_NAME');
    }

    public static function serverAdmin()
    {
        return Server::get('SERVER_ADMIN');
    }

    public static function secured()
    {
        return Server::get('HTTPS');
    }

    public static function isSecured()
    {
        return static::secured() == 'on';
    }

    public static function with()
    {
        return Server::get('HTTP_X_REQUESTED_WITH');
    }

    public static function port()
    {
        return Server::get('SERVER_PORT');
    }

    public static function agent()
    {
        return Server::get('HTTP_USER_AGENT');
    }

    public static function ip()
    {
        return Server::get('REMOTE_ADDR');
    }

    public static function uri()
    {
        return Server::get('REQUEST_URI');
    }

    public static function method()
    {
        return Server::get('REQUEST_METHOD');
    }

    public static function baseUri()
    {
        $scriptName = Server::scriptName();

        $uriInfo = pathinfo($scriptName);

        $baseUri = $uriInfo['dirname'];

        if (DIRECTORY_SEPARATOR != '/') {
            $baseUri = str_replace(DIRECTORY_SEPARATOR, '/', $baseUri);
        }

        if ($baseUri[0] == '.') {
            $baseUri[0] = '/';
        }

        if ($baseUri == '/') {
            $baseUri = null;
        }

        return $baseUri;
    }

    public static function uriPath()
    {
        list($path) = explode('?', static::uri(), 2);

        return $path;
    }

    public static function uriQuery()
    {
        list($path, $query) = array_pad(explode('?', static::uri(), 2), 2, null);

        unset($path);

        return $query;
    }

    public static function relativeUri()
    {
        $uri = static::uri();

        $baseUri = static::baseUri();

        return $baseUri !== '/' ? mb_substr($uri, mb_strlen($baseUri)) : $uri;
    }

    public static function relativeUriPath()
    {
        list($path) = explode('?', static::relativeUri(), 2);

        return $path;
    }

    public static function referrer()
    {
        return Server::get('HTTP_REFERER');
    }

    public static function modifiedSince()
    {
        return Server::get('HTTP_IF_MODIFIED_SINCE');
    }

    public static function match()
    {
        return Server::get('HTTP_IF_NONE_MATCH');
    }

    public static function time()
    {
        return Server::requestTime();
    }

    public static function microTime()
    {
        return Server::requestMicroTime();
    }

    public static function isAjax()
    {
        return static::with() == 'XMLHttpRequest';
    }

    public static function header($header)
    {
        $header = strtoupper($header);

        $header = str_replace('-', '_', $header);

        return Server::get('HTTP_' . $header);
    }

    public static function humanReadableFiles()
    {
        $_FILES = static::humanReadableData($_FILES);

        static::$isHumanReadableFiles = true;

        return $_FILES;
    }

    // $_REQUEST

    public static function has($key = null)
    {
        return func_num_args() ? Arr::has($_REQUEST, $key) : (bool) $_REQUEST;
    }

    public static function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($_REQUEST, $index, $delimiter);
    }

    public static function param($key = null, $else = null)
    {
        return func_num_args() ? Arr::get($_REQUEST, $key, $else) : $_REQUEST;
    }

    public static function paramArray($key, $else = null)
    {
        return Arr::getArray($_REQUEST, $key, $else);
    }

    public static function paramIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($_REQUEST, $index, $else, $delimiter);
    }

    public static function paramIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($_REQUEST, $index, $else, $delimiter);
    }

    // $_GET

    public static function hasGet($key = null)
    {
        return func_num_args() ? Arr::has($_GET, $key) : (bool) $_GET;
    }

    public static function hasIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($_GET, $index, $delimiter);
    }

    public static function get($key = null, $else = null)
    {
        return func_num_args() ? Arr::get($_GET, $key, $else) : $_GET;
    }

    public static function getArray($key, $else = null)
    {
        return Arr::getArray($_GET, $key, $else);
    }

    public static function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($_GET, $index, $else, $delimiter);
    }

    public static function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($_GET, $index, $else, $delimiter);
    }

    // $_POST

    public static function hasPost($key = null)
    {
        return func_num_args() ? Arr::has($_POST, $key) : (bool) $_POST;
    }

    public static function hasIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($_POST, $index, $delimiter);
    }

    public static function post($key = null, $else = null)
    {
        return func_num_args() ? Arr::get($_POST, $key, $else) : $_POST;
    }

    public static function postArray($key, $else = null)
    {
        return Arr::getArray($_POST, $key, $else);
    }

    public static function postIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($_POST, $index, $else, $delimiter);
    }

    public static function postIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($_POST, $index, $else, $delimiter);
    }

    // $_FILES

    public static function hasFile($key = null)
    {
        return func_num_args() ? Arr::has($_FILES, $key) : (bool) $_FILES;
    }

    public static function hasIndexFile($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        if (!static::$isHumanReadableFiles) {
            throw new RequestException('You cannot use indexes for $_FILES if `humanReadableFiles` method is not enabled.');
        }

        return Arr::hasIndex($_FILES, $index, $delimiter);
    }

    public static function file($key = null, $else = null)
    {
        if (func_num_args()) {
            $file = Arr::get($_FILES, $key, $else);

            if (is_array($key)) {
                return Arr::mapRecursive(1, function ($file) {
                    return static::checkFile($file);
                }, $file);
            }

            return static::checkFile($file);
        }

        if (!static::$isHumanReadableFiles) {
            $files = [];

            foreach ($_FILES as $key => $value) {
                if (is_array($value['name'])) {
                    $files[$key] = static::checkFiles($value);
                } else {
                    $files[$key] = static::checkFile($value);
                }
            }

            return $files;
        }

        return $_FILES;
    }

    public static function fileArray($key, $else = null)
    {
        $files = Arr::get($_FILES, $key, $else);

        if (static::$isHumanReadableFiles) {
            if (array_key_exists('name', $files)) {
                $files = [$files];
            }
        } else {
            if (!is_array($files['name'])) {
                $files['name'] = (array) $files['name'];
                $files['type'] = (array) $files['type'];
                $files['size'] = (array) $files['size'];
                $files['tmp_name'] = (array) $files['tmp_name'];
                $files['error'] = (array) $files['error'];
            }
        }

        return static::checkFiles($files);
    }

    public static function fileIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        if (!static::$isHumanReadableFiles) {
            throw new RequestException('You cannot use indexes for $_FILES if `humanReadableFiles` method is disabled.');
        }

        $file = Arr::getIndex($_FILES, $index, $else, $delimiter);

        if (is_array($index)) {
            return static::checkFiles($file);
        }

        return static::checkFile($file);
    }

    public static function fileIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        if (!static::$isHumanReadableFiles) {
            throw new RequestException('You cannot use indexes for $_FILES if `humanReadableFiles` method is disabled.');
        }

        $files = Arr::getIndex($_FILES, $index, $else, $delimiter);

        if (array_key_exists('name', $files)) {
            $files = [$files];
        }

        return static::checkFiles($files);
    }

    protected static function checkHumanReadableFiles(array $files, $mimes = [])
    {
        foreach ($files as &$file) {
            if (!is_array($file)) {
                throw new RequestException('Requested file is not an array of files.');
            }

            if (is_array(current($file))) {
                $file = static::checkHumanReadableFiles($file, $mimes);
            } else {
                $file = static::checkFile($file);
            }
        }

        return $files;
    }

    protected static function checkFiles(array $files, $mimes = [])
    {
        if (static::$isHumanReadableFiles) {
            return static::checkHumanReadableFiles($files, $mimes);
        }

        if (!Arr::has($files, ['name', 'type', 'size', 'tmp_name', 'error'])) {
            throw new RequestException('Requested file is not a request file.');
        }

        $names = Arr::packIndexes($files['name'], '&');
        $types = Arr::packIndexes($files['type'], '&');
        $sizes = Arr::packIndexes($files['size'], '&');
        $tmpNames = Arr::packIndexes($files['tmp_name'], '&');
        $errors = Arr::packIndexes($files['error'], '&');

        $indexFiles = [];

        foreach ($names as $index => $name) {
            $indexFiles['name'][$index] = $name;
            $indexFiles['type'][$index] = $types[$index];
            $indexFiles['size'][$index] = $sizes[$index];
            $indexFiles['tmp_name'][$index] = $tmpNames[$index];
            $indexFiles['error'][$index] = $errors[$index];
        }

        foreach ($indexFiles['error'] as $key => $error) {
            static::checkFile([
                'name'     => $indexFiles['name'][$key],
                'type'     => $indexFiles['type'][$key],
                'size'     => $indexFiles['size'][$key],
                'tmp_name' => $indexFiles['tmp_name'][$key],
                'error'    => $indexFiles['error'][$key],
            ], $mimes);
        }

        return $files;
    }

    protected static function checkFile(array $file, $mimes = [])
    {
        if (!Arr::has($file, ['name', 'type', 'size', 'tmp_name', 'error'])) {
            throw new RequestException('Requested file is not a request file.');
        }

        if (!$file['tmp_name']) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RequestException('Upload file error: ' . Request::UPLOAD_ERROR[$file['error']]);
        }

        if (static::$checkFileUpload && !is_uploaded_file($file['tmp_name'])) {
            throw new RequestException('Possible file upload attack.');
        }

        if ($mimes and !in_array($file['type'], (array) $mimes)) {
            throw new RequestException('Wrong file type was uploaded. Valid types are: ' . implode(', ', $mimes));
        }

        return $file;
    }

    protected static function humanReadableData($data)
    {
        foreach ($data as &$item) {
            if (is_array(current($item))) {
                $newItem = [];

                foreach ($item as $key => $value) {
                    static::addNewArrayLevel($value, $key);

                    $newItem = array_replace_recursive($newItem, $value);
                }

                $item = $newItem;
            }
        }

        unset($item);

        return $data;
    }

    protected static function addNewArrayLevel(&$array, $key)
    {
        foreach ($array as &$item) {
            if (is_array($item)) {
                static::addNewArrayLevel($item, $key);
            } else {
                $item = [$key => $item];
            }
        }

        unset($item);

        return true;
    }
}
