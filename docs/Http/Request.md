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

* [validate](#validate) - Validate params;
* [protocol](#protocol) - Get protocol;
* [clientHost](#clienthost) - Get client host;
* [serverHost](#serverhost) - Get server host;
* [serverAdmin](#serveradmin) - Get server admin;
* [secured](#secured) - Get secured state;
* [isSecured](#issecured) - Determine if secured;
* [with](#with) - Get requested with;
* [port](#port) - Get port;
* [agent](#agent) - Get agent;
* [ip](#ip) - Get IP;
* [uri](#uri) - Get URI;
* [method](#method) - Get method;
* [baseUri](#baseuri) - Get base URI;
* [uriPath](#uripath) - Get URI path;
* [uriQuery](#uriquery) - Get URI query;
* [relativeUri](#relativeuri) - Get relative URI;
* [relativeUriPath](#relativeuripath) - Get relative URI path;
* [referrer](#referrer) - Get referrer;
* [modifiedSince](#modifiedsince) - Get modified since;
* [match](#match) - Get match;
* [time](#time) - Get time;
* [microTime](#microtime) - Get micro time;
* [isAjax](#isajax) - Determine if request is an ajax request;
* [header](#header) - Get a header;
* [humanReadableFiles](#humanreadablefiles) - Transform `$_FILES` to human readable data;
* [has](#has) - Determine if has a key or an array of keys in `$_REQUEST`;
* [hasIndex](#hasindex) - Determine if has an index or an array of indexes in `$_REQUEST`;
* [param](#param) - Get a param or an array of params by key from `$_REQUEST`;
* [paramArray](#paramarray) - Get an array param or an array of array params from `$_REQUEST`;
* [paramIndex](#paramindex) - Get a param or an array of params by index from `$_REQUEST`;
* [paramIndexArray](#paramindexarray) - Get an array param or an array of array params by index from `$_REQUEST`;
* [hasGet](#hasget) - Determine if has a key or an array of keys in `$_GET`;
* [hasIndexGet](#hasindexget) - Determine if has an index or an array of indexes in `$_GET`;
* [get](#get) - Get a param or an array of params by key from `$_GET`;
* [getArray](#getarray) - Get an array param or an array of array params from `$_GET`;
* [getIndex](#getindex) - Get a param or an array of params by index from `$_GET`;
* [getIndexArray](#getindexarray) - Get an array param or an array of array params by index from `$_GET`;
* [hasPost](#haspost) - Determine if has a key or an array of keys in `$_POST`;
* [hasIndexPost](#hasindexpost) - Determine if has an index or an array of indexes in `$_POST`;
* [post](#post) - Get a param or an array of params by key from `$_POST`;
* [postArray](#postarray) - Get an array param or an array of array params from `$_POST`;
* [postIndex](#postindex) - Get a param or an array of params by index from `$_POST`;
* [postIndexArray](#postindexarray) - Get an array param or an array of array params by index from `$_POST`;
* [hasFile](#hasfile) - Determine if has a key or an array of keys in `$_FILES`;
* [hasIndexFile](#hasindexfile) - Determine if has an index or an array of indexes in `$_FILES`;
* [file](#file) - Get a param or an array of params by key from `$_FILES`;
* [fileArray](#filearray) - Get an array param or an array of array params from `$_FILES`;
* [fileIndex](#fileindex) - Get a param or an array of params by index from `$_FILES`;
* [fileIndexArray](#fileindexarray) - Get an array param or an array of array params by index from `$_FILES`.

**Magic methods:**

* [__construct](#__construct);

**Methods description is under construction.**
