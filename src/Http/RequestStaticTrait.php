<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;
use Greg\Support\Server;

/**
 * Class RequestStaticTrait
 * @package Greg\Support\Http
 *
 * $_GET Methods
 *
 * @method static bool hasGetParams()
 * @method static bool hasGet($key)
 * @method static bool hasIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllGet()
 * @method static string getGet($key, $else = null)
 * @method static string getGetRef($key, &$else = null)
 * @method static string getForceGet($key, $else = null)
 * @method static string getForceGetRef($key, &$else = null)
 * @method static string getArrayGet($key, $else = null)
 * @method static string getArrayGetRef($key, &$else = null)
 * @method static string getArrayForceGet($key, $else = null)
 * @method static string getArrayForceGetRef($key, &$else = null)
 * @method static string getIndexGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_POST Methods
 *
 * @method static bool hasPostParams()
 * @method static bool hasPost($key)
 * @method static bool hasIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllPost()
 * @method static string getPost($key, $else = null)
 * @method static string getPostRef($key, &$else = null)
 * @method static string getForcePost($key, $else = null)
 * @method static string getForcePostRef($key, &$else = null)
 * @method static string getArrayPost($key, $else = null)
 * @method static string getArrayPostRef($key, &$else = null)
 * @method static string getArrayForcePost($key, $else = null)
 * @method static string getArrayForcePostRef($key, &$else = null)
 * @method static string getIndexPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_REQUEST Methods
 *
 * @method static bool hasRequestParams()
 * @method static bool hasRequest($key)
 * @method static bool hasIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllRequest()
 * @method static string getRequest($key, $else = null)
 * @method static string getRequestRef($key, &$else = null)
 * @method static string getForceRequest($key, $else = null)
 * @method static string getForceRequestRef($key, &$else = null)
 * @method static string getArrayRequest($key, $else = null)
 * @method static string getArrayRequestRef($key, &$else = null)
 * @method static string getArrayForceRequest($key, $else = null)
 * @method static string getArrayForceRequestRef($key, &$else = null)
 * @method static string getIndexRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 * $_FILES Methods
 *
 * @method static bool hasFilesParams()
 * @method static bool hasFiles($key)
 * @method static bool hasIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
 *
 * @method static array getAllFiles()
 * @method static string getFiles($key, $else = null)
 * @method static string getFilesRef($key, &$else = null)
 * @method static string getForceFiles($key, $else = null)
 * @method static string getForceFilesRef($key, &$else = null)
 * @method static string getArrayFiles($key, $else = null)
 * @method static string getArrayFilesRef($key, &$else = null)
 * @method static string getArrayForceFiles($key, $else = null)
 * @method static string getArrayForceFilesRef($key, &$else = null)
 * @method static string getIndexFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexForceFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
 * @method static string getIndexArrayForceFilesRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
 *
 */
trait RequestStaticTrait
{
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

    public static function relativeUriQuery()
    {
        list($path, $query) = array_pad(explode('?', static::relativeUri(), 2), 2, null);

        unset($path);

        return $query;
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

    public static function ajax()
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
        $file = static::getFiles($name);

        if (!$file or !$file['tmp_name']) {
            return null;
        }

        static::checkFile($file, $mimes);

        return $file;
    }

    public static function getIndexFile($name, $mimes = [])
    {
        $file = static::getIndexFiles($name);

        if (!$file or !$file['tmp_name']) {
            return null;
        }

        static::checkFile($file, $mimes);

        return $file;
    }

    public static function checkFile($file, $mimes = [])
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Upload file error: ' . RequestInterface::UPLOAD_ERROR[$file['error']]);
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new \Exception('Possible file upload attack.');
        }

        if ($mimes and !in_array($file['type'], (array) $mimes)) {
            throw new \Exception('Wrong file type was uploaded. Valid types are: '.implode(', ', $mimes));
        }

        return true;
    }

    protected static function callTypeMethod(&$storage, $method, array $args)
    {
        Arr::prependValueRef($args, $storage);

        return call_user_func_array(['RequestTypeHelper', $method], $args);
    }

    protected function callType(array $types, $method, array $args)
    {
        foreach ($types as $type => &$storage) {
            if (strpos($method, $type) > 0) {
                return static::callTypeMethod($storage, str_replace($type, 'Type', $method), $args);
            }
        }
        unset($storage);

        throw new \Exception('Call to undefined request method.');
    }

    public static function __callStatic($method, array $args)
    {
        return static::callType([
            'Get' => &$_GET,
            'Post' => &$_POST,
            'Request' => &$_REQUEST,
            'Files' => &$_FILES,
        ], $method, $args);
    }
}