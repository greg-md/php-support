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
        UPLOAD_ERR_OK => 'There is no error, the file uploaded with success.',
        UPLOAD_ERR_INI_SIZE => 'The uploaded file exceeds the upload_max_filesize directive in php.ini.',
        UPLOAD_ERR_FORM_SIZE => 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form.',
        UPLOAD_ERR_PARTIAL => 'The uploaded file was only partially uploaded.',
        UPLOAD_ERR_NO_FILE => 'No file was uploaded.',
        UPLOAD_ERR_NO_TMP_DIR => 'Missing a temporary folder.', // Introduced in PHP 4.3.10 and PHP 5.0.3.
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.', // Introduced in PHP 5.1.0.
        UPLOAD_ERR_EXTENSION => 'A PHP extension stopped the file upload.', // Introduced in PHP 5.2.0.
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
        return (bool)$this->storage;
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

    static public function protocol()
    {
        return Server::get('SERVER_PROTOCOL');
    }

    static public function clientHost()
    {
        return Server::get('HTTP_HOST');
    }

    static public function serverHost()
    {
        return Server::get('SERVER_NAME');
    }

    static public function serverAdmin()
    {
        return Server::get('SERVER_ADMIN');
    }

    static public function secured()
    {
        return Server::get('HTTPS');
    }

    static public function isSecured()
    {
        return static::secured() == 'on';
    }

    static public function with()
    {
        return Server::get('HTTP_X_REQUESTED_WITH');
    }

    static public function port()
    {
        return Server::get('SERVER_PORT');
    }

    static public function agent()
    {
        return Server::get('HTTP_USER_AGENT');
    }

    static public function ip()
    {
        return Server::get('REMOTE_ADDR');
    }

    static public function uri()
    {
        return Server::get('REQUEST_URI');
    }

    static public function baseUri()
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

    static public function uriPath()
    {
        list($path) = explode('?', static::uri(), 2);

        return $path;
    }

    static public function uriQuery()
    {
        list($path, $query) = array_pad(explode('?', static::uri(), 2), 2, null);

        unset($path);

        return $query;
    }

    static public function relativeUri()
    {
        $uri = static::uri();

        $baseUri = static::baseUri();

        return $baseUri !== '/' ? mb_substr($uri, mb_strlen($baseUri)) : $uri;
    }

    static public function relativeUriPath()
    {
        list($path) = explode('?', static::relativeUri(), 2);

        return $path;
    }

    static public function relativeUriQuery()
    {
        list($path, $query) = array_pad(explode('?', static::relativeUri(), 2), 2, null);

        unset($path);

        return $query;
    }

    static public function referrer()
    {
        return Server::get('HTTP_REFERER');
    }

    static public function modifiedSince()
    {
        return Server::get('HTTP_IF_MODIFIED_SINCE');
    }

    static public function match()
    {
        return Server::get('HTTP_IF_NONE_MATCH');
    }

    static public function time()
    {
        return Server::requestTime();
    }

    static public function microTime()
    {
        return Server::requestMicroTime();
    }

    static public function ajax()
    {
        return static::with() == 'XMLHttpRequest';
    }

    static public function header($header)
    {
        $header = strtoupper($header);

        $header = str_replace('-', '_', $header);

        return Server::get('HTTP_' . $header);
    }

    // Start standard $_GET array methods

    static public function isGet()
    {
        return (bool)$_GET;
    }

    static public function allGet()
    {
        return $_GET;
    }

    static public function hasGet($key)
    {
        return Arr::hasRef($_GET, $key);
    }

    static public function hasIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_GET, $index, $delimiter);
    }

    static public function setGet($key, $value)
    {
        return static::setGetRef($key, $value);
    }

    static public function setGetRef($key, &$value)
    {
        return Arr::setRefValueRef($_GET, $key, $value);
    }

    static public function setIndexGet($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexGetRef($index, $value, $delimiter);
    }

    static public function setIndexGetRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_GET, $index, $value, $delimiter);
    }

    static public function getGet($key, $else = null)
    {
        return static::getGetRef($key, $else);
    }

    static public function &getGetRef($key, &$else = null)
    {
        return Arr::getRef($_GET, $key, $else);
    }

    static public function getForceGet($key, $else = null)
    {
        return static::getForceGetRef($key, $else);
    }

    static public function &getForceGetRef($key, &$else = null)
    {
        return Arr::getForceRef($_GET, $key, $else);
    }

    static public function getArrayGet($key, $else = null)
    {
        return static::getArrayGetRef($key, $else);
    }

    static public function &getArrayGetRef($key, &$else = null)
    {
        return Arr::getArrayRef($_GET, $key, $else);
    }

    static public function getArrayForceGet($key, $else = null)
    {
        return static::getArrayForceGetRef($key, $else);
    }

    static public function &getArrayForceGetRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($_GET, $key, $else);
    }

    static public function getIndexGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexGetRef($index, $else, $delimiter);
    }

    static public function &getIndexGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_GET, $index, $else, $delimiter);
    }

    static public function getIndexForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceGetRef($index, $else, $delimiter);
    }

    static public function &getIndexForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_GET, $index, $else, $delimiter);
    }

    static public function getIndexArrayGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayGetRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_GET, $index, $else, $delimiter);
    }

    static public function getIndexArrayForceGet($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceGetRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayForceGetRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_GET, $index, $else, $delimiter);
    }

    static public function delGet($key)
    {
        return Arr::delRef($_GET, $key);
    }

    static public function delIndexGet($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_GET, $index, $delimiter);
    }

    // End standard $_GET array methods

    // Start standard $_POST array methods

    static public function isPost()
    {
        return (bool)$_POST;
    }

    static public function allPost()
    {
        return $_POST;
    }

    static public function hasPost($key)
    {
        return Arr::hasRef($_POST, $key);
    }

    static public function hasIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_POST, $index, $delimiter);
    }

    static public function setPost($key, $value)
    {
        return static::setPostRef($key, $value);
    }

    static public function setPostRef($key, &$value)
    {
        return Arr::setRefValueRef($_POST, $key, $value);
    }

    static public function setIndexPost($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexPostRef($index, $value, $delimiter);
    }

    static public function setIndexPostRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_POST, $index, $value, $delimiter);
    }

    static public function getPost($key, $else = null)
    {
        return static::getPostRef($key, $else);
    }

    static public function &getPostRef($key, &$else = null)
    {
        return Arr::getRef($_POST, $key, $else);
    }

    static public function getForcePost($key, $else = null)
    {
        return static::getForcePostRef($key, $else);
    }

    static public function &getForcePostRef($key, &$else = null)
    {
        return Arr::getForceRef($_POST, $key, $else);
    }

    static public function getArrayPost($key, $else = null)
    {
        return static::getArrayPostRef($key, $else);
    }

    static public function &getArrayPostRef($key, &$else = null)
    {
        return Arr::getArrayRef($_POST, $key, $else);
    }

    static public function getArrayForcePost($key, $else = null)
    {
        return static::getArrayForcePostRef($key, $else);
    }

    static public function &getArrayForcePostRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($_POST, $key, $else);
    }

    static public function getIndexPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexPostRef($index, $else, $delimiter);
    }

    static public function &getIndexPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_POST, $index, $else, $delimiter);
    }

    static public function getIndexForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForcePostRef($index, $else, $delimiter);
    }

    static public function &getIndexForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_POST, $index, $else, $delimiter);
    }

    static public function getIndexArrayPost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayPostRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayPostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_POST, $index, $else, $delimiter);
    }

    static public function getIndexArrayForcePost($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForcePostRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayForcePostRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_POST, $index, $else, $delimiter);
    }

    static public function delPost($key)
    {
        return Arr::delRef($_POST, $key);
    }

    static public function delIndexPost($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_POST, $index, $delimiter);
    }

    // End standard $_POST array methods

    static public function isRequest()
    {
        return (bool)$_REQUEST;
    }

    static public function allRequest()
    {
        return $_REQUEST;
    }

    static public function hasRequest($key)
    {
        return Arr::hasRef($_REQUEST, $key);
    }

    static public function hasIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_REQUEST, $index, $delimiter);
    }

    static public function setRequest($key, $value)
    {
        return static::setRequestRef($key, $value);
    }

    static public function setRequestRef($key, &$value)
    {
        return Arr::setRefValueRef($_REQUEST, $key, $value);
    }

    static public function setIndexRequest($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexRequestRef($index, $value, $delimiter);
    }

    static public function setIndexRequestRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_REQUEST, $index, $value, $delimiter);
    }

    static public function getRequest($key, $else = null)
    {
        return static::getRequestRef($key, $else);
    }

    static public function &getRequestRef($key, &$else = null)
    {
        return Arr::getRef($_REQUEST, $key, $else);
    }

    static public function getForceRequest($key, $else = null)
    {
        return static::getForceRequestRef($key, $else);
    }

    static public function &getForceRequestRef($key, &$else = null)
    {
        return Arr::getForceRef($_REQUEST, $key, $else);
    }

    static public function getArrayRequest($key, $else = null)
    {
        return static::getArrayRequestRef($key, $else);
    }

    static public function &getArrayRequestRef($key, &$else = null)
    {
        return Arr::getArrayRef($_REQUEST, $key, $else);
    }

    static public function getArrayForceRequest($key, $else = null)
    {
        return static::getArrayForceRequestRef($key, $else);
    }

    static public function &getArrayForceRequestRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($_REQUEST, $key, $else);
    }

    static public function getIndexRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexRequestRef($index, $else, $delimiter);
    }

    static public function &getIndexRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_REQUEST, $index, $else, $delimiter);
    }

    static public function getIndexForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceRequestRef($index, $else, $delimiter);
    }

    static public function &getIndexForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_REQUEST, $index, $else, $delimiter);
    }

    static public function getIndexArrayRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayRequestRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_REQUEST, $index, $else, $delimiter);
    }

    static public function getIndexArrayForceRequest($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceRequestRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayForceRequestRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_REQUEST, $index, $else, $delimiter);
    }

    static public function delRequest($key)
    {
        return Arr::delRef($_REQUEST, $key);
    }

    static public function delIndexRequest($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_REQUEST, $index, $delimiter);
    }

    // End standard $_REQUEST array methods

    // Start standard $_FILES array methods

    static public function isFiles()
    {
        return (bool)$_FILES;
    }

    static public function allFiles()
    {
        return $_FILES;
    }

    static public function hasFiles($key)
    {
        return Arr::hasRef($_FILES, $key);
    }

    static public function hasIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($_FILES, $index, $delimiter);
    }

    static public function setFiles($key, $value)
    {
        return static::setFilesRef($key, $value);
    }

    static public function setFilesRef($key, &$value)
    {
        return Arr::setRefValueRef($_FILES, $key, $value);
    }

    static public function setIndexFiles($index, $value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::setIndexFilesRef($index, $value, $delimiter);
    }

    static public function setIndexFilesRef($index, &$value, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::setIndexRefValueRef($_FILES, $index, $value, $delimiter);
    }

    static public function getFiles($key, $else = null)
    {
        return static::getFilesRef($key, $else);
    }

    static public function &getFilesRef($key, $else = null)
    {
        return Arr::getRef($_FILES, $key, $else);
    }

    static public function getForceFiles($key, $else = null)
    {
        return static::getForceFilesRef($key, $else);
    }

    static public function &getForceFilesRef($key, $else = null)
    {
        return Arr::getForceRef($_FILES, $key, $else);
    }

    static public function getArrayFiles($key, $else = null)
    {
        return static::getArrayFilesRef($key, $else);
    }

    static public function &getArrayFilesRef($key, $else = null)
    {
        return Arr::getArrayRef($_FILES, $key, $else);
    }

    static public function getArrayForceFiles($key, $else = null)
    {
        return static::getArrayForceFilesRef($key, $else);
    }

    static public function &getArrayForceFilesRef($key, $else = null)
    {
        return Arr::getArrayForceRef($_FILES, $key, $else);
    }

    static public function getIndexFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexFilesRef($index, $else, $delimiter);
    }

    static public function &getIndexFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($_FILES, $index, $else, $delimiter);
    }

    static public function getIndexForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexForceFilesRef($index, $else, $delimiter);
    }

    static public function &getIndexForceFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef($_FILES, $index, $else, $delimiter);
    }

    static public function getIndexArrayFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayFilesRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($_FILES, $index, $else, $delimiter);
    }

    static public function getIndexArrayForceFiles($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return static::getIndexArrayForceFilesRef($index, $else, $delimiter);
    }

    static public function &getIndexArrayForceFilesRef($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef($_FILES, $index, $else, $delimiter);
    }

    static public function delFiles($key)
    {
        return Arr::delRef($_FILES, $key);
    }

    static public function delIndexFiles($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::delIndexRef($_FILES, $index, $delimiter);
    }

    // End standard $_FILES array methods

    static public function humanReadableFiles()
    {
        $_FILES = static::humanReadableData($_FILES);

        return $_FILES;
    }

    static public function humanReadableData($data)
    {
        foreach($data as &$item) {
            if (is_array(current($item))) {
                $newItem = [];

                foreach($item as $key => $value) {
                    static::addNewArrayLevel($value, $key);

                    $newItem = array_replace_recursive($newItem, $value);
                }

                $item = $newItem;
            }
        }

        unset($item);

        return $data;
    }

    static protected function addNewArrayLevel(&$array, $key)
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

    static public function getFile($name, $mimes = [])
    {
        $file = static::getFiles($name);

        if (!$file or !$file['tmp_name']) {
            return null;
        }

        static::checkFile($file, $mimes);

        return $file;
    }

    static public function getIndexFile($name, $mimes = [])
    {
        $file = static::getIndexFiles($name);

        if (!$file or !$file['tmp_name']) {
            return null;
        }

        static::checkFile($file, $mimes);

        return $file;
    }

    static public function checkFile($file, $mimes = [])
    {
        if ($file['error'] !== UPLOAD_ERR_OK) {
            throw new \Exception('Upload file error: ' . static::UPLOAD_ERR[$file['error']]);
        }

        if (!is_uploaded_file($file['tmp_name'])) {
            throw new \Exception('Possible file upload attack.');
        }

        if ($mimes and !in_array($file['type'], (array)$mimes)) {
            throw new \Exception('Wrong file type was uploaded. Valid types are: ' . implode(', ', $mimes));
        }

        return true;
    }

    static public function delAll($key)
    {
        Arr::del($_GET, $key);

        Arr::del($_POST, $key);

        Arr::del($_REQUEST, $key);

        Arr::del($_FILES, $key);

        return true;
    }
}