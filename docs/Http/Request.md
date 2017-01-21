# Http Request Documentation

`\Greg\Support\Http\Request` is working with `http request` in an object-oriented way.

Throws: `\Greg\Support\Http\RequestException`.

# Constants

```php
const TYPE_GET = 'GET';

const TYPE_HEAD = 'HEAD';

const TYPE_POST = 'POST';

const TYPE_PUT = 'PUT';

const TYPE_DELETE = 'DELETE';

const TYPE_CONNECT = 'CONNECT';

const TYPE_OPTIONS = 'OPTIONS';

const TYPE_TRACE = 'TRACE';

const TYPE_PATCH = 'PATCH';

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
```

# Methods:

* [__construct](#__construct) - Constructor;
* [validate](#validate) - Validate params;
* [protocol](#protocol) - Get protocol;
* [clientHost](#clientHost) - Get client host;
* [serverHost](#serverHost) - Get server host;
* [serverAdmin](#serverAdmin) - Get server admin;
* [secured](#secured) - Get secured state;
* [isSecured](#isSecured) - Determine if secured;
* [with](#with) - Get requested with;
* [port](#port) - Get port;
* [agent](#agent) - Get agent;
* [ip](#ip) - Get IP;
* [uri](#uri) - Get URI;
* [method](#method) - Get method;
* [baseUri](#baseUri) - Get base URI;
* [uriPath](#uriPath) - Get URI path;
* [uriQuery](#uriQuery) - Get URI query;
* [relativeUri](#relativeUri) - Get relative URI;
* [relativeUriPath](#relativeUriPath) - Get relative URI path;
* [referrer](#referrer) - Get referrer;
* [modifiedSince](#modifiedSince) - Get modified since;
* [match](#match) - Get match;
* [time](#time) - Get time;
* [microTime](#microTime) - Get micro time;
* [isAjax](#isAjax) - Determine if request is an ajax request;
* [header](#header) - Get a header;
* [humanReadableFiles](#humanReadableFiles) - Transform `$_FILES` to human readable data;
* [has](#has) - Determine if has a key or an array of keys in `$_REQUEST`;
* [hasIndex](#hasIndex) - Determine if has an index or an array of indexes in `$_REQUEST`;
* [param](#param) - Get a param or an array of params by key from `$_REQUEST`;
* [paramArray](#paramArray) - Get an array param or an array of array params from `$_REQUEST`;
* [paramIndex](#paramIndex) - Get a param or an array of params by index from `$_REQUEST`;
* [paramIndexArray](#paramIndexArray) - Get an array param or an array of array params by index from `$_REQUEST`;
* [hasGet](#hasGet) - Determine if has a key or an array of keys in `$_GET`;
* [hasIndexGet](#hasIndexGet) - Determine if has an index or an array of indexes in `$_GET`;
* [get](#get) - Get a param or an array of params by key from `$_GET`;
* [getArray](#getArray) - Get an array param or an array of array params from `$_GET`;
* [getIndex](#getIndex) - Get a param or an array of params by index from `$_GET`;
* [getIndexArray](#getIndexArray) - Get an array param or an array of array params by index from `$_GET`;
* [hasPost](#hasPost) - Determine if has a key or an array of keys in `$_POST`;
* [hasIndexPost](#hasIndexPost) - Determine if has an index or an array of indexes in `$_POST`;
* [post](#post) - Get a param or an array of params by key from `$_POST`;
* [postArray](#postArray) - Get an array param or an array of array params from `$_POST`;
* [postIndex](#postIndex) - Get a param or an array of params by index from `$_POST`;
* [postIndexArray](#postIndexArray) - Get an array param or an array of array params by index from `$_POST`;
* [hasFile](#hasFile) - Determine if has a key or an array of keys in `$_FILES`;
* [hasIndexFile](#hasIndexFile) - Determine if has an index or an array of indexes in `$_FILES`;
* [file](#file) - Get a param or an array of params by key from `$_FILES`;
* [fileArray](#fileArray) - Get an array param or an array of array params from `$_FILES`;
* [fileIndex](#fileIndex) - Get a param or an array of params by index from `$_FILES`;
* [fileIndexArray](#fileIndexArray) - Get an array param or an array of array params by index from `$_FILES`;

## method

Description.

```php
method(mixed ...$args): mixed
```

`...$args` - Arguments.

_Example:_

```php
\Greg\Support\Image::method(...$args);
```
