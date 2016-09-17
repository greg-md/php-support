<?php

namespace Greg\Support\Http;

use Greg\Support\Arr;
use Greg\Support\Server;
use Greg\Support\Storage\AccessorTrait;
use Greg\Support\Storage\ArrayAccessTrait;

class Request implements \ArrayAccess
{
    use AccessorTrait, ArrayAccessTrait;

    const URI_ALL = 'all';

    const URI_PATH = 'path';

    const URI_QUERY = 'query';

    const UPLOAD_ERR = [
        UPLOAD_ERR_OK         => 'There is no error, the file uploaded with success.',
        UPLOAD_ERR_INI_SIZE   => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE  => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL    => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE    => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.', // Introduced in PHP 4.3.10 and PHP 5.0.3.
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.', // Introduced in PHP 5.1.0.
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.', // Introduced in PHP 5.2.0.
        // PHP does not provide a way to ascertain which extension caused the file upload to stop;
        // examining the list of loaded extensions with phpinfo() may help.
    ];

    public function __construct(array $params = [])
    {
        $this->setStorage($params);

        return $this;
    }

    public function is()
    {
        return (bool) $this->storage;
    }

    public function all()
    {
        return $this->storage;
    }

    public function &getRef($key, &$else = null)
    {
        return Arr::getRef($this->storage, $key, $this->getRequestRef($key, $else));
    }

