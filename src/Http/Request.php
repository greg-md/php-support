<?php

namespace Greg\Support\Http;

use Greg\Support\Accessor\AccessorTrait;

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
        UPLOAD_ERR_NO_TMP_DIR => 'Missing the temporary folder.',
        UPLOAD_ERR_CANT_WRITE => 'Failed to write file to disk.',
        UPLOAD_ERR_EXTENSION  => 'A PHP extension stopped the file upload.',
    ];

    public function __construct(array $validators = [])
    {
    }
}
