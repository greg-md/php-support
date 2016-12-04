<?php

namespace Greg\Support\Http;

use Greg\Support\Accessor\AccessorTrait;
use Greg\Support\Arr;

class Request
{
    use AccessorTrait, RequestStaticTrait;

    const TYPE_GET = 'GET';

    const TYPE_HEAD = 'HEAD';

    const TYPE_POST = 'POST';

    const TYPE_PUT = 'PUT';

    const TYPE_DELETE = 'DELETE';

    const TYPE_CONNECT = 'CONNECT';

    const TYPE_OPTIONS = 'OPTIONS';

    const TYPE_TRACE = 'TRACE';

    const TYPE_PATCH = 'PATCH';

    const URI_ALL = 'all';

    const URI_PATH = 'path';

    const URI_QUERY = 'query';

    const UPLOAD_ERROR = [
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
        $this->setAccessor($params);

        return $this;
    }

    public function getAll()
    {
        return $this->accessor;
    }

    public function hasParams()
    {
        return (bool) $this->accessor;
    }

    public function has($key)
    {
        return Arr::hasRef($this->accessor, $key);
    }

    public function hasIndex($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndexRef($this->accessor, $index, $delimiter);
    }

    public function get($key, $else = null)
    {
        return Arr::getRef($this->accessor, $key, $else);
    }

    public function getArray($key, $else = null)
    {
        return Arr::getArrayRef($this->accessor, $key, $else);
    }

    public function getIndex($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef($this->accessor, $index, $else, $delimiter);
    }

    public function getIndexArray($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef($this->accessor, $index, $else, $delimiter);
    }

    public function getAllParam()
    {
        return $this->accessor + $this->getAllRequest();
    }

    public function hasParamParams()
    {
        return (bool) $this->getAllParam();
    }

    public function hasParam($key)
    {
        return Arr::has($this->getAllParam(), $key);
    }

    public function hasIndexParam($index, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::hasIndex($this->getAllParam(), $index, $delimiter);
    }

    public function getParam($key, $else = null)
    {
        return Arr::get($this->getAllParam(), $key, $else);
    }

    public function getArrayParam($key, $else = null)
    {
        return Arr::getArray($this->getAllParam(), $key, $else);
    }

    public function getIndexParam($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndex($this->getAllParam(), $index, $else, $delimiter);
    }

    public function getIndexArrayParam($index, $else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArray($this->getAllParam(), $index, $else, $delimiter);
    }

    public function __call($method, array $args)
    {
        return $this->__callStatic($method, $args);
    }
}
