<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;
use Greg\Support\Server;

trait RequestStaticTrait
{
    protected static $isHumanReadableFiles = false;

    protected static $checkFileUpload = true;

    protected static $DS = DIRECTORY_SEPARATOR;

    private static $disableCliChecks = false;

    private static $originalServer;

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
        if (!self::$disableCliChecks and php_sapi_name() === 'cli') {
            return null;
        }

        $scriptName = Server::scriptName();

        $baseUri = pathinfo($scriptName, PATHINFO_DIRNAME);

        if (static::$DS != '/') {
            $baseUri = str_replace(static::$DS, '/', $baseUri);
        }

        if ($baseUri[0] == '.') {
            $baseUri[0] = '/';
        }

        if ($baseUri[0] != '/') {
            $baseUri = '/' . $baseUri;
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

    public static function file($key = null, $mime = null)
    {
        if (func_num_args()) {
            $file = Arr::get($_FILES, $key);

            if (is_array($key)) {
                return Arr::mapRecursive($file, function ($file) use ($mime) {
                    return static::checkFile($file, $mime);
                }, 1);
            }

            return static::checkFile($file, $mime);
        }

        if (!static::$isHumanReadableFiles) {
            $files = [];

            foreach ($_FILES as $key => $value) {
                if (is_array($value['name'])) {
                    $files[$key] = static::checkFiles($value, $mime);
                } else {
                    $files[$key] = static::checkFile($value, $mime);
                }
            }

            return $files;
        }

        return $_FILES;
    }

    public static function fileArray($key, $mime = null)
    {
        $files = Arr::get($_FILES, $key);

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

        return static::checkFiles($files, $mime);
    }

    public static function fileIndex($index, $mime = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        if (!static::$isHumanReadableFiles) {
            throw new RequestException('You cannot use indexes for $_FILES if `humanReadableFiles` is disabled.');
        }

        $file = Arr::getIndex($_FILES, $index, null, $delimiter);

        if (is_array($index)) {
            return static::checkFiles($file, $mime);
        }

        return static::checkFile($file, $mime);
    }

    public static function fileIndexArray($index, $mime = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        if (!static::$isHumanReadableFiles) {
            throw new RequestException('You cannot use indexes for $_FILES if `humanReadableFiles` is disabled.');
        }

        $files = Arr::getIndex($_FILES, $index, null, $delimiter);

        if (array_key_exists('name', $files)) {
            $files = [$files];
        }

        return static::checkFiles($files, $mime);
    }

    public static function mockHttpMode()
    {
        self::$disableCliChecks = true;

        self::$originalServer = $_SERVER;

        $_SERVER['SERVER_PROTOCOL'] = 'http';
        $_SERVER['HTTP_HOST'] = 'localhost';
        $_SERVER['SERVER_NAME'] = 'localhost';
        $_SERVER['SERVER_ADMIN'] = get_current_user();
        $_SERVER['SERVER_PORT'] = 80;
        $_SERVER['HTTP_USER_AGENT'] = 'Mozilla';
        $_SERVER['REMOTE_ADDR'] = '127.0.0.1';
        $_SERVER['REQUEST_URI'] = '/';

        $_SERVER['SCRIPT_NAME'] = '/index.php';

        $_SERVER['HTTP_IF_MODIFIED_SINCE'] = null;
        $_SERVER['HTTP_IF_NONE_MATCH'] = null;
        $_SERVER['HTTP_REFERER'] = null;
        $_SERVER['REQUEST_METHOD'] = 'GET';

        return true;
    }

    public static function restoreHttpMode()
    {
        if (self::$disableCliChecks) {
            self::$disableCliChecks = false;

            $_SERVER = self::$originalServer;
        }
    }

    protected static function checkHumanReadableFiles(array $files, $mime = null)
    {
        foreach ($files as &$file) {
            if (is_array(current($file))) {
                $file = static::checkHumanReadableFiles($file, $mime);
            } else {
                $file = static::checkFile($file, $mime);
            }
        }

        return $files;
    }

    protected static function checkFiles(array $files, $mime = null)
    {
        if (static::$isHumanReadableFiles) {
            return static::checkHumanReadableFiles($files, $mime);
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
            ], $mime);
        }

        return $files;
    }

    protected static function checkFile(array $file, $mime = null)
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RequestException('File upload error: ' . Request::UPLOAD_ERROR[$file['error']]);
        }

        if (static::$checkFileUpload && !is_uploaded_file($file['tmp_name'])) {
            throw new RequestException('Possible file upload attack.');
        }

        if ($mime = (array) $mime and !in_array($file['type'], $mime)) {
            throw new RequestException('Wrong file type was uploaded. Valid types are: ' . implode(', ', $mime) . '.');
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
