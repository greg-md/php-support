<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;
use Greg\Support\Server;

/**
 * Class RequestStaticTrait.
 *
 * @method static bool hasGetParams()
 * @method static bool hasGet($key)
 * @method static bool hasIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
 * @method static array getAllGet()
 * @method static string getGet($key, $else = null)
 * @method static string getArrayGet($key, $else = null)
 * @method static string getIndexGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_POST Methods
 * @method static bool hasPostParams()
 * @method static bool hasPost($key)
 * @method static bool hasIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
 * @method static array getAllPost()
 * @method static string getPost($key, $else = null)
 * @method static string getArrayPost($key, $else = null)
 * @method static string getIndexPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_REQUEST Methods
 * @method static bool hasRequestParams()
 * @method static bool hasRequest($key)
 * @method static bool hasIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
 * @method static array getAllRequest()
 * @method static string getRequest($key, $else = null)
 * @method static string getArrayRequest($key, $else = null)
 * @method static string getIndexRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_FILES Methods
 * @method static bool hasFilesParams()
 * @method static bool hasFiles($key)
 * @method static bool hasIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
 * @method static array getAllFiles()
 * @method static string getFiles($key, $else = null)
 * @method static string getArrayFiles($key, $else = null)
 * @method static string getIndexFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 */
trait RequestStaticTrait
{
    private static $isHumanReadableFiles = false;

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

    public static function getFile($name, $mimes = [])
    {
        return static::checkFile(static::getFiles($name), $mimes);
    }

    public static function getIndexFile($name, $mimes = [])
    {
        return static::checkFile(static::getIndexFiles($name), $mimes);
    }

    public static function getMultiFiles($name, $mimes = [])
    {
        return static::checkFiles(static::getFiles($name), $mimes);
    }

    public static function getIndexMultiFiles($name, $mimes = [])
    {
        if (!static::$isHumanReadableFiles) {
            throw new RequestException('You can not get multiple files by index if `humanReadableFiles` are off.');
        }

        return static::checkHumanReadableFiles(static::getIndexFiles($name), $mimes);
    }

    protected static function checkHumanReadableFiles(array $files, $mimes = [])
    {
        foreach($files as &$file) {
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

    protected static function checkFiles(array &$files, $mimes = [])
    {
        if (static::$isHumanReadableFiles) {
            return static::checkHumanReadableFiles($files, $mimes);
        }

        if (!Arr::hasRef($files, ['name', 'type', 'size', 'tmp_name', 'error'])) {
            throw new RequestException('Requested file is not a request file.');
        }

        foreach ($files['error'] as $key => $error) {
            static::checkFile([
                'name' => $files['name'][$key],
                'type' => $files['type'][$key],
                'size' => $files['size'][$key],
                'tmp_name' => $files['tmp_name'][$key],
                'error' => $files['error'][$key],
            ], $mimes);
        }

        return $files;
    }

    protected static function checkFile(array $file, $mimes = [])
    {
        if (!Arr::hasRef($file, ['name', 'type', 'size', 'tmp_name', 'error'])) {
            throw new RequestException('Requested file is not a request file.');
        }

        if (!$file['tmp_name']) {
            return null;
        }

        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new RequestException('Upload file error: ' . Request::UPLOAD_ERROR[$file['error']]);
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new RequestException('Possible file upload attack.');
        }

        if ($mimes and !in_array($file['type'], (array) $mimes)) {
            throw new RequestException('Wrong file type was uploaded. Valid types are: ' . implode(', ', $mimes));
        }

        return $file;
    }

    protected static function callTypeMethod(&$storage, $method, array $args)
    {
        Arr::prependRefValueRef($args, $storage);

        return call_user_func_array([RequestTypeHelper::class, $method], $args);
    }

    protected static function callType(array $types, $method, array $args)
    {
        foreach ($types as $type => &$storage) {
            if (strpos($method, $type) > 0) {
                return static::callTypeMethod($storage, str_replace($type, 'Type', $method), $args);
            }
        }
        unset($storage);

        throw new RequestException('Call to undefined request method.');
    }

    public static function __callStatic($method, array $args)
    {
        return static::callType([
            'Get'     => &$_GET,
            'Post'    => &$_POST,
            'Request' => &$_REQUEST,
            'Files'   => &$_FILES,
        ], $method, $args);
    }
}