    public function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef($this->storage, $key, $this->getForceRequestRef($key, $else));
    }

    public function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef($this->storage, $key, $this->getArrayRequestRef($key, $else));
    }

    public function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($this->storage, $key, $this->getArrayForceRequestRef($key, $else));
    }

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($this->storage, $index, $this->getIndexRequestRef($index, $else, $delimiter), $delimiter);
    }

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($this->storage, $index, $this->getIndexForceRequestRef($index, $else, $delimiter), $delimiter);
    }

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($this->storage, $index, $this->getIndexArrayRequestRef($index, $else, $delimiter), $delimiter);
    }

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($this->storage, $index, $this->getIndexArrayForceRequestRef($index, $else, $delimiter), $delimiter);
    }

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

        return Server::get('HTTP_'.$header);
    }

    // Start standard $_GET array methods

    public static function isGet()
    {
        return (bool) $_GET;
    }

    public static function allGet()
    {
        return $_GET;
    }

    public static function hasGet($key)
    {
        return Arr::hasRef($_GET, $key);
    }

    public static function hasIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_GET, $index, $delimiter);
    }

    public static function setGet($key, $value)
    {
        return static::setGetRef($key, $value);
    }

    public static function setGetRef($key, &$value)
    {
        return Arr::setRefValueRef($_GET, $key, $value);
    }

    public static function setIndexGet($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexGetRef($index, $value, $delimiter);
    }

    public static function setIndexGetRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_GET, $index, $value, $delimiter);
    }

    public static function getGet($key, $else = null)
    {
        return static::getGetRef($key, $else);
    }

    public static function &getGetRef($key, &$else = null)
    {
        return Arr::getRef($_GET, $key, $else);
    }

    public static function getForceGet($key, $else = null)
    {
        return static::getForceGetRef($key, $else);
    }

    public static function &getForceGetRef($key, &$else = null)
    {
        return Arr::getForceRef($_GET, $key, $else);
    }

    public static function getArrayGet($key, $else = null)
    {
        return static::getArrayGetRef($key, $else);
    }

    public static function &getArrayGetRef($key, &$else = null)
    {
        return Arr::getArrayRef($_GET, $key, $else);
    }

    public static function getArrayForceGet($key, $else = null)
    {
        return static::getArrayForceGetRef($key, $else);
    }

    public static function &getArrayForceGetRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($_GET, $key, $else);
    }

    public static function getIndexGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexGetRef($index, $else, $delimiter);
    }

    public static function &getIndexGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_GET, $index, $else, $delimiter);
    }

    public static function getIndexForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceGetRef($index, $else, $delimiter);
    }

    public static function &getIndexForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_GET, $index, $else, $delimiter);
    }

    public static function getIndexArrayGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayGetRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_GET, $index, $else, $delimiter);
    }

    public static function getIndexArrayForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceGetRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_GET, $index, $else, $delimiter);
    }

    public static function delGet($key)
    {
        return Arr::delRef($_GET, $key);
    }

    public static function delIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_GET, $index, $delimiter);
    }

    // End standard $_GET array methods

    // Start standard $_POST array methods

    public static function isPost()
    {
        return (bool) $_POST;
    }

    public static function allPost()
    {
        return $_POST;
    }

    public static function hasPost($key)
    {
        return Arr::hasRef($_POST, $key);
    }

    public static function hasIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_POST, $index, $delimiter);
    }

    public static function setPost($key, $value)
    {
        return static::setPostRef($key, $value);
    }

    public static function setPostRef($key, &$value)
    {
        return Arr::setRefValueRef($_POST, $key, $value);
    }

    public static function setIndexPost($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexPostRef($index, $value, $delimiter);
    }

    public static function setIndexPostRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_POST, $index, $value, $delimiter);
    }

    public static function getPost($key, $else = null)
    {
        return static::getPostRef($key, $else);
    }

    public static function &getPostRef($key, &$else = null)
    {
        return Arr::getRef($_POST, $key, $else);
    }

    public static function getForcePost($key, $else = null)
    {
        return static::getForcePostRef($key, $else);
    }

    public static function &getForcePostRef($key, &$else = null)
    {
        return Arr::getForceRef($_POST, $key, $else);
    }

    public static function getArrayPost($key, $else = null)
    {
        return static::getArrayPostRef($key, $else);
    }

    public static function &getArrayPostRef($key, &$else = null)
    {
        return Arr::getArrayRef($_POST, $key, $else);
    }

    public static function getArrayForcePost($key, $else = null)
    {
        return static::getArrayForcePostRef($key, $else);
    }

    public static function &getArrayForcePostRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($_POST, $key, $else);
    }

    public static function getIndexPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexPostRef($index, $else, $delimiter);
    }

    public static function &getIndexPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_POST, $index, $else, $delimiter);
    }

    public static function getIndexForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForcePostRef($index, $else, $delimiter);
    }

    public static function &getIndexForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_POST, $index, $else, $delimiter);
    }

    public static function getIndexArrayPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayPostRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_POST, $index, $else, $delimiter);
    }

    public static function getIndexArrayForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForcePostRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_POST, $index, $else, $delimiter);
    }

    public static function delPost($key)
    {
        return Arr::delRef($_POST, $key);
    }

    public static function delIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_POST, $index, $delimiter);
    }

    // End standard $_POST array methods

    public static function isRequest()
    {
        return (bool) $_REQUEST;
    }

    public static function allRequest()
    {
        return $_REQUEST;
    }

    public static function hasRequest($key)
    {
        return Arr::hasRef($_REQUEST, $key);
    }

    public static function hasIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_REQUEST, $index, $delimiter);
    }

    public static function setRequest($key, $value)
    {
        return static::setRequestRef($key, $value);
    }

    public static function setRequestRef($key, &$value)
    {
        return Arr::setRefValueRef($_REQUEST, $key, $value);
    }

    public static function setIndexRequest($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexRequestRef($index, $value, $delimiter);
    }

    public static function setIndexRequestRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_REQUEST, $index, $value, $delimiter);
    }

    public static function getRequest($key, $else = null)
    {
        return static::getRequestRef($key, $else);
    }

    public static function &getRequestRef($key, &$else = null)
    {
        return Arr::getRef($_REQUEST, $key, $else);
    }

    public static function getForceRequest($key, $else = null)
    {
        return static::getForceRequestRef($key, $else);
    }

    public static function &getForceRequestRef($key, &$else = null)
    {
        return Arr::getForceRef($_REQUEST, $key, $else);
    }

    public static function getArrayRequest($key, $else = null)
    {
        return static::getArrayRequestRef($key, $else);
    }

    public static function &getArrayRequestRef($key, &$else = null)
    {
        return Arr::getArrayRef($_REQUEST, $key, $else);
    }

    public static function getArrayForceRequest($key, $else = null)
    {
        return static::getArrayForceRequestRef($key, $else);
    }

    public static function &getArrayForceRequestRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($_REQUEST, $key, $else);
    }

    public static function getIndexRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexRequestRef($index, $else, $delimiter);
    }

    public static function &getIndexRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_REQUEST, $index, $else, $delimiter);
    }

    public static function getIndexForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceRequestRef($index, $else, $delimiter);
    }

    public static function &getIndexForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_REQUEST, $index, $else, $delimiter);
    }

    public static function getIndexArrayRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayRequestRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_REQUEST, $index, $else, $delimiter);
    }

    public static function getIndexArrayForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceRequestRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_REQUEST, $index, $else, $delimiter);
    }

    public static function delRequest($key)
    {
        return Arr::delRef($_REQUEST, $key);
    }

    public static function delIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_REQUEST, $index, $delimiter);
    }

    // End standard $_REQUEST array methods

    // Start standard $_FILES array methods

    public static function isFiles()
    {
        return (bool) $_FILES;
    }

    public static function allFiles()
    {
        return $_FILES;
    }

    public static function hasFiles($key)
    {
        return Arr::hasRef($_FILES, $key);
    }

    public static function hasIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_FILES, $index, $delimiter);
    }

    public static function setFiles($key, $value)
    {
        return static::setFilesRef($key, $value);
    }

    public static function setFilesRef($key, &$value)
    {
        return Arr::setRefValueRef($_FILES, $key, $value);
    }

    public static function setIndexFiles($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexFilesRef($index, $value, $delimiter);
    }

    public static function setIndexFilesRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_FILES, $index, $value, $delimiter);
    }

    public static function getFiles($key, $else = null)
    {
        return static::getFilesRef($key, $else);
    }

    public static function &getFilesRef($key, $else = null)
    {
        return Arr::getRef($_FILES, $key, $else);
    }

    public static function getForceFiles($key, $else = null)
    {
        return static::getForceFilesRef($key, $else);
    }

    public static function &getForceFilesRef($key, $else = null)
    {
        return Arr::getForceRef($_FILES, $key, $else);
    }

    public static function getArrayFiles($key, $else = null)
    {
        return static::getArrayFilesRef($key, $else);
    }

    public static function &getArrayFilesRef($key, $else = null)
    {
        return Arr::getArrayRef($_FILES, $key, $else);
    }

    public static function getArrayForceFiles($key, $else = null)
    {
        return static::getArrayForceFilesRef($key, $else);
    }

    public static function &getArrayForceFilesRef($key, $else = null)
    {
        return Arr::getArrayForceRef($_FILES, $key, $else);
    }

    public static function getIndexFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexFilesRef($index, $else, $delimiter);
    }

    public static function &getIndexFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_FILES, $index, $else, $delimiter);
    }

    public static function getIndexForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceFilesRef($index, $else, $delimiter);
    }

    public static function &getIndexForceFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_FILES, $index, $else, $delimiter);
    }

    public static function getIndexArrayFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayFilesRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_FILES, $index, $else, $delimiter);
    }

    public static function getIndexArrayForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceFilesRef($index, $else, $delimiter);
    }

    public static function &getIndexArrayForceFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_FILES, $index, $else, $delimiter);
    }

    public static function delFiles($key)
    {
        return Arr::delRef($_FILES, $key);
    }

    public static function delIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_FILES, $index, $delimiter);
    }

    // End standard $_FILES array methods

    public static function humanReadableFiles()
    {
        $_FILES = static::humanReadableData($_FILES);

        return $_FILES;
    }

    public static function humanReadableData($data)
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
            return;
        }

        static::checkFile($file, $mimes);

        return $file;
    }

    public static function getIndexFile($name, $mimes = [])
    {
        $file = static::getIndexFiles($name);

        if (!$file or !$file['tmp_name']) {
            return;
        }

        static::checkFile($file, $mimes);

        return $file;
    }

    public static function checkFile($file, $mimes = [])
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Upload file error: '.static::UPLOAD_ERR[$file['error']]);
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new \Exception('Possible file upload attack.');
        }

        if ($mimes and !in_array($file['type'], (array) $mimes)) {
            throw new \Exception('Wrong file type was uploaded. Valid types are: '.implode(', ', $mimes));
        }

        return true;
    }

    public static function delAll($key)
    {
        Arr::del($_GET, $key);

        Arr::del($_POST, $key);

        Arr::del($_REQUEST, $key);

        Arr::del($_FILES, $key);

        return true;
    }
}
