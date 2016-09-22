<?php

namespace Greg\Support\Http;

use Greg\Support\Accessor\ArrayAccessTrait;
use Greg\Support\Arr;

class Request
{
    use ArrayAccessTrait, RequestStaticTrait;

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

    public function hasParams()
    {
        return (bool) $this->accessor;
    }

    public function getAll()
    {
        return $this->accessor;
    }

    public function setAll(array $params)
    {
        $this->setAccessor($params);

        return $this;
    }

    public function &getRef($key, &$else = null)
    {
        return Arr::getRef($this->accessor, $key, $this->getRequestRef($key, $else));
    }

    public function &getForceRef($key, &$else = null)
    {
        return Arr::getForceRef($this->accessor, $key, $this->getForceRequestRef($key, $else));
    }

    public function &getArrayRef($key, &$else = null)
    {
        return Arr::getArrayRef($this->accessor, $key, $this->getArrayRequestRef($key, $else));
    }

    public function &getArrayForceRef($key, &$else = null)
    {
        return Arr::getArrayForceRef($this->accessor, $key, $this->getArrayForceRequestRef($key, $else));
    }

    public function &getIndexRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexRef(
            $this->accessor,
            $index,
            $this->getIndexRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function &getIndexForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexForceRef(
            $this->accessor,
            $index,
            $this->getIndexForceRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function &getIndexArrayRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayRef(
            $this->accessor,
            $index,
            $this->getIndexArrayRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function &getIndexArrayForceRef($index, &$else = null, $delimiter = Arr::INDEX_DELIMITER)
    {
        return Arr::getIndexArrayForceRef(
            $this->accessor,
            $index,
            $this->getIndexArrayForceRequestRef($index, $else, $delimiter),
            $delimiter
        );
    }

    public function __call($method, array $args)
    {
        return $this->__callStatic($method, $args);
    }
}
